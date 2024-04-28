import os
import traceback
import uuid

import requests
from flask import jsonify, request

from extension import db
from models.Setting import Setting
from models.Transaction import Transaction
from models.WithdrawMode import WithdrawMode
from service.BetService import create_withdraw, create_deposit, update_transaction_status
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
            "bank": bank_details
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
        transactions = get_transactions(user_id);
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
    try:
        print(data)
        mode = data.get("mode")
        info = data.get("info")
        amount = data.get("amount")

        if mode is None or info is None or amount is None:
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 400

        user_details = get_user_by_id(user_id)

        if int(amount) > user_details.winning_balance:
            return jsonify({'success': False, 'msg': 'Insufficient balance'}), 400
        create_withdraw(user_id, amount, mode)
        user_details = get_user_by_id(user_id)
        return jsonify({"success": "1", "msg": "Withdrawal request created!",
                        "active": "1" if user_details.active else "0", "winning": user_details.winning_balance}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error creating withdrawal request'}), 500


#amount
#mode
#amount
#transactionId

def deposit_money():
    user_id, is_admin = validate_session()
    data = request.form
    try:
        print(data)
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


def create_upi_gw_order(txn_id, user_id, name, email, amount):
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
        "client_txn_id": txn_id,
        "amount": str(amount),
        "p_info": "Samra t Club",
        "customer_name": name,
        "customer_email": email if email else "jondoe@gmail.com",
        "customer_mobile": str(user_id),
        "redirect_url": "https://samrat-satta.com",
    }

    try:
        response = requests.post(url, headers=headers, json=body_data, timeout=None, verify=False)
        response_data = response.json()
        print(response_data)
        if response.status_code == 200 and response_data.get("status"):
            return response_data["data"]
        else:
            raise Exception("Failed to create UPI gateway order. Error: {}".format(response_data.get("msg", "Unknown error")))
    except Exception as e:
        raise Exception("Failed to create UPI gateway order. Error: {}".format(str(e)))


def initiate_gw_payment():
    user_id, is_admin = validate_session()
    print(request)

    data = request.get_json()

    print(data)

    amount = data.get("amount")
    if not amount:
        return jsonify({'success': "0", 'msg': 'Amount is empty. Please enter'}), 200

    user_details = get_user_by_id(user_id)
    transaction = create_deposit(user_id, amount, "UPI_GATEWAY")

    try:
        res = create_upi_gw_order(transaction.id, user_id, user_details.phone, user_details.email, amount)
        return jsonify({'success': "1", 'data': res}), 200
    except Exception as e:
        print(e)
        transaction.status = Transaction.Status.CANCELLED
        db.session.add(transaction)
        db.session.commit()
        return jsonify({'success': "0", 'msg': str(e)}), 200
