from sqlalchemy import func

from extension import db
from models.Bet import Bet
from models.Market import Market
from models.Transaction import Transaction
from models.User import User


def fetch_bets(user_id, market_name=None):
    if market_name:
        market_id = Market.query.filter_by(name=market_name).first().id
        bets = Bet.query.filter_by(user_id=user_id, market_id=market_id).all()
    else:
        bets = Bet.query.filter_by(user_id=user_id).all()
    return bets


def save_bets(user_id, market_name, game_type, input_numbers, input_amounts, total_amount):
    bets = []
    transactions = []
    total_amount = 0
    market_id = Market.query.filter_by(name=market_name).first().id

    for i in range(len(input_numbers)):
        transaction = Transaction(user_id=user_id,
                                  type=Transaction.Type.BET.name,
                                  amount=int(input_amounts[i]),
                                  status=Transaction.Status.SUCCESS.name,
                                  remark="Bet on " + Bet.toBetType(game_type).value + " " + str(input_numbers[i]) + " in " + market_name)
        transactions.append(transaction)

        bet = Bet(user_id=user_id,
                  market_id=market_id,
                  transaction_id=0,
                  bet_number=input_numbers[i],
                  amount=input_amounts[i],
                  bet_type=Bet.toBetType(game_type).name,
                  status=Bet.Status.PENDING.name)
        bets.append(bet)

        total_amount += input_amounts[i]

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
    return {'success': True, 'error': 'Insufficient balance', 'active': "1" if user.active else "0"}


def create_withdraw(user_id, amount, mode):
    transaction = Transaction(user_id=user_id,
                              type=Transaction.Type.WITHDRAWAL.name,
                              status=Transaction.Status.PENDING_FOR_APPROVAL.name,
                              amount=int(amount),
                              remark="Withdraw via " + mode)
    db.session.query(User).filter(User.id == user_id)\
        .update({User.winning_balance: User.winning_balance - int(amount)})
    db.session.add(transaction)
    db.session.commit()
    return transaction


def create_deposit(user_id, amount, mode, info=None):
    transaction = Transaction(user_id=user_id,
                              type=Transaction.Type.DEPOSIT.name,
                              status=Transaction.Status.INITIATED.name,
                              amount=int(amount),
                              mode=mode,
                              remark="Deposit via " + mode,
                              info=info)
    db.session.add(transaction)
    db.session.commit()
    return transaction


def update_transaction_status(transaction_id, status):
    db.session.query(Transaction).filter(Transaction.id == transaction_id)\
        .update({Transaction.status: status})
    db.session.commit()
    return True
