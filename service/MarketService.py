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


def get_markets_with_result():
    markets = Market.query.all()
    current_day_number, previous_day_number = get_current_previous_day_results()
    data = []

    for market in markets:
        open_time_obj = datetime.strptime(market.open_time, "%H:%M")
        close_time_obj = datetime.strptime(market.close_time, "%H:%M")
        current_time_obj = datetime.now().time()

        if open_time_obj.time() < current_time_obj < close_time_obj.time():
            is_open = "1"
            is_close = "0"
        else:
            is_open = "0"
            is_close = "1"

        data.append({
            "id": market.id,
            "market": market.name,
            "is_close": is_close,
            "is_open": is_open,
            "open_time": open_time_obj.strftime('%I:%M %p'),
            "close_time": close_time_obj.strftime('%I:%M %p'),
            "result_time": datetime.strptime(market.result_time, "%H:%M").strftime('%I:%M %p'),
            "result": current_day_number.get(market.id) if current_day_number.get(market.id, None) else "**",
            "result3": previous_day_number.get(market.id) if previous_day_number.get(market.id, None) else "**",
            "market_type": "delhi",
            "mOpen": is_open,
            "mClose": is_close,
        })

    return data


def get_all_market():
    return Market.query.all()


def get_all_market_by_id():
    markets = Market.query.all()
    return {market.id: market for market in markets}
