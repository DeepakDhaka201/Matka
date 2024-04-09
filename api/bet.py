from flask import jsonify, request
from service.BetService import save_bets, fetch_bets
from service.MarketService import get_all_market
from service.UserService import validate_session


def get_bets():
    user_id = validate_session()
    try:
        bets = fetch_bets(user_id, request.args.get("market_id"))

        markets = get_all_market()

        data = {}
        for market in markets:
            data["market"] = market
            data["bets"] = bets.get(market.id)

        return jsonify({'success': True, 'bets': data, "markets": markets}), 200
    except Exception as e:
        return jsonify({'success': False, 'error': 'Error fetching details'}), 500


def place_bet():
    user_id = validate_session()
    data = request.get_json()
    try:
        market_id = data.get("market_id")
        game_type = data.get("game_type")
        inputs = data.get("bets")

        if market_id is None or game_type is None or inputs is None:
            return jsonify({'success': False, 'error': 'Invalid request body'}), 400

        save_bets(inputs, user_id, market_id, game_type)

        return jsonify({'success': True, 'message': 'Bet placed successfully'}), 200
    except Exception as e:
        return jsonify({'success': False, 'error': 'Error while placing bet'}), 500
