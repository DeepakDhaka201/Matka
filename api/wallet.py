import os
import traceback
import uuid
from datetime import datetime

import requests
from flask import jsonify, request

from extension import db
from models.Setting import Setting
from models.Transaction import Transaction
from models.User import User
from models.WithdrawMode import WithdrawMode
from service.BetService import create_withdraw, create_deposit, update_transaction_status, create_deposit2
from service.UserService import validate_session, get_user_by_id, get_transactions, update_user_bank_details


def get_wallet():
    user_id, is_admin = validate_session()
    try:
        user_details = get_user_by_id(user_id)
        transactions = get_transactions(user_id, [Transaction.Type.DEPOSIT.name,
                                                  Transaction.Type.WITHDRAWAL.name])

        if user_details.bank_ac_no is None:
            bank_details = None
        else:
            bank_details = {
                "ac": user_details.bank_ac_no,
                "holder": user_details.bank_ac_name,
                "bank": user_details.bank_name,
                "ifsc": user_details.bank_ifsc_code
            }

        min_withdraw_setting = Setting.query.filter_by(key=Setting.Key.MIN_WITHDRAW.name).first()

        min_withdraw = 500
        if min_withdraw_setting:
            min_withdraw = int(min_withdraw_setting.value)

        withdraw_open_time_setting = Setting.query.filter_by(key=Setting.Key.WITHDRAW_OPEN_TIME.name).first()
        withdraw_close_time_setting = Setting.query.filter_by(key=Setting.Key.WITHDRAW_CLOSE_TIME.name).first()

        withdraw_open = "1"
        withdraw_msg = ""
        if withdraw_open_time_setting and withdraw_close_time_setting:
            withdraw_open_time_obj = datetime.strptime(withdraw_open_time_setting.value, "%H:%M")
            withdraw_close_time_obj = datetime.strptime(withdraw_close_time_setting.value, "%H:%M")
            current_time_obj = datetime.now().time()
            withdraw_msg = "Available between " + str(withdraw_open_time_setting.value) + " to " + str(withdraw_close_time_setting.value)
            if withdraw_open_time_obj.time() <= current_time_obj <= withdraw_close_time_obj.time():
                withdraw_open = "1"
            else:
                withdraw_open = "0"

        data = {
            "wallet": int(user_details.deposit_balance),
            "winning": int(user_details.winning_balance),
            "bonus": int(user_details.bonus_balance),
            "total": int(user_details.total_balance),
            "paytm": Setting.query.get(Setting.Key.PAYTM_GATEWAY.name),
            "razorpay": Setting.query.get(Setting.Key.RAZORPAY_GATEWAY.name),
            "upi": Setting.query.get(Setting.Key.UPI_ID.name),
            "bank_details": Setting.query.get(Setting.Key.BANK_DETAILS.name),
            "data": transactions,
            "is_bank": "1" if bank_details else "0",
            "bank": bank_details,
            "min_withdraw": min_withdraw,
            "withdraw_open": withdraw_open,
            "withdraw_open_msg": withdraw_msg
        }
        print(data)
        return jsonify(data), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'error': 'Error fetching details'}), 500


def get_wallet_transactions():
    user_id, is_admin = validate_session()
    try:
        transactions = get_transactions(user_id)
        return jsonify({"data": transactions}), 200
    except Exception as e:
        return jsonify({'success': False, 'error': 'Error fetching details'}), 500


def get_withdraw_modes():
    user_id, is_admin = validate_session()
    w_modes = WithdrawMode.query.filter_by(active=True).all()
    modes = []
    for mode in w_modes:
        modes.append({
            "sn": mode.id,
            "key": mode.mode,
            "name": mode.name,
            "hint": mode.hint_message,
            "active": "1"
        })

    user_details = get_user_by_id(user_id)

    bank_details = {
        "ac": user_details.bank_ac_no,
        "holder": user_details.bank_ac_name,
        "bank": user_details.bank_name,
        "ifsc": user_details.bank_ifsc_code
    }

    is_bank = "1" if bank_details.get("ac") else "0"

    data = {
        "is_bank": is_bank,
        "bank": bank_details,
        "data": modes,
        "success": "1",
    }
    return jsonify(data), 200


def update_bank_details():
    user_id, is_admin = validate_session()
    data = request.form
    try:
        bank_ac_no = data.get("ac")
        bank_ac_name = data.get("holder")
        bank_name = data.get("bank")
        bank_ifsc_code = data.get("ifsc")

        if bank_ac_no is None or bank_ac_name is None or bank_name is None or bank_ifsc_code is None:
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 400

        success = update_user_bank_details(user_id, bank_ac_no, bank_ac_name, bank_name, bank_ifsc_code)
        if not success:
            return jsonify({'success': False, 'msg': 'Error updating bank details'}), 500

        return jsonify({"success": "1", "msg": "Bank Details Updated!"}), 200
    except Exception as e:
        return jsonify({'success': False, 'msg': 'Error updating bank details'}), 500


def withdraw_money():
    user_id, is_admin = validate_session()
    data = request.form
    print(data)
    try:
        mode = data.get("mode")
        info = data.get("info")
        amount = data.get("amount")

        if mode is None or info is None or amount is None:
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 200

        if mode == 'Select Payment Mode':
            return jsonify({'success': False, 'msg': 'Withdraw mode not selected'}), 200

        user_details = get_user_by_id(user_id)

        if int(amount) > user_details.winning_balance:
            return jsonify({'success': False, 'msg': 'Insufficient balance'}), 200
        create_withdraw(user_id, amount, mode, info)
        user_details = get_user_by_id(user_id)
        return jsonify({"success": "1", "msg": "Withdrawal request created!",
                        "active": "1" if user_details.active else "0", "winning": user_details.winning_balance}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error creating withdrawal request'}), 200


#amount
#mode
#amount
#transactionId

def deposit_money():
    user_id, is_admin = validate_session()
    data = request.form
    try:
        mode = data.get("type")
        amount = data.get("amount")

        if mode is None or amount is None:
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 400

        transaction = create_deposit(user_id, amount, mode)
        user_details = get_user_by_id(user_id)
        return jsonify({"success": "1", "hash": transaction.id,
                        "active": "1" if user_details.active else "0",
                        "winning": user_details.winning_balance}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error creating withdrawal request'}), 500


def verify_deposit():
    user_id, is_admin = validate_session()
    data = request.form
    try:
        transaction_id = data.get("hash")

        if transaction_id is None:
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 400
        transaction = Transaction.query.get(transaction_id)

        if transaction is None:
            return jsonify({'success': False, 'msg': 'Invalid transaction id'}), 400

        update_transaction_status(transaction_id, Transaction.Status.PROCESSING.name)

        user_details = get_user_by_id(user_id)
        return jsonify({"success": "0", "msg": "Deposit verified!",
                        "active": "1" if user_details.active else "0",
                        "winning": user_details.winning_balance}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error creating withdrawal request'}), 500


def deposit_via_bank():
    user_id, is_admin = validate_session()
    data = request.form
    try:
        image = request.files["img"]
        amount = data.get("amount")

        if image is None or amount is None:
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 400

        filename = f"{uuid.uuid4().hex[:8]}_{image.filename}"
        file_path = os.path.join("static/images/", filename)
        image.save(file_path)

        create_deposit(user_id, amount, "Bank Transfer", file_path)

        user_details = get_user_by_id(user_id)
        return jsonify({"success": "1", "msg": "Deposit verified!",
                        "active": "1" if user_details.active else "0",
                        "winning": user_details.winning_balance}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error creating withdrawal request'}), 500


def create_upi_gw_order(txn_id, user_id, phone, email, amount):
    url = 'https://api.ekqr.in/api/create_order'
    headers = {
        'Content-Type': 'application/json'
    }

    setting = Setting.query.filter_by(key=Setting.Key.UPI_GATEWAY_KEY.name).first()
    if setting:
        key = setting.value
    else:
        key = ""

    body_data = {
        "key": key,
        "client_txn_id": str(txn_id),
        "amount": str(amount),
        "p_info": "Samra t Club",
        "customer_name": str(user_id),
        "customer_email": email if email else "jondoe@gmail.com",
        "customer_mobile": str(phone),
        "redirect_url": "https://samrat-satta.com",
    }

    print(body_data)

    try:
        response = requests.post(url, headers=headers, json=body_data, timeout=None, verify=False)
        response_data = response.json()
        if response.status_code == 200 and response_data.get("status"):
            return response_data["data"]
        else:
            raise Exception(
                "Failed to create UPI gateway order. Error: {}".format(response_data.get("msg", "Unknown error")))
    except Exception as e:
        raise Exception("Failed to create UPI gateway order. Error: {}".format(str(e)))


def initiate_gw_payment():
    user_id, is_admin = validate_session()
    data = request.form
    amount = data.get("amount")
    if not amount:
        return jsonify({'success': "0", 'msg': 'Amount is empty. Please enter'}), 200

    user_details = get_user_by_id(user_id)
    transaction = create_deposit2(user_id, amount, "Upi Gateway")

    try:
        res = create_upi_gw_order(transaction.id, user_id, user_details.phone, user_details.email, amount)
        return jsonify({'success': "1", 'data': res}), 200
    except Exception as e:
        print(e)
        transaction.status = Transaction.Status.CANCELLED.name
        db.session.add(transaction)
        db.session.commit()
        return jsonify({'success': "0", 'msg': str(e)}), 200


def update_referral_bonus(user, amount):
    setting = Setting.query.filter_by(key=Setting.Key.REFERRAL_BONUS_PERCENT.name).first()
    if setting:
        bonus_percent = float(setting.value)
    else:
        return

    if user.referral_by and bonus_percent > 0:
        referrer = User.query.get(user.referral_by)
        if referrer:
            bonus_amount = amount * bonus_percent / 100
            referrer.bonus_balance += bonus_amount
            db.session.add(referrer)

            transaction = Transaction(user_id=referrer.id,
                                      type=Transaction.Type.EARN.name,
                                      sub_type=Transaction.SubType.ADD_BY_ADMIN.name,
                                      status=Transaction.Status.SUCCESS.name,
                                      amount=int(bonus_amount),
                                      mode="REFERRAL_COMMISSION",
                                      remark="Commission on deposit by " + user.phone,
                                      info="REFERRAL_BONUS")
            db.session.add(transaction)
            db.session.commit()


def update_transaction_status_and_balance(transaction_id, upi_txn_id):
    # update status and add balance in total and deposit in single transaction
    transaction = Transaction.query.get(transaction_id)

    if Transaction.Status.INITIATED.name != transaction.status:
        raise Exception("Invalid Transaction state for update")

    transaction.status = Transaction.Status.SUCCESS.name
    transaction.info = "Ref: " + upi_txn_id
    transaction.remark = "Deposit via UPI Gateway successful"

    user = User.query.get(transaction.user_id)
    user.deposit_balance += transaction.amount
    user.total_balance += transaction.amount
    db.session.add(transaction)
    db.session.add(user)
    db.session.commit()

    update_referral_bonus(user, transaction.amount)
    return user.total_balance


def upi_gw_webhook():
    data = request.form
    transaction_id = data.get("client_txn_id", None)
    transaction = Transaction.query.get(transaction_id)

    if not transaction:
        print("No transaction present for given id")
        return

    if Transaction.Status.INITIATED.name != transaction.status:
        print("Transaction already processed")
        return

    status = data.get("status")
    if status == "success":
        update_transaction_status_and_balance(transaction.id, data.get("upi_txn_id", None))
    elif status == "failure":
        update_transaction_status(transaction_id, Transaction.Status.CANCELLED.name)
    else:
        update_transaction_status(transaction_id, Transaction.Status.PROCESSING.name)

    return jsonify({"status": 0}), 200


def check_upi_gw_txn():
    user_id, is_admin = validate_session()
    data = request.form
    client_txn_id = data.get("client_txn_id")
    if not client_txn_id:
        return jsonify({'success': "0", 'msg': 'client_txn_id is empty. Please enter'}), 200

    transaction = Transaction.query.get(client_txn_id)
    if not transaction or transaction.status != Transaction.Status.INITIATED.name:
        if transaction.status == Transaction.Status.SUCCESS.name:
            return jsonify({'success': "0", 'msg': 'Transaction successful'}), 200
        if transaction.status == Transaction.Status.CANCELLED.name:
            return jsonify({'success': "0", 'msg': 'Transaction failed or cancelled by User'}), 200

        return jsonify({'success': "0", 'msg': 'Invalid transaction id'}), 200

    setting = Setting.query.filter_by(key=Setting.Key.UPI_GATEWAY_KEY.name).first()
    if setting:
        key = setting.value
    else:
        key = ""

    url = 'https://api.ekqr.in/api/check_order_status'
    headers = {
        'Content-Type': 'application/json'
    }

    body_data = {
        "key": key,
        "client_txn_id": client_txn_id,
        "txn_date": transaction.created_at.strftime("%d-%m-%Y")
    }

    try:
        response = requests.post(url, headers=headers, json=body_data, timeout=None, verify=False)
        response_data = response.json()
        if response.status_code == 200 and response_data.get("status"):
            if response_data["data"]["status"] == "success":
                balance = update_transaction_status_and_balance(transaction.id, response_data["data"]["upi_txn_id"])
                return jsonify({'success': "1", 'msg': 'Transaction successful', "total_balance": balance}), 200
            elif response_data["data"]["status"] == "failure":
                update_transaction_status(client_txn_id, Transaction.Status.CANCELLED.name)
                return jsonify(
                    {'success': "1", 'msg': 'Transaction failed or cancelled by User', "total_balance": ""}), 200
            else:
                if response_data["data"]["remark"] == "Transaction Timeout.":
                    update_transaction_status(client_txn_id, Transaction.Status.CANCELLED.name)
                    return jsonify({'success': "1", 'msg': 'Transaction Timeout.', "total_balance": ""}), 200
            return jsonify(
                {'success': "1", 'msg': 'Transaction is still in processing state', "total_balance": ""}), 200
        else:
            raise Exception(
                "Failed to check UPI gateway order status. Error: {}".format(response_data.get("msg", "Unknown error")))
    except Exception as e:
        print(e)
        return jsonify({'success': "0", 'msg': str(e)}), 500


def get_referrals():
    user_id, is_admin = validate_session()
    try:
        user = User.query.get(user_id)
        referrals = User.query.filter_by(referral_by=user_id).all()
        refer = []
        for ref in referrals:
            refer.append({
                "name": ref.name if ref.name else "User",
                "user": ref.phone,
                "date": ref.created_at.strftime("%d %b %Y %I:%M %p")
            })

        transactions = Transaction.query.filter_by(user_id=user_id, type=Transaction.Type.EARN.name).all()
        total_amount = 0
        transaction = []
        for trans in transactions:
            total_amount += trans.amount
            transaction.append({
                "remark": trans.remark,
                "amount": trans.amount,
                "date": trans.created_at.strftime("%d %b %Y %I:%M %p"),
                "1": Transaction.Type.EARN.value
            })

        commission = Setting.query.filter_by(key=Setting.Key.REFERRAL_BONUS_PERCENT.name).first()
        if commission:
            comm = commission.value
        else:
            comm = 0

        data = {
            "refer": refer,
            "transaction": transaction,
            "total_amount": total_amount,
            "comm": comm
        }

        print(data)
        return jsonify(data), 200
    except Exception as e:
        print(e)
        return jsonify({'success': False, 'msg': 'Error fetching details'}), 500
