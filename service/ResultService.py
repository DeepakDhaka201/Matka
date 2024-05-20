from datetime import timedelta

from extension import db
from models.Bet import Bet
from models.Market import Market
from models.Rate import Rate
from models.Result import Result
from models.User import User


def get_rates_by_game_type(market_id):
    rates = Rate.query.all()
    rate_dict = {}
    for rate in rates:
        rate_dict[rate.game_type] = rate.rate
    return rate_dict


def update_result(market_id, market_name, date, open_harf, jodi, close_harf):
    try:
        with db.session.begin_nested():
            result = Result(market_id=market_id, market_name=market_name, date=date, open_harf=open_harf,
                            jodi=jodi, close_harf=close_harf, batch=-1)
            db.session.add(result)

            market = Market.query.filter_by(id=market_id).first()

            if market.buffer_time > 0:
                date2 = date - timedelta(days=1)
            else:
                date2 = date
            bets = db.session.query(Bet).filter(Bet.market_id == market_id,
                                                Bet.status == Bet.Status.PENDING.name,
                                                Bet.date == date2).all()
            rates = get_rates_by_game_type(market_id)

            user_ids = [bet.user_id for bet in bets]
            users = {user.id: user for user in User.query.filter(User.id.in_(user_ids)).all()}

            for bet in bets:
                rate = rates.get(bet.bet_type)
                bet_number = jodi if bet.bet_type == Bet.GameType.JODI.name else (open_harf if bet.bet_type == Bet.GameType.OPEN_HARF.name else close_harf)

                if bet_number == bet.jodi or bet_number == bet.open_harf or bet_number == bet.close_harf:
                    bet.status = Bet.Status.WON.name
                    bet.win_amount = bet.amount * rate

                    user = users[bet.user_id]
                    user.total_balance += bet.winning_amount
                    user.winning_balance += bet.winning_amount

                    db.session.add(user)
                else:
                    bet.status = Bet.Status.LOST.name

                db.session.add(bet)
            db.session.commit()
    except Exception as e:
        db.session.rollback()
        raise e


def revert_result(result):
    try:
        with db.session.begin_nested():
            market = Market.query.get(result.market_id)
            if market.buffer_time > 0:
                date = result.date - timedelta(days=1)
            else:
                date = result.date
            bets = Bet.query.filter_by(market_id=result.market_id, date=date).all()
            users = {user.id: user for user in User.query.filter(User.id.in_([bet.user_id for bet in bets])).all()}

            for bet in bets:
                if bet.status == Bet.Status.WON.name:
                    user = users[bet.user_id]
                    user.total_balance -= bet.winning_amount
                    user.winning_balance -= bet.winning_amount
                    db.session.add(user)

                bet.status = Bet.Status.PENDING.name
                bet.winning_amount = 0
                db.session.add(bet)

            db.session.delete(result)
            db.session.commit()
    except Exception as e:
        db.session.rollback()
        raise e
