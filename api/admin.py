import os
import uuid
from datetime import datetime, timedelta

from flask import render_template, request, jsonify, session
from sqlalchemy import func, cast, Date

from extension import db
from models.AppUpdate import AppUpdate
from models.Bet import Bet
from models.Market import Market
from models.Rate import Rate
from models.Result import Result
from models.Setting import Setting
from models.Transaction import Transaction
from models.User import User
from models.WithdrawMode import WithdrawMode
from service.BetService import fetch_bets
from service.JwtToken import generate_jwt, verify_jwt
from service.ResultService import update_result, revert_result
from service.TransactionService import update_transaction, fetch_transactions
from service.UserService import update_user_balance_and_create_transaction


def admin_login_index():
    return render_template("login.html")


def admin_api_login():
    data = request.get_json()
    username = data.get('email')
    password = data.get('password')

    if not username:
        return jsonify({"success": False, "message": "Username is required"}), 400
    if not password:
        return jsonify({"success": False, "message": "Password is required"}), 400

    user = User.query.filter_by(email=username).first()
    if not user:
        return jsonify({"success": False, "message": "User not found"}), 404

    if user.password != password:
        return jsonify({"success": False, "message": "Invalid Password"}), 401

    if not user.is_admin:
        return jsonify({"success": False, "message": "User is not admin"}), 401

    jwt_token = generate_jwt({"user_id": user.id, "is_admin": True}, is_admin=True)
    session['jwt_token'] = jwt_token
    session['user_id'] = user.id

    return jsonify({"success": True}), 200


def admin_change_password_index():
    validateAdmin()
    return render_template("change_password.html")


def admin_api_change_password():
    validateAdmin()
    data = request.get_json()
    user_id = session.get('user_id', None)
    old_password = data.get('old_password')
    new_password = data.get('new_password')

    if not user_id:
        return jsonify({"success": False, "message": "User ID is required"}), 400
    if not old_password:
        return jsonify({"success": False, "message": "Old Password is required"}), 400
    if not new_password:
        return jsonify({"success": False, "message": "New Password is required"}), 400

    user = User.query.get(user_id)
    if not user:
        return jsonify({"success": False, "message": "User not found"}), 404

    if user.password != old_password:
        return jsonify({"success": False, "message": "Invalid Old Password"}), 401

    user.password = new_password
    db.session.add(user)
    db.session.commit()

    return jsonify({"success": True}), 200


def validateAdmin():
    if session is None:
        raise Exception("Unauthorized")

    jwt_token = session.get('jwt_token', None)
    if not jwt_token:
        raise Exception("Unauthorized")

    payload = verify_jwt(jwt_token, is_admin=True)
    if not payload or not payload.get('is_admin', False):
        raise Exception("Unauthorized")


def admin_logout_index():
    validateAdmin()
    session.pop('jwt_token', None)
    session.pop('user_id', None)
    return render_template('login.html')


def admin_index():
    validateAdmin()
    current_date = datetime.now().date()

    total_users = User.query.count()
    today_users = User.query.filter(User.created_at >= current_date).count()
    today_bets = Bet.query.filter(Bet.created_at >= current_date).count()
    today_deposit = Transaction.query.filter_by(type='DEPOSIT').filter(Transaction.created_at >= current_date).count()
    today_withdrawal = Transaction.query.filter_by(type='WITHDRAWAL').filter(
        Transaction.created_at >= current_date).count()

    today_bid_amount = Bet.query.filter(Bet.date == current_date).with_entities(func.sum(Bet.amount)).scalar()
    if today_bid_amount is None:
        today_bid_amount = 0

    today_win_amount = Bet.query.filter(Bet.date == current_date).filter(Bet.status == "WON").with_entities(
        func.sum(Bet.win_amount)).scalar()
    if today_win_amount is None:
        today_win_amount = 0

    today_profit = today_win_amount - today_bid_amount
    total_wallet_balance = User.query.with_entities(func.sum(User.total_balance)).scalar()
    pending_bets = Bet.query.filter(Bet.status == "PENDING").count()

    today_admin_deposit = Transaction.query.filter_by(type='DEPOSIT') \
        .filter(Transaction.created_at >= current_date) \
        .filter(Transaction.sub_type == "ADD_BY_ADMIN") \
        .with_entities(func.sum(Transaction.amount)).scalar()
    if today_admin_deposit is None:
        today_admin_deposit = 0

    today_admin_withdrawal = Transaction.query.filter_by(type='WITHDRAWAL') \
        .filter(Transaction.created_at >= current_date) \
        .filter(Transaction.sub_type == "DEDUCT_BY_ADMIN") \
        .with_entities(func.sum(Transaction.amount)).scalar()
    if today_admin_withdrawal is None:
        today_admin_withdrawal = 0

    pending_withdrawals = Transaction.query.filter_by(type='WITHDRAWAL') \
        .filter(Transaction.status == "PROCESSING").count()

    return render_template(
        "index.html",
        total_users=total_users,
        today_users=today_users,
        today_bets=today_bets,
        today_deposit=today_deposit,
        today_withdrawal=today_withdrawal,
        today_bid_amount=today_bid_amount,
        today_win_amount=today_win_amount,
        today_profit=today_profit,
        total_wallet_balance=total_wallet_balance,
        pending_bets=pending_bets,
        today_admin_deposit=today_admin_deposit,
        today_admin_withdrawal=today_admin_withdrawal,
        pending_withdrawals=pending_withdrawals,
        date=current_date
    )


def admin_users_index():
    validateAdmin()

    args = request.args
    date = args.get('date', None)
    active = args.get('active', None)

    query = User.query
    if date:
        date = datetime.strptime(date, "%Y-%m-%d")
        query = query.filter(User.created_at >= date)

    if active:
        if active == "0":
            active = False
        else:
            active = True
        print(active)
        query = query.filter(User.active == active)
    users = query.all()
    return render_template("users.html", users=users)


def admin_update_user():
    validateAdmin()

    args = request.args
    user_id = args.get('user_id')
    active = args.get('active')

    print(active)

    if active == "0":
        active = False
    else:
        active = True

    print(active)

    user = User.query.get(user_id)
    user.active = active

    db.session.add(user)
    db.session.commit()
    return jsonify({"success": True}), 200


def admin_update_user_balance():
    validateAdmin()

    args = request.args

    user_id = args.get('user_id')
    amount = float(args.get('amount'))
    wallet_type = args.get('wallet_type')
    action = args.get('action')
    remark = args.get('remark')

    print(user_id, amount, wallet_type, action, remark)

    transaction, error_message = update_user_balance_and_create_transaction(user_id, amount, wallet_type, action,
                                                                            remark)

    if error_message:
        if error_message == "User not found":
            return jsonify({"success": False, "message": error_message}), 404
        else:
            print(error_message)
            return jsonify({"success": False, "message": error_message}), 400

    return jsonify({"success": True}), 200


def admin_markets_index():
    validateAdmin()

    markets = Market.query.all()
    return render_template("delhi_markets.html", markets=markets)


def admin_add_update_market():
    validateAdmin()

    args = request.args
    print(args)
    market_id = args.get('market_id', None)
    name = args.get('name')
    open_time = args.get('open_time')
    close_time = args.get('close_time')
    result_time = args.get('result_time')

    if market_id and market_id != "null":
        print(market_id)
        market = Market.query.get(market_id)
        market.name = name
        market.open_time = open_time
        market.close_time = close_time
        market.result_time = result_time

        db.session.add(market)
        db.session.commit()
    else:
        market = Market(name=name, open_time=open_time, close_time=close_time, result_time=result_time)
        db.session.add(market)
        db.session.commit()

    return jsonify({"success": True}), 200


def admin_add_update_market_index():
    validateAdmin()

    args = request.args
    market_id = args.get('id', None)
    print(market_id)
    if market_id:
        market = Market.query.get(market_id)
    else:
        market = None

    return render_template("add_market.html", market=market)


def admin_delhi_result_update_index():
    validateAdmin()

    markets = Market.query.all()
    return render_template("delhi_result_update.html", markets=markets)


def admin_api_delhi_result_update():
    validateAdmin()

    data = request.get_json()
    market_id = data.get('market_id')
    market_name = data.get('market_name')
    date = data.get('date')
    open_harf = data.get('open_harf')
    jodi = data.get('jodi')
    close_harf = data.get('close_harf')

    if not market_id:
        return jsonify({"success": False, "message": "Market ID is required"}), 400
    if not market_name:
        return jsonify({"success": False, "message": "Market Name is required"}), 400

    if not date:
        return jsonify({"success": False, "message": "Date is required"}), 400
    else:
        try:
            date = datetime.strptime(date, "%d/%m/%Y").date()
        except ValueError:
            return jsonify({"success": False, "message": "Invalid Date Format"}), 400

    if not open_harf:
        return jsonify({"success": False, "message": "Open Harf is required"}), 400
    if not jodi:
        return jsonify({"success": False, "message": "Jodi is required"}), 400
    if not close_harf:
        return jsonify({"success": False, "message": "Close Harf is required"}), 400

    existing_result = Result.query.filter_by(market_id=market_id, date=date).first()
    if existing_result:
        return jsonify({"success": False, "message": "Result already exists for this market and date"}), 400

    update_result(market_id, market_name, date, open_harf, jodi, close_harf)
    return jsonify({"success": True}), 200


def admin_delhi_result_history_index():
    validateAdmin()

    results = Result.query.all()
    return render_template("delhi_result_history.html", results=results)


def admin_api_revert_delhi_result():
    validateAdmin()

    data = request.get_json()
    result_id = data.get('result_id')

    result = Result.query.get(result_id)
    if not result:
        return jsonify({"success": False, "message": "Result not found"}), 404

    revert_result(result)
    return jsonify({"success": True}), 200


def admin_transaction_history_index():
    validateAdmin()

    user_id = request.args.get('user_id')
    type = request.args.get('type')
    status = request.args.get('status')
    from_time = request.args.get('from')
    to_time = request.args.get('to')
    page = request.args.get('page')

    transactions = fetch_transactions(user_id, type, status, from_time, to_time)
    print(transactions)
    return render_template("transactions_history.html", transactions=transactions, page=page)


def admin_api_update_transaction():
    validateAdmin()

    data = request.get_json()
    transaction_id = data.get('id')
    status = data.get('status')
    remark = data.get('remark')
    refund = data.get('refund')

    if not transaction_id:
        return jsonify({"success": False, "message": "Transaction ID is required"}), 400
    if not status:
        return jsonify({"success": False, "message": "Status is required"}), 400

    if refund:
        refund = bool(refund)

    transaction = Transaction.query.get(transaction_id)
    if not transaction:
        return jsonify({"success": False, "message": "Transaction not found"}), 404

    update_transaction(transaction, status, remark, refund)

    return jsonify({"success": True}), 200


def admin_manage_wallet_index():
    validateAdmin()

    args = request.args
    user_id = args.get('user_id', None)

    transactions = (Transaction.query.filter_by(user_id=user_id)
                    .order_by(Transaction.created_at.desc()).all())

    total_deposit = (transactions.filter_by(type='DEPOSIT')
                     .filter_by(status=Transaction.Status.SUCCESS.name).with_entities(func.sum(Transaction.amount)).scalar())
    total_withdrawal = (transactions.filter_by(type='WITHDRAWAL')
                        .filter_by(status=Transaction.Status.SUCCESS.name).with_entities(func.sum(Transaction.amount)).scalar())
    total_bonus = (transactions.filter_by(type='BONUS')
                   .filter_by(status=Transaction.Status.SUCCESS.name).with_entities(func.sum(Transaction.amount)).scalar())
    total_earn = (transactions.filter_by(type='EARN')
                    .filter_by(status=Transaction.Status.SUCCESS.name).with_entities(func.sum(Transaction.amount)).scalar())

    total_winning = (Bet.query.filter_by(user_id=user_id)
                     .filter_by(status='WON').with_entities(func.sum(Bet.win_amount)).scalar())
    total_lost = (Bet.query.filter_by(user_id=user_id)
                    .filter_by(status='LOST').with_entities(func.sum(Bet.win_amount)).scalar())
    total_bid = (Bet.query.filter_by(user_id=user_id).with_entities(func.sum(Bet.win_amount)).scalar())

    return render_template("manage_wallet.html",
                           transactions=transactions,
                           total_deposit=total_deposit,
                           total_withdrawal=total_withdrawal,
                           total_bonus=total_bonus,
                           total_earn=total_earn,
                           total_winning=total_winning,
                           total_lost=total_lost,
                           total_bid=total_bid)


def admin_bet_history_index():
    validateAdmin()

    user_id = request.args.get('user_id')
    market_id = request.args.get('market_id')
    status = request.args.get('status')
    from_time = request.args.get('from')
    to_time = request.args.get('to')
    date = request.args.get('date')
    page = request.args.get('page')

    statues = None
    if status and "," in status:
        statues = status.split(",")
        status = None

    bets = fetch_bets(user_id, market_id, status, from_time, to_time, date, statues)

    return render_template("bet_history.html", bets=bets, page=page)


def admin_image_slider_index():
    validateAdmin()

    setting = Setting.query.filter_by(key=Setting.Key.BANNER_IMAGE.name).first()

    if setting:
        banner_images = setting.valueList
    else:
        banner_images = []
    return render_template("image_slider.html", images=banner_images)


def admin_api_delete_image_slider():
    validateAdmin()

    index = request.args.get('url', None)
    if not index:
        return jsonify({"success": False, "message": "Index is required"}), 400

    setting = Setting.query.filter_by(key=Setting.Key.BANNER_IMAGE.name).first()
    if not setting:
        return jsonify({"success": False, "message": "Setting not found"}), 404

    banner_images = setting.valueList
    new_images = []
    for url in banner_images:
        if url != index:
            new_images.append(url)
    setting.valueList = new_images
    db.session.add(setting)
    db.session.commit()

    return jsonify({"success": True}), 200


def admin_add_image_slider_index():
    validateAdmin()

    return render_template("add_image_slider.html")


def admin_api_add_image_slider():
    validateAdmin()

    image = request.files["image"]

    if image is None:
        return jsonify({'success': False, 'msg': 'Invalid request body'}), 400

    filename = f"{uuid.uuid4().hex[:8]}_{image.filename}"
    file_path = os.path.join("static/images/", filename)
    image.save(file_path)

    setting = Setting.query.filter_by(key=Setting.Key.BANNER_IMAGE.name).first()
    banner_images = []

    if not setting:
        setting = Setting(key=Setting.Key.BANNER_IMAGE.name, valueList=[], value="")
    if len(setting.valueList) > 0:
        for url in setting.valueList:
            banner_images.append(url)
    banner_images.append(file_path)

    setting.valueList = banner_images

    db.session.add(setting)
    db.session.commit()
    return jsonify({"success": True}), 200


def admin_withdraw_modes_index():
    validateAdmin()

    modes = WithdrawMode.query.all()
    return render_template("withdraw_modes.html", modes=modes)


def admin_update_withdraw_mode_index():
    validateAdmin()

    mode_id = request.args.get('mode_id')
    mode = WithdrawMode.query.get(mode_id)
    return render_template("edit_withdraw_mode.html", mode=mode)


def admin_api_update_withdraw_mode():
    validateAdmin()

    data = request.args
    mode_id = data.get('id')
    active = data.get('active')
    name = data.get('name')
    hint_message = data.get('hint_message')

    if not mode_id:
        return jsonify({"success": False, "message": "Mode ID is required"}), 400

    mode = WithdrawMode.query.get(mode_id)
    if not mode:
        return jsonify({"success": False, "message": "Mode not found"}), 404

    if active == "YES":
        mode.active = True
    elif active == "NO":
        mode.active = False

    if hint_message:
        mode.hint_message = hint_message

    if name:
        mode.name = name

    mode.save()
    return jsonify({"success": True}), 200


def admin_rates_index():
    validateAdmin()

    jodi_rate = Rate.query.filter_by(game_type='JODI').first()
    harf_rate = Rate.query.filter_by(game_type='OPEN_HARF').first()

    return render_template("rates.html", jodi=jodi_rate, harf=harf_rate)


def admin_api_update_rate():
    validateAdmin()

    data = request.get_json()
    rate_id = data.get('id')
    new_rate = data.get('rate')
    desc = data.get('desc')
    game_type = data.get('game_type')

    if rate_id:
        rate = Rate.query.get(rate_id)
        if not rate:
            return jsonify({"success": False, "message": "Rate not found"}), 404
    else:
        rate = Rate(game_type=game_type, market_id=-1, market_name="ALL")

    rate.rate = float(new_rate)
    rate.description = desc
    db.session.add(rate)
    db.session.commit()
    return jsonify({"success": True}), 200


def admin_notice_index():
    validateAdmin()

    setting = Setting.query.filter_by(key=Setting.Key.NOTICE.name).first()
    if setting:
        notice = setting.value
    else:
        notice = ""
    return render_template("add_notice.html", notice=notice)


def admin_api_update_setting():
    validateAdmin()

    data = request.get_json()
    id = data.get('id')
    value = data.get('value')

    if not id:
        return jsonify({"success": False, "message": "ID is required"}), 400

    setting = Setting.query.get(id)
    if not setting:
        return jsonify({"success": False, "message": "Setting not found"}), 404

    setting.value = value
    setting.save()
    return jsonify({"success": True}), 200


def admin_settings_index():
    validateAdmin()

    settings = Setting.query.all()

    settingMap = {}
    for setting in settings:
        settingMap[setting.key] = setting
    return render_template("settings.html", setting=settingMap)


def admin_api_update_settings():
    validateAdmin()

    data = request.get_json()
    settings = Setting.query.all()
    formDataMap = {}
    for setting in settings:
        formDataMap[setting.key] = setting.value

    for key, value in data.items():
        if key in formDataMap:
            setting = Setting.query.filter_by(key=key).first()
            setting.value = value
            db.session.add(setting)
            db.session.commit()
        else:
            setting = Setting(key=key, value=value)
            db.session.add(setting)
            db.session.commit()

    return jsonify({"success": True}), 200


def admin_app_update_index():
    updates = AppUpdate.query.all()
    return render_template("app_updates.html", updates=updates)


def admin_add_app_update_index():
    return render_template("add_app_update.html")


def admin_api_add_app_update():
    data = request.get_json()
    print(data)
    version = data.get("version", None)
    link = data.get("link", None)
    log = data.get("log", None)

    if not version or not link:
        return jsonify({"status" : False, "msg" : "Invalid request body"}), 400

    update = AppUpdate(version=int(version), link=link, log=log)
    db.session.add(update)
    db.session.commit()

    return jsonify({"status": True}), 200


def admin_api_remove_app_update():
    id = request.args.get("id", None)

    if not id:
        return jsonify({"status": False, "msg": "Invalid request body"}), 400

    update = AppUpdate.query.get_or_404(id)
    db.session.delete(update)
    db.session.commit()

    return jsonify({"status": True}), 200


def admin_market_anal_index():
    validateAdmin()

    markets = Market.query.all()
    return render_template("market_anal.html", markets=markets)


def admin_market_jantri_index():
    validateAdmin()
    market_id = request.args.get('market')
    date = datetime.today().date()
    game = request.args.get("game")

    if not market_id:
        return jsonify({"success": False, "message": "Market ID is required"}), 400
    if not date:
        return jsonify({"success": False, "message": "Date is required"}), 400
    if not game:
        return jsonify({"success": False, "message": "Game is required"}), 400

    market = Market.query.get(market_id)
    if market.buffer_time:
        print('Buffer Time: ', market.buffer_time, date)
        date = datetime.today() - timedelta(hours=market.buffer_time)
        print(date)
    print(date)
    bets = Bet.query.filter_by(market_id=market_id).filter(Bet.date == cast(date, Date)).all()

    jodi_map = {"00": {"bets": 0, "total": 0}, "01": {"bets": 0, "total": 0}, "02": {"bets": 0, "total": 0}, "03": {"bets": 0, "total": 0}, "04": {"bets": 0, "total": 0}, "05": {"bets": 0, "total": 0}, "06": {"bets": 0, "total": 0}, "07": {"bets": 0, "total": 0}, "08": {"bets": 0, "total": 0}, "09": {"bets": 0, "total": 0}, "10": {"bets": 0, "total": 0}, "11": {"bets": 0, "total": 0}, "12": {"bets": 0, "total": 0}, "13": {"bets": 0, "total": 0}, "14": {"bets": 0, "total": 0}, "15": {"bets": 0, "total": 0}, "16": {"bets": 0, "total": 0}, "17": {"bets": 0, "total": 0}, "18": {"bets": 0, "total": 0}, "19": {"bets": 0, "total": 0}, "20": {"bets": 0, "total": 0}, "21": {"bets": 0, "total": 0}, "22": {"bets": 0, "total": 0}, "23": {"bets": 0, "total": 0}, "24": {"bets": 0, "total": 0}, "25": {"bets": 0, "total": 0}, "26": {"bets": 0, "total": 0}, "27": {"bets": 0, "total": 0}, "28": {"bets": 0, "total": 0}, "29": {"bets": 0, "total": 0}, "30": {"bets": 0, "total": 0}, "31": {"bets": 0, "total": 0},
                "32": {"bets":0, "total": 0}, "33": {"bets": 0, "total": 0}, "34": {"bets": 0, "total": 0}, "35": {"bets": 0, "total": 0}, "36": {"bets": 0, "total": 0}, "37": {"bets": 0, "total": 0}, "38": {"bets": 0, "total": 0}, "39": {"bets": 0, "total": 0}, "40": {"bets": 0, "total": 0}, "41": {"bets": 0, "total": 0}, "42": {"bets": 0, "total": 0}, "43": {"bets": 0, "total": 0}, "44": {"bets": 0, "total": 0}, "45": {"bets": 0, "total": 0}, "46": {"bets": 0, "total": 0}, "47": {"bets": 0, "total": 0}, "48": {"bets": 0, "total": 0}, "49": {"bets": 0, "total": 0}, "50": {"bets": 0, "total": 0}, "51": {"bets": 0, "total": 0}, "52": {"bets": 0, "total": 0}, "53": {"bets": 0, "total": 0}, "54": {"bets": 0, "total": 0}, "55": {"bets": 0, "total": 0}, "56": {"bets": 0, "total": 0}, "57": {"bets": 0, "total": 0}, "58": {"bets": 0, "total": 0}, "59": {"bets": 0, "total": 0}, "60": {"bets": 0, "total": 0}, "61": {"bets": 0, "total": 0}, "62": {"bets": 0, "total": 0}, "63": {"bets": 0, "total": 0}, "64": {"bets": 0, "total": 0}, "65": {"bets": 0, "total": 0},
                "66": {"bets": 0, "total": 0}, "67": {"bets": 0, "total": 0}, "68": {"bets": 0, "total": 0}, "69": {"bets": 0, "total": 0}, "70": {"bets": 0, "total": 0}, "71": {"bets": 0, "total": 0}, "72": {"bets": 0, "total": 0}, "73": {"bets": 0, "total": 0}, "74": {"bets": 0, "total": 0}, "75": {"bets": 0, "total": 0}, "76": {"bets": 0, "total": 0}, "77": {"bets": 0, "total": 0}, "78": {"bets": 0, "total": 0}, "79": {"bets": 0, "total": 0}, "80": {"bets": 0, "total": 0}, "81": {"bets": 0, "total": 0}, "82": {"bets": 0, "total": 0}, "83": {"bets": 0, "total": 0}, "84": {"bets": 0, "total": 0}, "85": {"bets": 0, "total": 0}, "86": {"bets": 0, "total": 0}, "87": {"bets": 0, "total": 0}, "88": {"bets": 0, "total": 0}, "89": {"bets": 0, "total": 0}, "90": {"bets": 0, "total": 0}, "91": {"bets": 0, "total": 0}, "92": {"bets": 0, "total": 0}, "93": {"bets": 0, "total": 0}, "94": {"bets": 0, "total": 0}, "95": {"bets": 0, "total": 0}, "96": {"bets": 0, "total": 0}, "97": {"bets": 0, "total": 0}, "98": {"bets": 0, "total": 0}, "99": {"bets": 0, "total": 0}}

    open_harf_map = {"000": {"bets": 0, "total": 0}, "111": {"bets": 0, "total": 0}, "222": {"bets": 0, "total": 0}, "333": {"bets": 0, "total": 0}, "444": {"bets": 0, "total": 0}, "555": {"bets": 0, "total": 0}, "666": {"bets": 0, "total": 0}, "777": {"bets": 0, "total": 0}, "888": {"bets": 0, "total": 0}, "999": {"bets": 0, "total": 0}}
    close_harf_map = {"000": {"bets": 0, "total": 0}, "111": {"bets": 0, "total": 0}, "222": {"bets": 0, "total": 0}, "333": {"bets": 0, "total": 0}, "444": {"bets": 0, "total": 0}, "555": {"bets": 0, "total": 0}, "666": {"bets": 0, "total": 0}, "777": {"bets": 0, "total": 0}, "888": {"bets": 0, "total": 0}, "999": {"bets": 0, "total": 0}}

    jodi_total = 0
    open_harf_total = 0
    close_harf_total = 0

    tset = set()
    for bet in bets:
        tset.add(bet.date)
        if bet.bet_type == Bet.GameType.JODI.name:
            jodi_map[bet.jodi]["bets"] += 1
            jodi_map[bet.jodi]["total"] += bet.amount
            jodi_total += bet.amount
        elif bet.bet_type == Bet.GameType.OPEN_HARF.name:
            open_harf_map[bet.open_harf]["bets"] += 1
            open_harf_map[bet.open_harf]["total"] += bet.amount
            open_harf_total += bet.amount
        elif bet.bet_type == Bet.GameType.CLOSE_HARF.name:
            close_harf_map[bet.close_harf]["bets"] += 1
            close_harf_map[bet.close_harf]["total"] += bet.amount
            close_harf_total += bet.amount

    print(tset)
    if game == "jodi":
        return render_template("jantri.html", data=jodi_map, total=jodi_total)

    if game == "open_harf":
        return render_template("jantri.html", data=open_harf_map, total=open_harf_total)

    if game == "close_harf":
        return render_template("jantri.html", data=close_harf_map, total=close_harf_total)