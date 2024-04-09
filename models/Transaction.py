from enum import Enum

from sqlalchemy import Column, String, Float, Integer, DateTime, BOOLEAN, func
from sqlalchemy.orm import mapped_column, Mapped

from app import db


class Transaction(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    user_id: Mapped[int] = mapped_column(nullable=False)

    type = Column(String(20), nullable=False)
    amount = Column(Float, nullable=False)
    status = Column(String(30), nullable=False)
    settled = Column(BOOLEAN, nullable=True)
    mode = Column(String(20), nullable=True)

    bet_id = Column(Integer, nullable=True)

    remark = Column(String(100), nullable=True)
    created_at = Column(db.DateTime(timezone=True),
                        server_default=func.now())

    class Type(Enum):
        WITHDRAWAL = 1
        DEPOSIT = 2
        BET = 3
        BONOUS = 4

    class Status(Enum):
        INITIATED = 1
        PENDING_FOR_APPROVAL = 2
        PROCESSING = 3
        SUCCESS = 3
        FAILED = 4
        CANCELLED = 5
