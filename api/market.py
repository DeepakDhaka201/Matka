from flask import jsonify, request

from models.Setting import Setting
from service.MarketService import get_all_market


def get_markets():
    markets = get_all_market()
    data = []
    for market in markets:
        data.append({
            "market": market.name,
            "type": "delhi",
        })
    return jsonify({"data": data}), 200


def get_content():
    key = request.form.get("text")
    setting_key = Setting.Key[key.upper()]
    setting = Setting.query.filter_by(key=setting_key.name).first()
    notice = ""
    if setting:
        notice = setting.value
    return jsonify({"notice": notice}), 200
