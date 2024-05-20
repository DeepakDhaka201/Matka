from datetime import date, timedelta, datetime

from sqlalchemy import Date, cast

from models.Market import Market
from models.Result import Result


def get_formatted_result(number):
    if number < 10:
        return f"0{number}"
    return str(number)


def get_current_previous_day_results():
    results_current_day = Result.query.filter_by(date=cast(date.today(), Date)).all()

    previous_date = date.today() - timedelta(days=1)
    results_previous_day = Result.query.filter_by(date=cast(previous_date, Date)).all()

    results_current_day_map = {}
    for result in results_current_day:
        results_current_day_map[result.market_id] = result.jodi

    results_previous_day_map = {}
    for result in results_previous_day:
        results_previous_day_map[result.market_id] = result.jodi

    return results_current_day_map, results_previous_day_map

def get_result(market_id):
    market = Market.query.get(market_id)
    current_date = date.today()
    if market.buffer_time > 0:
        current_date = current_date - timedelta(days=1)

    result_current_day = Result.query.filter_by(market_id=market_id, date=cast(current_date, Date)).first()
    result_previous_day = Result.query.filter_by(market_id=market_id,
                                                 date=cast(current_date - timedelta(days=1), Date)).first()

    return {"current_day": result_current_day.jodi if result_current_day else "**",
            "previous_day": result_previous_day.jodi if result_previous_day else "**"}


def get_markets_with_result():
    markets = Market.query.all()
    data = []

    for market in markets:
        open_time_obj = datetime.strptime(market.open_time, "%H:%M")
        close_time_obj = datetime.strptime(market.close_time, "%H:%M")
        current_time_obj = datetime.now().time()

        is_open = "0"
        is_close = "0"

        # Check if market closes after midnight
        if close_time_obj.time() < open_time_obj.time():
            # If current time is between open time and midnight or between midnight and close time, the market is open
            if open_time_obj.time() <= current_time_obj or current_time_obj <= close_time_obj.time():
                print("Market is open")
                is_open = "1"
            else:
                print("Market is closed")
                is_close = "1"
        # If market closes before midnight
        else:
            # If current time is between open time and close time, the market is open
            if open_time_obj.time() <= current_time_obj <= close_time_obj.time():
                print("Market is open")
                is_open = "1"
            else:
                print("Market is closed")
                is_close = "1"

        data.append({
            "id": market.id,
            "market": market.name,
            "is_close": is_close,
            "is_open": is_open,
            "open_time": open_time_obj.strftime('%I:%M %p'),
            "close_time": close_time_obj.strftime('%I:%M %p'),
            "result_time": datetime.strptime(market.result_time, "%H:%M").strftime('%I:%M %p'),
            "result": get_result(market.id).get("current_day"),
            "result3": get_result(market.id).get("previous_day"),
            "market_type": "delhi",
            "mOpen": is_open,
            "mClose": is_close,
        })

        print(data)
    return data


def get_all_market():
    return Market.query.all()


def get_all_market_by_id():
    markets = Market.query.all()
    return {market.id: market for market in markets}
