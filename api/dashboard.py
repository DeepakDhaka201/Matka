import traceback

from flask import request, jsonify

from models.Setting import Setting
from service.MarketService import get_markets_with_result
from service.UserService import validate_session, get_user_by_id


def dashboard():
    try:
        user_id = validate_session()
        user_details = get_user_by_id(user_id)
        markets = get_markets_with_result()

        settings = Setting.query.all()
        settings_map = {setting.key: setting.value for setting in settings}

        data = {
            "markets": markets,
            "min_deposit": settings_map.get(Setting.Key.MIN_DEPOSIT.name),
            "whatsapp": settings_map.get(Setting.Key.WHATSAPP.name),
            "telegram": settings_map.get(Setting.Key.TELEGRAM_ID.name),
            "min_withdraw": settings_map.get(Setting.Key.MIN_WITHDRAW.name),
            "upi": settings_map.get(Setting.Key.UPI_ID.name),
            "merchant": settings_map.get(Setting.Key.MERCHANT.name),
            "withdrawOpenTime": settings_map.get(Setting.Key.WITHDRAW_OPEN_TIME.name),
            "withdrawCloseTime": settings_map.get(Setting.Key.WITHDRAW_CLOSE_TIME.name),
            "gateway": settings_map.get(Setting.Key.IS_ONLINE_PAYMENT.name),
            "wallet": int(user_details.total_balance),
            "winning": int(user_details.winning_balance),
            "bonus": int(user_details.bonus_balance),
            "active": "1" if user_details.active else 0,
            "bank_details": settings_map.get(Setting.Key.BANK_DETAILS.name),
            "homeline": "",
            "images": [
                {
                    "0": "57",
                    "sn": "57",
                    "1": "upload/WhatsApp Image 2023-09-08 at 10.29.51 PM.jpeg",
                    "image": "upload/WhatsApp Image 2023-09-08 at 10.29.51 PM.jpeg"
                },
                {
                    "0": "56",
                    "sn": "56",
                    "1": "upload/Banner c.jpg",
                    "image": "upload/Banner c.jpg"
                }
            ],
            "code": "123456"
        }
        return jsonify(data), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'error': 'Error fetching details'}), 500
