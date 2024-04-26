from extension import db


class Rate(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    market_id = db.Column(db.Integer, nullable=False)
    market_name = db.Column(db.String(20), nullable=False)
    game_type = db.Column(db.String(20), nullable=False)
    rate = db.Column(db.Float, nullable=False)
    description = db.Column(db.String(100), nullable=False)
    created_at = db.Column(db.DateTime(timezone=True), server_default=db.func.now())
