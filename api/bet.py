import traceback
from urllib.parse import unquote

from flask import jsonify, request

from models.Bet import Bet
from service.BetService import save_bets, fetch_bets
from service.MarketService import get_all_market, get_all_market_by_id
from service.UserService import validate_session


def get_bets():
    user_id = validate_session()
    try:
        bets = fetch_bets(user_id, request.form.get("market"))
        markets = get_all_market_by_id()

        data = {}

        dates = set()
        for bet in bets:
            date = bet.created_at.strftime("%d %b %Y")
            dates.add(date)
            bet_details = {
                "market": markets.get(bet.market_id).name,
                "game": Bet.GameType[bet.bet_type].value,
                "number": bet.bet_number,
                "amount": int(bet.amount),
                "status": Bet.Status[bet.status].value[0],
                "date": bet.created_at.strftime("%d %b %Y %I:%M %p"),
                "is_loss": "1" if bet.status == Bet.Status.LOST.name else "0",
                "wallet_type": 1,
                "msg": Bet.Status[bet.status].value[1],
                "sn": bet.id
            }

            if date in data:
                data[date].append(bet_details)
            else:
                data[date] = [bet_details]

        data["dates"] = list(dates)
        return jsonify(data), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'error': 'Error fetching details'}), 500


def place_bet():
    user_id = validate_session()
    data = request.form
    try:
        print(data)
        market_name = data.get("bazar")
        total_amount = data.get("total")
        game_type = data.get("game")
        input_numbers = unquote(data.get("number"))
        input_amounts = unquote(data.get("amount"))

        games = data.get("games")
        if games:
            games = games.split(",")
            game_type = games[0]

        if market_name is None or game_type is None or input_numbers is None or input_amounts is None:
            print("Invalid request body")
            return jsonify({'success': False, 'error': 'Invalid request body'}), 400

        input_numbers = [int(num) for num in input_numbers.split(",")]
        input_amounts = [int(num) for num in input_amounts.split(",")]
        if len(input_numbers) != len(input_amounts):
            print("Invalid request body! Number and amount count mismatch")
            return jsonify({'success': False, 'error': 'Invalid request body'}), 400

        response = save_bets(user_id, market_name, game_type, input_numbers, input_amounts, total_amount)
        if not response.get('success'):
            return jsonify(response), 400

        return jsonify({'success': "1", 'message': 'Bet placed successfully', 'active': response.get('active')}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'error': 'Error while placing bet'}), 500
