from enum import Enum

from sqlalchemy import Float, Column, DateTime, BOOLEAN, String, Integer, func
from sqlalchemy.orm import Mapped, mapped_column

from extension import db


class Bet(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    market_id: Mapped[int] = mapped_column(nullable=False)
    user_id: Mapped[int] = mapped_column(nullable=False)
    transaction_id: Mapped[int] = mapped_column(nullable=False)

    bet_number = Column(Integer, nullable=False)
    amount = Column(Float, nullable=False)
    bet_type = Column(String(20), nullable=False)

    status = Column(String(30), nullable=False)
    settled = Column(BOOLEAN, nullable=False, default=False)

    created_at = Column(db.DateTime(timezone=True),
                        server_default=func.now())

    class Status(Enum):
        PENDING = 1
        WON = 2
        LOST = 3
        CANCELLED = 2
        DELETED = 3

    class GameType(Enum):
        JODI = 1
        A_HARF = 2
        B_HARF = 3
