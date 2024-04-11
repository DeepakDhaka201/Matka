import time

from flask import session

from extension import db
from models.Transaction import Transaction
from models.User import User


def get_user_by_phone(number):
    return User.query.filter_by(phone=number).first_or_404()


def get_user_by_id(user_id):
    return User.query.get(user_id)


def create_user(number, password):
    user = User(phone=number, password=password)
    db.session.add(user)
    db.session.commit()

    return user


def validate_session():
    print(session)
    user_id = int(session.get('user_id', None))
    if not user_id:
        raise Exception("Unauthorized")

    return user_id


def get_transactions(user_id, types=None):
    if types and len(types) > 0:
        transactions = Transaction.query \
            .filter(Transaction.user_id == user_id) \
            .filter(Transaction.type.in_(types)) \
            .filter(Transaction.status == 'SUCCESS') \
            .all()
        print(transactions)
    else:
        transactions = Transaction.query.filter(Transaction.user_id == user_id)\
            .filter(Transaction.status == 'SUCCESS').all()
        print(transactions)

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
