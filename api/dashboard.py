from flask import request, jsonify

from app import app
from service.MarketService import get_markets_with_result
from service.UserService import validate_session, get_user_by_id


@app.route('/dashboard', methods=['GET'])
def dashboard():
    try:
        user_id = validate_session()
        user_details = get_user_by_id(user_id)
        markets = get_markets_with_result()
        return jsonify({'success': True, 'user_details': user_details, 'markets': markets}), 200

    except Exception as e:
        return jsonify({'success': False, 'error': 'Error fetching details'}), 500
