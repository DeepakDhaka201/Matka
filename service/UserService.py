import string
import time
from random import random

from flask import session, request
from sqlalchemy.exc import IntegrityError

from extension import db
from models.Transaction import Transaction
from models.User import User
from service.JwtToken import verify_jwt


def get_user_by_phone(number):
    return User.query.filter_by(phone=number).first_or_404("No user found with this number, please signup first")


def get_user_by_id(user_id):
    return User.query.get(user_id)


def create_user(number, password, referrer_code=None):
    referral_code = ''.join([str(int(random() * 10)) for _ in range(8)])

    referral_by = None
    referrer = User.query.filter_by(referral_code=referrer_code).first()
    if referrer:
        referral_by = referrer.id

    user = User(phone=number, password=password, referral_by=referral_by, referral_code=referral_code)
    db.session.add(user)
    db.session.commit()

    return user


def isAdmin(user_id):
    return User.query.get(user_id).is_admin


def validate_session():
    token = request.headers.get('Authorization')
    user_details = verify_jwt(token)
    return user_details.get('user_id', None), user_details.get('is_admin', False)


def validate_admin():
    if session and session.get('user_id', None) and isAdmin(session.get('user_id')):
        return int(session.get('user_id'))
    else:
        raise Exception("Unauthorized access")


def get_transactions(user_id, types=None):
    if types and len(types) > 0:
        transactions = Transaction.query \
            .filter(Transaction.user_id == user_id) \
            .filter(Transaction.type.in_(types)) \
            .filter(Transaction.status != 'INITIATED') \
            .order_by(Transaction.created_at.desc()) \
            .all()
    else:
        transactions = Transaction.query.filter(Transaction.user_id == user_id) \
            .filter(Transaction.status != 'INITIATED') \
            .order_by(Transaction.created_at.desc()) \
            .all()

    data = []
    for transaction in transactions:
        data.append({
            "amount": int(transaction.amount),
            "type": Transaction.Type[transaction.type].value,
            "remark": transaction.remark,
            "date": transaction.created_at.strftime("%d/%m/%y %I:%M %p")
        })

    return data


def update_user_bank_details(user_id, bank_ac_no, bank_ac_name, bank_name, bank_ifsc_code):
    user = User.query.get(user_id)
    user.bank_ac_no = bank_ac_no
    user.bank_ac_name = bank_ac_name
    user.bank_name = bank_name
    user.bank_ifsc_code = bank_ifsc_code

    db.session.commit()
    return True


def update_password(phone, password):
    user = User.query.filter_by(phone=phone).first()
    user.password = password

    db.session.commit()
    return True


def update_user_profile(user_id, phone, email, name):
    user = User.query.get(user_id)
    user.phone = phone
    user.email = email
    user.name = name

    db.session.commit()
    return True


def update_user_balance_and_create_transaction(user_id, amount, wallet_type, action, remark):
    user = User.query.get(user_id)
    if not user:
        return None, "User not found"

    try:
        with db.session.begin_nested():
            if wallet_type == 'deposit':
                if action == 'Add':
                    user.total_balance += amount
                    user.deposit_balance += amount
                else:
                    if user.total_balance >= amount:
                        user.total_balance -= amount
                        user.deposit_balance -= amount
                    else:
                        return None, "Insufficient balance"
            elif wallet_type == 'winning':
                if action == 'Add':
                    user.total_balance += amount
                    user.winning_balance += amount
                else:
                    if user.total_balance >= amount:
                        user.total_balance -= amount
                        user.winning_balance -= amount
                    else:
                        return None, "Insufficient balance"
            elif wallet_type == 'bonus':
                if action == 'Add':
                    user.total_balance += amount
                    user.bonus_balance += amount
                else:
                    if user.total_balance >= amount:
                        user.total_balance -= amount
                        user.bonus_balance -= amount
                    else:
                        return None, "Insufficient balance"
            else:
                return None, "Invalid wallet type"

            ttype = None
            if action == 'Add':
                ttype = 'DEPOSIT'
                if wallet_type == 'bonus':
                    ttype = 'BONOUS'
            else:
                ttype = 'WITHDRAWAL'

            # Create a transaction
            transaction = Transaction(
                user_id=user_id,
                amount=amount,
                type=ttype,
                sub_type='ADD_BY_ADMIN' if action == 'Add' else 'DEDUCT_BY_ADMIN',
                status='SUCCESS',
                remark=remark
            )
            db.session.add(transaction)
            db.session.commit()
    except IntegrityError as e:
        db.session.rollback()
        print("Error occurred during the transaction", e)
        return None, "Error occurred during the transaction"

    return transaction, None
