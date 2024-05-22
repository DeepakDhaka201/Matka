import datetime
import traceback
from urllib.parse import unquote

from flask import jsonify, request, render_template
from sqlalchemy import cast, Date

from models.Bet import Bet
from models.Result import Result
from service.BetService import save_bets, fetch_bets, fetch_bets2
from service.MarketService import get_all_market, get_all_market_by_id
from service.UserService import validate_session


def convert_to_datetime(date_str):
    return datetime.strptime(date_str, '%d %b %Y')


def get_bets():
    user_id, is_admin = validate_session()
    try:
        bets = fetch_bets2(user_id, request.form.get("market"))
        markets = get_all_market_by_id()

        data = {}

        dates = set()
        for bet in bets:
            date = bet.created_at.strftime("%d %b %Y")
            dates.add(date)

            if Bet.GameType.JODI.name == bet.bet_type:
                bet_number = bet.jodi
            elif Bet.GameType.OPEN_HARF.name == bet.bet_type:
                bet_number = bet.open_harf
            else:
                bet_number = bet.close_harf

            bet_details = {
                "market": markets.get(bet.market_id).name,
                "game": Bet.GameType[bet.bet_type].value,
                "number": bet_number,
                "amount": int(bet.amount),
                "status": Bet.Status[bet.status].value[0],
                "date": bet.created_at.strftime("%d %b %Y %I:%M %p"),
                "is_loss": "1" if bet.status == Bet.Status.LOST.name else "0",
                "wallet_type": 1,
                "msg": Bet.Status[bet.status].value[1],
                "sn": bet.id
            }

            if date in data:
                data[date].append(bet_details)
            else:
                data[date] = [bet_details]

        data["dates"] = sorted(dates, key=convert_to_datetime, reverse=True)
        print(data)
        return jsonify(data), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error fetching details'}), 500


def place_bet():
    user_id, is_admin = validate_session()
    data = request.form
    try:
        print(data)
        market_name = data.get("bazar")
        total_amount = data.get("total")
        game_type = data.get("game")
        input_numbers = unquote(data.get("number"))
        input_amounts = unquote(data.get("amount"))

        games = data.get("games")
        if games:
            games = games.split(",")
            game_type = games[0]

        if market_name is None or game_type is None or input_numbers is None or input_amounts is None:
            print("Invalid request body")
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 200

        input_numbers = [num for num in input_numbers.split(",")]
        input_amounts = [num for num in input_amounts.split(",")]

        if len(input_numbers) != len(input_amounts):
            print("Invalid request body! Number and amount count mismatch")
            return jsonify({'success': False, 'msg': 'Invalid request body'}), 200

        print(input_numbers)
        response = save_bets(user_id, market_name, game_type, input_numbers, input_amounts, total_amount)
        print(response)

        if not response.get('success'):
            return jsonify(response), 200

        return jsonify({'success': "1", 'msg': 'Bet placed successfully', 'active': response.get('active')}), 200
    except Exception as e:
        print(e)
        traceback.print_exc()
        return jsonify({'success': False, 'msg': 'Error while placing bet'}), 200


def get_results():
    data = request.args
    market = data.get("market", None)
    if market is None:
        return jsonify({'success': False, 'msg': 'Invalid request body'}), 400

    results = Result.query.filter(Result.market_name == market).order_by(Result.date.desc()).limit(60).all()
    print(results)
    result_map = {}
    for result in results:
        result_map[result.date.strftime("%d %b")] = result.jodi if result.jodi else "**"

    start_date = datetime.date.today()
    end_date = start_date - datetime.timedelta(days=60)

    data = []
    current_date = start_date - datetime.timedelta(days=start_date.weekday())

    print(results, current_date, end_date)

    while current_date >= end_date:
        print("Current Date: ", current_date)
        week_start = current_date
        week_end = current_date + datetime.timedelta(days=6)

        week_data = {
            "year": week_start.year,
            "week_start": week_start.strftime("%d %b"),
            "week_end": week_end.strftime("%d %b"),
            "results": []
        }

        for day in range(7):
            current_day = week_start + datetime.timedelta(days=day)
            day_str = current_day.strftime("%d %b")
            result = result_map.get(day_str, "**")
            week_data["results"].append(result)

        current_date -= datetime.timedelta(weeks=1)
        data.append(week_data)

    print(data)
    return render_template("chart.html", data=data, market=market)
