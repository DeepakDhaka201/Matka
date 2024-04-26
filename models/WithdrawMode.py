from enum import Enum

from extension import db


class WithdrawMode(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    mode = db.Column(db.String(20), nullable=False)
    name = db.Column(db.String(20), nullable=False)
    hint_message = db.Column(db.String(100), nullable=False)
    active = db.Column(db.Boolean, nullable=False, default=True)
    min_withdraw = db.Column(db.Float, nullable=False)
    max_withdraw = db.Column(db.Float, nullable=False)

    class Mode(Enum):
        UPI = "UPI"
        BANK = "Bank"
        PAYTM = "Paytm"
        GOOGLE_PAY = "Google Pay"
        PHONEPE = "PhonePe"
        BHIM = "Bhim"
