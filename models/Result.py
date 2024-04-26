import datetime

from sqlalchemy import Column, Date, Integer, DateTime, func, String, Boolean
from sqlalchemy.orm import Mapped, mapped_column

from extension import db


class Result(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    market_id: Mapped[int] = mapped_column(nullable=False)
    market_name = Column(String(20), nullable=False)
    date = Column(Date, nullable=False)
    batch = Column(Integer, nullable=False)
    reverted = Column(Boolean, nullable=True)
    open_harf = Column(String(5), nullable=False)
    jodi = Column(String(5), nullable=False)
    close_harf = Column(String(5), nullable=False)
    created_at = Column(db.DateTime(timezone=True),
                        server_default=func.now())


datetime.time()
