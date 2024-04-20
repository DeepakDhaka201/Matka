import time
from datetime import date
from flask import session, request
from extension import db
from models.User import User
from models.Bet import Bet
from models.Transaction import Transaction
from models.Market import Market
from models.Result import Result

today = date.today()

def list_all_users():
    page = int(request.args.get('page', 1))
    per_page = 10
    users_pagination = User.query.paginate(page=page, per_page=per_page, error_out=False)
    paginated_users = users_pagination.items
    users = User.query.all()
    today_users = User.query.filter(User.created_at >= today).all()
    num_users = len(users)
    num_today_users = len(today_users)
    return users, num_users, today_users, num_today_users , paginated_users


def list_all_bets():
    bets = Bet.query.all()
    today_bets = Bet.query.filter(Bet.created_at >= today).all()
    num_today_bets = len(today_bets)
    return bets, today_bets, num_today_bets


def get_all_results():
    results = Result.query.all()
    return results

get_all_results
def get_todays_widthdrawals():
    withdrawals = Transaction.query.filter_by(type='WITHDRAWAL').all()
    withdrawals_today = [withdrawal for withdrawal in withdrawals if withdrawal.created_at.date() == today]
    print(len(withdrawals_today))
    print(withdrawals_today)
    return withdrawals_today



def get_todays_deposits():
    deposits = Transaction.query.filter_by(type='DEPOSIT').all()
    deposits_today = [deposit for deposit in deposits if deposit.created_at.date() == today]
    print(len(deposits_today))
    print(deposits_today)
    return deposits_today


def list_all_transactions():
    transactions = Transaction.query.all()
    withdrawals = Transaction.query.filter_by(type='WITHDRAWAL').all()
    deposits = Transaction.query.filter_by(type='DEPOSIT').all()
    transactions_today = [transaction for transaction in transactions if transaction.created_at.date() == today]
    withdrawals_today = [withdrawal for withdrawal in withdrawals if withdrawal.created_at.date() == today]
    deposits_today = [deposit for deposit in deposits if deposit.created_at.date() == today]
    num_withdrawals_today = len(withdrawals_today)
    num_deposits_today = len(deposits_today)


    return transactions, withdrawals_today, deposits_today, num_withdrawals_today, num_deposits_today




def list_user_specific_bets(user_id):
    bets = Bet.query.filter_by(user_id=user_id).all()
    return bets





def list_user_specific_transactions(user_id, page, per_page=10):
    try:
        transactions = Transaction.query.filter_by(user_id=user_id).paginate(page=page, per_page=per_page, error_out=False)
        return transactions.items
    except Exception as e:
        print(e)
        return []



def toggle_user_activation(user_id, activate=True):
    try:
        user = User.query.get(user_id)
        if user:
            user.active = activate
            db.session.commit()
            return {'success': True, 'message': f'User {user_id} has been {"activated" if activate else "deactivated"}'}
        else:
            return {'success': False, 'message': f'User with ID {user_id} not found'}
    except Exception as e:
        db.session.rollback()
        return {'success': False, 'error': str(e)}


def cancel_bet(bet_id, settlementOk=None):
    try:
        bet = Bet.query.get(bet_id)
        if bet:
            if settlementOk is None:
                # If settlementOk is not provided, cancel the bet without changing settlement status
                bet.status = "CANCELLED"
                db.session.commit()
                return {'success': True, 'message': f'Bet {bet_id} has been cancelled'}
            elif isinstance(settlementOk, bool):
                if settlementOk:
                    print("Received ", bet_id, settlementOk)
                    bet.settled = settlementOk
                    db.session.commit()
                    return {'success': True, 'message': f'Bet {bet_id} has been Settled'}
                else:
                    print(bet_id)
                    bet.settled = settlementOk
                    db.session.commit()
                    return {'success': True, 'message': f'Bet {bet_id} has been unSettled'}
            else:
                return {'success': False, 'message': 'Invalid value for settlementOk'}
        else:
            return {'success': False, 'message': f'Bet with ID {bet_id} not found'}
    except Exception as e:
        db.session.rollback()
        return {'success': False, 'error': str(e)}    

    
    # try:
    #     bet = Bet.query.get(bet_id)
    #     if bet:
    #         bet.status = "CANCELLED"
    #         db.session.commit()
    #         return {'success': True, 'message': f'Bet {bet_id} has been cancelled'}
    #     else:
    #         return {'success': False, 'message': f'Bet with ID {bet_id} not found'}
    # except Exception as e:
    #     db.session.rollback()
    #     return {'success': False, 'error': str(e)}



def add_market_entry(name, open_time, close_time, result_time):
    market = Market(name=name, open_time=open_time, close_time=close_time, result_time=result_time)
    db.session.add(market)
    db.session.commit()
    return market

def get_market_by_id(market_id):
    return Market.query.get(market_id)

def get_all_markets():
    return Market.query.all()

def update_market(market_id, name=None, open_time=None, close_time=None, result_time=None):
    market = Market.query.get(market_id)
    if market:
        if name:
            market.name = name
        if open_time:
            market.open_time = open_time
        if close_time:
            market.close_time = close_time
        if result_time:
            market.result_time = result_time
        db.session.commit()
        return market
    else:
        return None

def delete_market_entry(market_id):
    market = Market.query.get(market_id)
    if market:
        db.session.delete(market)
        db.session.commit()
        return True
    else:
        return False
