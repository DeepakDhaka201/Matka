from sqlalchemy import String, Column, func
from sqlalchemy.orm import Mapped, mapped_column

from extension import db


class AppUpdate(db.Model):
    id: Mapped[int] = mapped_column(primary_key=True)
    version: Mapped[int] = mapped_column(nullable=False)
    link = Column(String(200), nullable=False)
    log = Column(String(2000), nullable=True)
    created_at = Column(db.DateTime(timezone=True),
                        server_default=func.now())
