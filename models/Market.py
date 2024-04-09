from sqlalchemy import Column, String
from sqlalchemy.orm import Mapped, mapped_column

from extension import db


class Market(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    name = Column(String(30), nullable=False)
    open_time = Column(String(30), nullable=False)
    close_time = Column(String(30), nullable=False)
    result_time = Column(String(30), nullable=False)

