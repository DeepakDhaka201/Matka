from sqlalchemy import DateTime, Column, String, func
from sqlalchemy.orm import Mapped, mapped_column

from app import db


class User(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    phone = Column(String(20), index=True, nullable=False, unique=True)
    name = Column(String(20))
    total_balance: Mapped[float] = mapped_column(default=0.0)
    deposit_balance: Mapped[float] = mapped_column(default=0.0)
    winning_balance: Mapped[float] = mapped_column(default=0.0)
    bonus_balance: Mapped[float] = mapped_column(default=0.0)
    pin = Column(String(8), nullable=True)
    active: Mapped[bool] = mapped_column(default=True)
    created_at = Column(db.DateTime(timezone=True),
                        server_default=func.now())
