from datetime import date, timedelta, datetime

from sqlalchemy import Date, cast

from models.Market import Market
from models.Result import Result


def get_current_previous_day_results():
    results_current_day = Result.query.filter_by(date=cast(date.today(), Date)).all()

    previous_date = date.today() - timedelta(days=1)
    results_previous_day = Result.query.filter_by(date=cast(previous_date, Date)).all()

    data_current_day = {}
    for result in results_current_day:
        data_current_day[result.market_id] = result

    for result in results_previous_day:
        if result.market_id in data_current_day:
            data_current_day[result.market_id]["open_number"] = result.get("close_number")

    return data_current_day


def get_markets_with_result():
    markets = Market.query.all()
    results = get_current_previous_day_results()
    data = []

    for market in markets:
        result = results.get(market.id)
        open_time_obj = datetime.strptime(market.open_time, "%I:%M %p")
        close_time_obj = datetime.strptime(market.close_time, "%I:%M %p")
        current_time_obj = datetime.now().time()

        if open_time_obj.time() < current_time_obj < close_time_obj.time():
            is_open = "1"
            is_close = "0"
        else:
            is_open = "1"
            is_close = "0"

        data.append({
            "market": market.name,
            "is_close": is_close,
            "is_open": is_open,
            "open_time": market.open_time,
            "close_time": market.close_time,
            "result_time": market.result_time,
            "result": result.close_number if result and result.close_number else "**",
            "result3": result.open_number if result and result.open_number else "**",
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
