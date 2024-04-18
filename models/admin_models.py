import time
from flask import session
from extension import db
from models.User import User
from models.Bet import Bet
from models.Transaction import Transaction
from models.Market import Market
from models.Result import Result

def list_all_users():
    users = User.query.all()
    return users

def get_all_results():
    results = Result.query.all()
    return results

def list_all_bets():
    bets = Bet.query.all()
    return bets

def list_all_transactions():
    transactions = Transaction.query.all()
    withdrawals = Transaction.query.filter_by(type='WITHDRAWAL').all()
    deposits = Transaction.query.filter_by(type='DEPOSIT').all()
    return transactions , withdrawals, deposits

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


def cancel_bet(bet_id):
    try:
        bet = Bet.query.get(bet_id)
        if bet:
            bet.status = "CANCELLED"
            db.session.commit()
            return {'success': True, 'message': f'Bet {bet_id} has been cancelled'}
        else:
            return {'success': False, 'message': f'Bet with ID {bet_id} not found'}
    except Exception as e:
        db.session.rollback()
        return {'success': False, 'error': str(e)}



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
