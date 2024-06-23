import datetime
import traceback

from flask import request, jsonify, render_template
from sqlalchemy import cast, Date

from models.Result import Result
from models.Setting import Setting
from service.MarketService import get_markets_with_result
from service.UserService import validate_session, get_user_by_id


def web_index():
    results = Result.query.filter_by(date=cast(datetime.date.today(), Date)).all()
    data = {}
    for result in results:
        data[result.market_name.upper()] = result.jodi if result.jodi else "**"
    return render_template("windex.html", results=data)


def dashboard():
    try:
        user_id, is_admin = validate_session()
        user_details = get_user_by_id(user_id)
        markets = get_markets_with_result()

        settings = Setting.query.all()
        settings_map = {setting.key: setting.value for setting in settings}
        banners = Setting.query.filter_by(key=Setting.Key.BANNER_IMAGE.name).first()

        if banners and banners.valueList:
            banner_images = [{"image": url} for url in banners.valueList]
        else:
            banner_images = []

        data = {
            "markets": markets,
            "min_deposit": settings_map.get(Setting.Key.MIN_DEPOSIT.name),
            "whatsapp": settings_map.get(Setting.Key.WHATSAPP.name),
            "telegram": settings_map.get(Setting.Key.TELEGRAM_ID.name),
            "min_withdraw": settings_map.get(Setting.Key.MIN_WITHDRAW.name),
            "upi": settings_map.get(Setting.Key.UPI_ID.name),
            "merchant": settings_map.get(Setting.Key.MERCHANT.name),
            "withdrawOpenTime": settings_map.get(Setting.Key.WITHDRAW_OPEN_TIME.name),
            "withdrawCloseTime": settings_map.get(Setting.Key.WITHDRAW_CLOSE_TIME.name),
            "gateway": settings_map.get(Setting.Key.IS_ONLINE_PAYMENT.name),
            "wallet": int(user_details.total_balance),
            "winning": int(user_details.winning_balance),
            "bonus": int(user_details.bonus_balance),
            "active": "1" if user_details.active else 0,
            "logout": "0",
            "bank_details": settings_map.get(Setting.Key.BANK_DETAILS.name),
            "homeline": "",
            "images": banner_images,
            "code": user_details.referral_code if user_details.referral_code else "NA",
        }
        return jsonify(data), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error fetching details'}), 500
