from enum import Enum

from sqlalchemy import Float, Column, DateTime, BOOLEAN, String, Integer, func
from sqlalchemy.orm import Mapped, mapped_column

from extension import db


class Bet(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    market_id: Mapped[int] = mapped_column(nullable=False)
    user_id: Mapped[int] = mapped_column(nullable=False)
    transaction_id: Mapped[int] = mapped_column(nullable=True)

    bet_number = Column(Integer, nullable=False)
    amount = Column(Float, nullable=False)
    bet_type = Column(String(20), nullable=False)

    status = Column(String(30), nullable=False)
    settled = Column(BOOLEAN, nullable=False, default=False)

    created_at = Column(db.DateTime(timezone=True),
                        server_default=func.now())

    class Status(Enum):
        PENDING = ("0", "Result Pending")
        WON = ("1", "Congratulations! You Won")
        LOST = ("2", "Better Luck Next Time")
        CANCELLED = ("3", "Cancelled")
        DELETED = ("4", "Deleted")

    class GameType(Enum):
        JODI = "Jodi"
        A_HARF = "Open Harf"
        B_HARF = "Close Harf"

    def toBetType(bet_type):
        if bet_type == "jodi":
            return Bet.GameType.JODI
        elif bet_type == "Open Harf":
            return Bet.GameType.A_HARF
        elif bet_type == "Close Harf":
            return Bet.GameType.B_HARF
        else:
            raise Exception("Invalid bet type")
