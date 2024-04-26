from enum import Enum

from sqlalchemy import Float, Column, DateTime, BOOLEAN, String, Integer, func, Date
from sqlalchemy.orm import Mapped, mapped_column

from extension import db


class Bet(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    market_id: Mapped[int] = mapped_column(nullable=False)
    market_name = Column(String(20), nullable=False)
    user_id: Mapped[int] = mapped_column(nullable=False)
    transaction_id: Mapped[int] = mapped_column(nullable=True)

    jodi = Column(String(5), nullable=True)
    open_harf = Column(String(5), nullable=True)
    close_harf = Column(String(5), nullable=True)

    amount = Column(Float, nullable=False)
    win_amount = Column(Float, nullable=True)
    bet_type = Column(String(20), nullable=False)

    status = Column(String(30), nullable=False)
    settled = Column(BOOLEAN, nullable=False, default=False)
    date = Column(Date, nullable=False)

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
        OPEN_HARF = "Open Harf"
        CLOSE_HARF = "Close Harf"

    def toBetType(bet_type):
        if bet_type == "jodi":
            return Bet.GameType.JODI
        elif bet_type == "Open Harf":
            return Bet.GameType.OPEN_HARF
        elif bet_type == "Close Harf":
            return Bet.GameType.CLOSE_HARF
        else:
            raise Exception("Invalid bet type")
