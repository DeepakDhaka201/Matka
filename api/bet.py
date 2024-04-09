from flask import jsonify, request

from app import db
from models.Bet import Bet
from models.Market import Market
from models.Transaction import Transaction
from models.User import User
from service.UserService import validate_session


#@app.route('/get_bets', methods=['GET'])
def get_bets():
    user_id = validate_session()
    try:
        market_id = request.args.get('market_id')
        if market_id:
            bets = Bet.query.where(user_id=user_id, market_id=market_id).group_by(Bet.market_id).all()
        else:
            bets = Bet.query.where(user_id=user_id).group_by(Bet.market_id).all()

        markets = Market.query.all()

        data = {}
        for market in markets:
            data["market"] = market
            data["bets"] = bets.get(market.id)

        return jsonify({'success': True, 'bets': data, "markets": markets}), 200
    except Exception as e:
        return jsonify({'success': False, 'error': 'Error fetching details'}), 500


#@app.route('/place-bet', methods=['POST'])
def place_bet():
    user_id = validate_session()
    data = request.get_json()
    try:
        market_id = data.get("market_id")
        game_type = data.get("game_type")
        inputs = data.get("bets")

        if market_id is None or game_type is None or inputs is None:
            return jsonify({'success': False, 'error': 'Invalid request body'}), 400

        bets = []
        transactions = []
        total_amount = 0
        for _input in inputs:
            transaction = Transaction(user_id=user_id,
                                      type=Transaction.Type.BET,
                                      amount=_input.get("amount"),
                                      status=Transaction.Status.SUCCESS)
            transactions.append(transaction)

            bet = Bet(user_id=user_id,
                      market_id=market_id,
                      bet_number=_input.get("number"),
                      amount=_input.get("amount"),
                      bet_type=game_type,
                      status=Bet.Status.PENDING)
            bets.append(bet)

            total_amount += _input.get("amount")

        user = User.query.get(user_id)
        if not user:
            return jsonify({'success': False, 'error': 'User not found'}), 404

        if user.bonus_balance >= total_amount:
            user.bonus_balance -= total_amount
        elif user.bonus_balance + user.deposit_balance >= total_amount:
            amount_remaining = total_amount - user.bonus_balance
            user.bonus_balance = 0
            if user.deposit_balance >= amount_remaining:
                user.deposit_balance -= amount_remaining
            else:
                amount_remaining -= user.deposit_balance
                user.deposit_balance = 0
                user.winning_balance -= amount_remaining
        else:
            return jsonify({'success': False, 'error': 'Insufficient balance'}), 400

        user.total_balance -= total_amount

        db.session.add_all(bets)
        db.session.add_all(transactions)
        db.session.commit()

        return jsonify({'success': True, 'message': 'Bet placed successfully'}), 200
    except Exception as e:
        return jsonify({'success': False, 'error': 'Error while placing bet'}), 500
