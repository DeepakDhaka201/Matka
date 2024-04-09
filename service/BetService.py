from extension import db
from models.Bet import Bet
from models.Transaction import Transaction
from models.User import User


def fetch_bets(user_id, market_id=None):
    if market_id:
        bets = Bet.query.where(user_id=user_id, market_id=market_id).group_by(Bet.market_id).all()
    else:
        bets = Bet.query.where(user_id=user_id).group_by(Bet.market_id).all()
    return bets


def save_bets(inputs, user_id, market_id, game_type):
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
        return {'success': False, 'error': 'User not found'}

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
        return {'success': False, 'error': 'Insufficient balance'}

    user.total_balance -= total_amount

    db.session.add_all(bets)
    db.session.add_all(transactions)
    db.session.commit()
    return {'success': True, 'error': 'Insufficient balance'}
