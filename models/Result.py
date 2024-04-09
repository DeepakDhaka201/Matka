import datetime

from sqlalchemy import Column, Date, Integer, DateTime, func
from sqlalchemy.orm import Mapped, mapped_column

from extension import db


class Result(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    market_id: Mapped[int] = mapped_column(nullable=False)
    date = Column(Date, nullable=False)
    open_number = Column(Integer, nullable=True)
    close_number = Column(Integer, nullable=True)
    created_at = Column(db.DateTime(timezone=True),
                        server_default=func.now())


datetime.time()
