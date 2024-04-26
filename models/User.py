from sqlalchemy import DateTime, Column, String, func
from sqlalchemy.orm import Mapped, mapped_column

from extension import db


class User(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    phone = Column(String(20), index=True, nullable=False, unique=True)
    email = Column(String(50))
    name = Column(String(20))
    password = Column(String(20), nullable=False)
    total_balance: Mapped[float] = mapped_column(default=0.0)
    deposit_balance: Mapped[float] = mapped_column(default=0.0)
    winning_balance: Mapped[float] = mapped_column(default=0.0)
    bonus_balance: Mapped[float] = mapped_column(default=0.0)
    pin = Column(String(8), nullable=True)
    bank_ac_no = Column(String(50), nullable=True)
    bank_ac_name = Column(String(50), nullable=True)
    bank_ifsc_code = Column(String(50), nullable=True)
    bank_name = Column(String(50), nullable=True)
    active: Mapped[bool] = mapped_column(default=True)
    is_admin: Mapped[bool] = mapped_column(default=False)
    referral_code = Column(String(10), nullable=True)
    referral_by: Mapped[int] = mapped_column(nullable=True)
    created_at = Column(db.DateTime(timezone=True), server_default=func.now())
