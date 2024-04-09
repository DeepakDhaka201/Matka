import time

from flask import session

from app import db
from models.User import User


def get_user_by_phone(number):
    return User.query.filter_by(phone=number).first_or_404()


def get_user_by_id(user_id):
    return User.query.get(user_id)


def create_user(number):
    user = User(phone=number, created_at=time.time())
    db.session.add(user)
    db.session.flush()

    return user


def validate_session():
    user_id = session.get('user_id', None)
    if not user_id:
        raise Exception("Unauthorized")

    return user_id
