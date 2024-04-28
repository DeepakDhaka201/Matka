from datetime import datetime

from sqlalchemy import func

from extension import db
from models.Bet import Bet
from models.Market import Market
from models.Transaction import Transaction
from models.User import User


# def fetch_bets2(user_id, market_name=None):
#     if market_name:
#         market_id = Market.query.filter_by(name=market_name).first().id
#         bets = Bet.query.filter_by(user_id=user_id, market_id=market_id).all()
#     else:
#         bets = Bet.query.filter_by(user_id=user_id).all()
#     return bets

def fetch_bets2(user_id, market_name=None):
    if market_name:
        market_id = Market.query.filter_by(name=market_name).first().id
        bets = Bet.query.filter_by(user_id=user_id, market_id=market_id).order_by(Bet.created_at.desc()).all()
    else:
        bets = Bet.query.filter_by(user_id=user_id).order_by(Bet.created_at.desc()).all()
    return bets


def save_bets(user_id, market_name, game_type, input_numbers, input_amounts, total_amount):
    print(game_type)
    bets = []
    transactions = []
    total_amount = 0
    market_id = Market.query.filter_by(name=market_name).first().id

    for i in range(len(input_numbers)):
        transaction = Transaction(user_id=user_id,
                                  type=Transaction.Type.BET.name,
                                  sub_type=Transaction.SubType.DEDUCT_BY_USER.name,
                                  amount=int(input_amounts[i]),
                                  status=Transaction.Status.SUCCESS.name,
                                  remark="Bet on " + Bet.toBetType(game_type).value + " " + str(
                                      input_numbers[i]) + " in " + market_name)
        transactions.append(transaction)

        if Bet.GameType.JODI.value.upper() == game_type.upper():
            jodi = input_numbers[i]
            open_harf = None
            close_harf = None
        elif Bet.GameType.OPEN_HARF.value.upper() == game_type.upper():
            open_harf = input_numbers[i]
            jodi = None
            close_harf = None
        elif Bet.GameType.CLOSE_HARF.value.upper() == game_type.upper():
            close_harf = input_numbers[i]
            jodi = None
            open_harf = None
        else:
            raise Exception("Invalid game type selected")

        bet = Bet(user_id=user_id,
                  market_id=market_id,
                  market_name=market_name,
                  date=datetime.today(),
                  transaction_id=0,
                  jodi=jodi,
                  open_harf=open_harf,
                  close_harf=close_harf,
                  amount=int(input_amounts[i]),
                  bet_type=Bet.toBetType(game_type).name,
                  status=Bet.Status.PENDING.name)
        bets.append(bet)

        total_amount += int(input_amounts[i])

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
                              sub_type=Transaction.SubType.DEDUCT_BY_USER.name,
                              status=Transaction.Status.PROCESSING.name,
                              amount=int(amount),
                              remark="Withdraw via " + mode)
    db.session.query(User).filter(User.id == user_id) \
        .update({User.winning_balance: User.winning_balance - int(amount)})
    db.session.add(transaction)
    db.session.commit()
    return transaction


def create_deposit(user_id, amount, mode, info=None):
    transaction = Transaction(user_id=user_id,
                              type=Transaction.Type.DEPOSIT.name,
                              sub_type=Transaction.SubType.ADD_BY_USER.name,
                              status=Transaction.Status.INITIATED.name,
                              amount=int(amount),
                              mode=mode,
                              remark="Deposit via " + mode,
                              info=info)
    db.session.add(transaction)
    db.session.commit()
    return transaction


def create_deposit2(user_id, amount, mode, info=None):
    transaction = Transaction(user_id=user_id,
                              type=Transaction.Type.DEPOSIT.name,
                              sub_type=Transaction.SubType.ADD_BY_USER.name,
                              status=Transaction.Status.INITIATED.name,
                              amount=int(amount),
                              mode=mode,
                              remark="Deposit via " + mode,
                              info=info)
    db.session.add(transaction)
    db.session.flush()
    db.session.commit()
    return transaction


def update_transaction_status(transaction_id, status):
    db.session.query(Transaction).filter(Transaction.id == transaction_id) \
        .update({Transaction.status: status})
    db.session.commit()
    return True


def fetch_bets(user_id, market_id, status, from_time, to_time, date):
    print(user_id)
    print(market_id)
    print(status)
    print(from_time)
    print(to_time)
    print(date)

    query = db.session.query(Bet)
    if user_id:
        query = query.filter(Bet.user_id == user_id)
    if market_id:
        query = query.filter(Bet.market_id == market_id)
    if status:
        query = query.filter(Bet.status == status)

    if from_time and to_time:
        from_time = datetime.strptime(from_time, "%d/%m/%Y")
        to_time = datetime.strptime(to_time, "%d/%m/%Y")
        print(from_time, to_time)

        query = query.filter(Bet.created_at >= from_time).filter(Bet.created_at <= to_time)
    elif date:
        date = datetime.strptime(date, "%Y-%m-%d")
        query = query.filter(Bet.date == date)
    else:
        query = query.filter(Bet.created_at >= datetime.now().replace(hour=0, minute=0, second=0, microsecond=0))

    bets = query.all()
    print(query)
    print(bets)

    users = User.query.filter(User.id.in_([bet.user_id for bet in bets])).all()
    user_map = {user.id: user for user in users}

    response = []
    for bet in bets:
        user = user_map.get(bet.user_id)
        response.append({
            "id": bet.id,
            "market_id": bet.market_id,
            "market_name": bet.market_name,
            "user_phone": user.phone,
            "user_name": user.name,
            "amount": bet.amount,
            "number": bet.jodi if bet.jodi else bet.open_harf if bet.open_harf else bet.close_harf,
            "win_amount": bet.win_amount,
            "bet_type": Bet.GameType[bet.bet_type].value,
            "status": bet.status,
            "settled": bet.settled,
            "date": bet.date,
            "created_at": bet.created_at
        })
    return response
