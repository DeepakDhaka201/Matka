import os
import traceback
import uuid

from flask import jsonify, request

from models.Setting import Setting
from models.Transaction import Transaction
from service.BetService import create_withdraw, create_deposit, update_transaction_status
from service.UserService import validate_session, get_user_by_id, get_transactions, update_user_bank_details


def get_wallet():
    user_id = validate_session()
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
    user_id = validate_session()
    try:
        transactions = get_transactions(user_id);
        return jsonify({"data": transactions}), 200
    except Exception as e:
        return jsonify({'success': False, 'error': 'Error fetching details'}), 500


def get_withdraw_modes():
    user_id = validate_session()
    modes = [
            {
                "sn": "1",
                "name": "Bank Account",
                "hint": "Enter Your Bank Account Number And IFSC Code",
                "active": "1"
            },
            {
                "sn": "5",
                "name": "Google Pay",
                "hint": "Enter GPay Number",
                "active": "1"
            },
            {
                "sn": "1",
                "name": "Paytm",
                "hint": "Enter Paytm Number",
                "active": "1"
            },
            {
                "sn": "4",
                "name": "Phone Pe",
                "hint": " Phone Pe Number",
                "active": "1"
            },
            {
                "sn": "3",
                "name": "UPI",
                "hint": "Enter your VPA",
                "active": "1"
            }
        ]
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
    user_id = validate_session()
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
    user_id = validate_session()
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
    user_id = validate_session()
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
    user_id = validate_session()
    data = request.form
    try:
        transaction_id = data.get("hash")

        if transaction_id is None:
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 400
        transaction = Transaction.query.get(transaction_id)

        if transaction is None:
            return jsonify({'success': False, 'msg': 'Invalid transaction id'}), 400

        update_transaction_status(transaction_id, Transaction.Status.PENDING_FOR_APPROVAL.name)

        user_details = get_user_by_id(user_id)
        return jsonify({"success": "0", "msg": "Deposit verified!",
                        "active": "1" if user_details.active else "0",
                        "winning": user_details.winning_balance}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error creating withdrawal request'}), 500


def deposit_via_bank():
    user_id = validate_session()
    data = request.form
    try:
        image = request.files["img"]
        amount = data.get("amount")

        filename = f"{uuid.uuid4().hex[:8]}_{image.filename}"
        file_path = os.path.join("uploads/", filename)
        image.save(file_path)

        if image is None or amount is None:
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 400

        create_deposit(user_id, amount, "Bank Transfer", file_path)

        user_details = get_user_by_id(user_id)
        return jsonify({"success": "1", "msg": "Deposit verified!",
                        "active": "1" if user_details.active else "0",
                        "winning": user_details.winning_balance}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error creating withdrawal request'}), 500
