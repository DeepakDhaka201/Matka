from datetime import date, timedelta

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
        data.append({
            "market": market,
            "result": results.get(market.id)
        })

    return data


def get_all_market():
    return Market.query.all()
