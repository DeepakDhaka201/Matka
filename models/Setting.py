from enum import Enum

from sqlalchemy import Column, String
from sqlalchemy.orm import mapped_column, Mapped
from extension import db


class Setting(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    key = Column(String(30), index=True, nullable=False)
    value = Column(String(10000), nullable=False)
    type = Column(String(30))
    remark = Column(String(100), nullable=True)

    class Key(Enum):
        WHATSAPP = "whatsapp"
        TELEGRAM_ID = "telegram"

        MIN_DEPOSIT = "min_deposit"
        MIN_WITHDRAW = "min_withdraw"
        UPI_ID = "upi"
        MERCHANT = "merchant"
        BANK_DETAILS = "bank_details"
        WITHDRAW_OPEN_TIME = "withdrawOpenTime"
        WITHDRAW_CLOSE_TIME = "withdrawCloseTime"
        IS_ONLINE_PAYMENT = "gateway"

        PAYTM_GATEWAY = "paytm"
        RAZORPAY_GATEWAY = "razorpay"
        UPI_ENABLED = "upi"
        NOTICE = "notice"


