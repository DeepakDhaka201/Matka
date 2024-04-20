from extension import db
from flask import Flask, render_template, request, jsonify
from datetime import datetime, date
from models.admin_models import *
from models.admin_models import (
    list_all_users,
    list_all_bets,
    list_all_transactions,
    list_user_specific_transactions,
    list_user_specific_bets,
    toggle_user_activation,
    cancel_bet,
    add_market_entry,
    get_market_by_id,
    get_all_markets,
    update_market,
    delete_market_entry,
    get_all_results,
)


def render_admin_index():
    users, num_users, today_users, num_today_users, paginated_users = list_all_users()
    bets, today_bets, num_today_bets = list_all_bets()
    (
        transactions,
        withdrawals_today,
        deposits_today,
        num_withdrawals_today,
        num_deposits_today,
    ) = list_all_transactions()
    return render_template(
        "index.html",
        num_users=num_users,
        num_todays_users=num_today_users,
        num_today_bets=num_today_bets,
        num_deposits_today=num_deposits_today,
        num_withdrawals_today=num_withdrawals_today,
    )


def render_today_withdrawals():
    transactions = get_todays_widthdrawals()
    return render_template(
        "today_withdrawals.html",
        transactions = transactions, 
    )


def render_today_deposits():
    transactions = get_todays_deposits()
    return render_template(
        "today_deposits.html",transactions = transactions,
    )

def all_markets():
    markets = get_all_markets()
    return render_template(
        "view_markets.html",markets = markets,
    )


def render_add_market():
    return render_template("add_market.html",)

def render_edit_market():
    return render_template("edit_market.html",)

def render_users2admin():
     return render_template("users.html",)

def render_newusers2admin():
    return render_template("new_users.html",)

def render_bets2admin():
    return render_template("bets.html",)


def delhi_result_update():
    markets = get_all_markets()
    return render_template("delhi_result_update.html",markets = markets)

def delhi_batch_history():
    results = get_all_results()
    return render_template("delhi_batch_history.html",results = results)

def batch_history():
    transactions = list_all_transactions()
    return render_template("batch_history.html",transactions = transactions)


def list_users():
    try:
        newOffset = request.args.get("fetch_new")
        users, num_users, today_users, num_today_users, paginated_users = list_all_users()

        if newOffset:
            user_list = []
            for user in today_users:
                user_data = {
                    "id": user.id,
                    "phone": user.phone,
                    "email": user.email,
                    "name": user.name,
                    "password": user.password,
                    "total_balance": user.total_balance,
                    "deposit_balance": user.deposit_balance,
                    "winning_balance": user.winning_balance,
                    "bonus_balance": user.bonus_balance,
                    "pin": user.pin,
                    "bank_ac_no": user.bank_ac_no,
                    "bank_ac_name": user.bank_ac_name,
                    "bank_ifsc_code": user.bank_ifsc_code,
                    "bank_name": user.bank_name,
                    "active": user.active,
                    "created_at": user.created_at.strftime("%Y-%m-%d %H:%M:%S"),
                }
                user_list.append(user_data)

            total_users = len(user_list)

            today = date.today()
            new_users_today = sum(1 for user in users if user.created_at.date() == today)

            return {
                "users": user_list,
                "total_users": total_users,
                "new_users_today": new_users_today,
            }
        
        else:
            user_list = []
            for user in users:
                user_data = {
                    "id": user.id,
                    "phone": user.phone,
                    "email": user.email,
                    "name": user.name,
                    "password": user.password,
                    "total_balance": user.total_balance,
                    "deposit_balance": user.deposit_balance,
                    "winning_balance": user.winning_balance,
                    "bonus_balance": user.bonus_balance,
                    "pin": user.pin,
                    "bank_ac_no": user.bank_ac_no,
                    "bank_ac_name": user.bank_ac_name,
                    "bank_ifsc_code": user.bank_ifsc_code,
                    "bank_name": user.bank_name,
                    "active": user.active,
                    "created_at": user.created_at.strftime("%Y-%m-%d %H:%M:%S"),
                }
                user_list.append(user_data)

            total_users = len(user_list)

            today = date.today()
            new_users_today = sum(1 for user in users if user.created_at.date() == today)

            return {
                "users": user_list,
                "total_users": total_users,
                "new_users_today": new_users_today,
            }
        
    except Exception as e:
        print(e)
        return {"users": [], "total_users": 0, "new_users_today": 0}




def list_all_results():
    try:
        results = get_all_results()
        results_list = []
        for result in results:
            results_data = {
                "id": result.id,
                "market_id": result.market_id,
                "date": result.date.strftime("%Y-%m-%d %H:%M:%S"),
                "open_number": result.open_number,
                "close_number": result.close_number,
                "created_at": result.created_at.strftime("%Y-%m-%d %H:%M:%S"),
            }
            results_list.append(results_data)

        total_results = len(results_list)

        today = date.today()
        new_results_today = sum(
            1 for user in results if user.created_at.date() == today
        )

        return {
            "results": results_list,
            "total_results": total_results,
            "new_results_today": new_results_today,
        }

    except Exception as e:
        print(e)
        return {
            "error": str(e),
            "results": [],
            "total_results": 0,
            "new_results_today": 0,
        }


def list_bets():
    try:
        bets, today_bets, num_today_bets = list_all_bets()
        bets_list = []
        for bet in today_bets:
            bets_data = {
                "id": bet.id,
                "market_id": bet.market_id,
                "user_id": bet.user_id,
                "transaction_id": bet.transaction_id,
                "bet_number": bet.bet_number,
                "bet_amount": bet.amount,
                "bet_type": bet.bet_type,
                "status": bet.status,
                "settled": bet.settled,
                "created_at": bet.created_at.strftime("%Y-%m-%d %H:%M:%S"),
            }
            bets_list.append(bets_data)

        total_bets = len(bets_list)

        today = date.today()
        new_bets_today = sum(1 for user in bets if user.created_at.date() == today)

        return {
            "bets": bets_list,
            "total_bets": total_bets,
            "new_bets_today": new_bets_today,
        }
    except Exception as e:
        print(e)
        return {
            "bets": [],
            "total_bets": 0,
            "new_bets_today": 0,
        }


def list_transactions():
    try:
        transactions, withdrawals_today, deposits_today, num_withdrawals_today, num_deposits_today = list_all_transactions()

        transactions_list = []
        for transaction in transactions:
            transaction_data = {
                "id": transaction.id,
                "user_id": transaction.user_id,
                "type": transaction.type,
                "amount": transaction.amount,
                "status": transaction.status,
                "settled": transaction.settled,
                "mode": transaction.mode,
                "info": transaction.info,
                "bet_id": transaction.bet_id,
                "remark": transaction.remark,
                "created_at": transaction.created_at.strftime("%Y-%m-%d %H:%M:%S"),
            }
            transactions_list.append(transaction_data)

        withdrawals_list = []
        if withdrawals_today:
            for withdrawal in withdrawals_today:
                withdrawal_data = {
                    "id": withdrawal.id,
                    "user_id": withdrawal.user_id,
                    "type": withdrawal.type,
                    "amount": withdrawal.amount,
                    "status": withdrawal.status,
                    "settled": withdrawal.settled,
                    "mode": withdrawal.mode,
                    "info": withdrawal.info,
                    "bet_id": withdrawal.bet_id,
                    "remark": withdrawal.remark,
                    "created_at": withdrawal.created_at.strftime("%Y-%m-%d %H:%M:%S"),
                }
                withdrawals_list.append(withdrawal_data)
        else:
            withdrawals_list.append({"message": "No withdrawals today"})

        deposits_list = []
        if deposits_today:
            for deposit in deposits_today:
                deposit_data = {
                    "id": deposit.id,
                    "user_id": deposit.user_id,
                    "type": deposit.type,
                    "amount": deposit.amount,
                    "status": deposit.status,
                    "settled": deposit.settled,
                    "mode": deposit.mode,
                    "info": deposit.info,
                    "bet_id": deposit.bet_id,
                    "remark": deposit.remark,
                    "created_at": deposit.created_at.strftime("%Y-%m-%d %H:%M:%S"),
                }
                deposits_list.append(deposit_data)
        else:
            deposits_list.append({"message": "No deposits today"})

        total_transactions = len(transactions_list)
        today = date.today()

        new_withdrawals_today = sum(1 for withdrawal in withdrawals_today if withdrawal.created_at.date() == today)
        new_deposits_today = sum(1 for deposit in deposits_today if deposit.created_at.date() == today)

        return {
            "transactions": transactions_list,
            "withdrawals": withdrawals_list,
            "deposits": deposits_list,
            "total_transactions": total_transactions,
            "new_withdrawals_today": new_withdrawals_today,
            "new_deposits_today": new_deposits_today,
        }
    
    except Exception as e:
        print(e)
        return {"error": "Error occurred while fetching transactions"}


def list_user_bets():
    user_id = request.args.get("user_id")
    bets = list_user_specific_bets(user_id)
    bets_list = []
    try:
        for bet in bets:
            bets_data = {
                "id": bet.id,
                "market_id": bet.market_id,
                "user_id": bet.user_id,
                "transaction_id": bet.transaction_id,
                "bet_number": bet.bet_number,
                "bet_amount": bet.amount,
                "bet_type": bet.bet_type,
                "status": bet.status,
                "settled": bet.settled,
                "created_at": bet.created_at.strftime("%Y-%m-%d %H:%M:%S"),
            }
            bets_list.append(bets_data)

        return {"user_id": user_id, "bets": bets_list}
    except Exception as e:
        print(e)
        return {
            "error": "Error occurred while fetching bets for user {}".format(user_id)
        }


def list_user_transactions():
    user_id = request.args.get("user_id")
    page = int(request.args.get("page"))

    transactions = list_user_specific_transactions(user_id, page)
    transactions_list = []
    try:
        for transaction in transactions:
            transaction_data = {
                "id": transaction.id,
                "user_id": transaction.user_id,
                "type": transaction.type,
                "amount": transaction.amount,
                "status": transaction.status,
                "settled": transaction.settled,
                "mode": transaction.mode,
                "info": transaction.info,
                "bet_id": transaction.bet_id,
                "remark": transaction.remark,
                "created_at": transaction.created_at.strftime("%Y-%m-%d %H:%M:%S"),
            }
            transactions_list.append(transaction_data)

        return {"user_id": user_id, "transactions": transactions_list}
    except Exception as e:
        print(e)
        return {
            "error": "Error occurred while fetching transactions for user {}".format(
                user_id
            )
        }


def toggle_activation_user():
    try:
        user_id = int(request.args.get("user_id"))
        toggle_value = request.args.get("toggle_value")
        activate = toggle_value.lower() == "true"
        result = toggle_user_activation(user_id, activate=activate)
        return jsonify(result)
    except Exception as e:
        return jsonify({"success": False, "error": str(e)})



def cancel_bet_id():
    try:
        bet_id = int(request.args.get("bet_id"))
        toggle_value = request.args.get("toggle_value")
        if toggle_value is not None:
            settleValue = toggle_value.lower() == "true"
            result = cancel_bet(bet_id, settlementOk=settleValue)
            return jsonify(result)
        else:
            result = cancel_bet(bet_id)
            return jsonify(result)
    except Exception as e:
        return jsonify({"success": False, "error": str(e)})
    
    
    # try:
    #     bet_id = int(request.args.get("bet_id"))
    #     result = cancel_bet(bet_id)
    #     return jsonify(result)
    # except Exception as e:
    #     return jsonify({"success": False, "error": str(e)})


def add_market():
    data = request.get_json()
    name = data.get("name")
    open_time = data.get("open_time")
    close_time = data.get("close_time")
    result_time = data.get("result_time")

    if not (name and open_time and close_time and result_time):
        return jsonify({"error": "Missing required fields"}), 400

    try:
        new_market = add_market_entry(name, open_time, close_time, result_time)
        return jsonify({"success": True, "message": "Market added successfully"}), 201
    except Exception as e:
        return jsonify({"error": str(e)}), 500


def view_market_details():
    market_id = int(request.args.get("market_id"))

    market = get_market_by_id(market_id)
    if market:
        open_time = datetime.strptime(market.open_time, "%I:%M %p")
        close_time = datetime.strptime(market.close_time, "%I:%M %p")
        result_time = datetime.strptime(market.result_time, "%I:%M %p")

        return jsonify(
            {
                "id": market.id,
                "name": market.name,
                "open_time": open_time.strftime("%I:%M %p"),
                "close_time": close_time.strftime("%I:%M %p"),
                "result_time": result_time.strftime("%I:%M %p"),
            }
        )
    else:
        return jsonify({"error": "Market not found"}), 404


def view_all_market_details():
    try:
        markets = get_all_markets()
        markets_list = []
        for market in markets:
            markets_data = {
                "id": market.id,
                "name": market.name,
                "open_time": market.open_time,
                "close_time": market.close_time,
                "result_time": market.result_time,
            }
            markets_list.append(markets_data)

        total_markets = len(markets_list)

        return {
            "markets": markets_list,
            "total_markets": total_markets,
        }

    except Exception as e:
        print(e)
        return {
            "error": str(e),
            "markets": [],
            "total_markets": 0,
        }


def edit_market():
    data = request.get_json()
    market_id = data.get("market_id")
    name = data.get("name")
    open_time = data.get("open_time")
    close_time = data.get("close_time")
    result_time = data.get("result_time")

    print(data)
    if not (name or open_time or close_time or result_time):
        return jsonify({"error": "Nothing to update"}), 400

    try:
        market = get_market_by_id(market_id)
        if not market:
            return jsonify({"error": "Market not found"}), 404

        if name:
            market.name = name
        if open_time:
            market.open_time = open_time
        if close_time:
            market.close_time = close_time
        if result_time:
            market.result_time = result_time

        db.session.commit()
        return jsonify({"success": True, "message": "Market updated successfully"})
    except Exception as e:
        db.session.rollback()
        return jsonify({"error": str(e)}), 500


def delete_market():
    market_id = int(request.args.get("market_id"))

    try:
        success = delete_market_entry(market_id)
        if success:
            return jsonify({"success": True, "message": "Market deleted successfully"})
        else:
            return jsonify({"error": "Market not found"}), 404
    except Exception as e:
        db.session.rollback()
        return jsonify({"error": str(e)}), 500


def update_delhi_result():
    data = request.get_json()
    name = data.get("name")
    open_time = data.get("open_time")
    close_time = data.get("close_time")
    result_time = data.get("result_time")

    # Log the received data
    print("Received data:", data)

    if not (name and open_time and close_time and result_time):
        return jsonify({"error": "Missing required fields"}), 400

    # Return success message without adding to the database
    return jsonify({"success": True, "message": "Received data logged successfully"}), 200

