import platform
from datetime import timedelta

import pymysql
from flask import Flask, redirect
from flask_cors import CORS
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.orm import DeclarativeBase

from api.admin import admin_index, admin_users_index, admin_update_user, admin_update_user_balance, admin_markets_index, \
    admin_add_update_market, admin_add_update_market_index, admin_delhi_result_update_index, \
    admin_api_delhi_result_update, admin_delhi_result_history_index, admin_api_revert_delhi_result, \
    admin_api_update_transaction, admin_transaction_history_index, admin_bet_history_index, admin_image_slider_index, \
    admin_api_delete_image_slider, admin_api_add_image_slider, admin_add_image_slider_index, admin_withdraw_modes_index, \
    admin_api_update_withdraw_mode, admin_rates_index, admin_api_update_rate, admin_update_withdraw_mode_index, \
    admin_notice_index, admin_api_update_setting, admin_settings_index, admin_api_update_settings, admin_login_index, \
    admin_api_login, admin_manage_wallet_index, admin_logout_index, admin_api_change_password, \
    admin_change_password_index, admin_app_update_index, admin_add_app_update_index, admin_api_add_app_update, \
    admin_api_remove_app_update
from api.bet import get_bets, place_bet
from api.dashboard import dashboard, web_index
from api.login import login, forgot_password, update_profile, update_user_password, get_config
from api.market import get_markets, get_content
from api.send_otp import send_otp, send_otp2
from api.signup import signup, logout, signup2
from api.wallet import get_wallet, get_wallet_transactions, get_withdraw_modes, update_bank_details, withdraw_money, \
    deposit_money, verify_deposit, deposit_via_bank
from extension import db

pymysql.install_as_MySQLdb()

app = Flask(__name__, static_url_path='/admin/static')
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://root:spaceback3423@localhost:3306/samrat'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['UPLOAD_FOLDER'] = 'uploads/'

app.secret_key = 'UnseenUmbrellaNeverGotaShower'
app.permanent_session_lifetime = timedelta(minutes=60 * 24 * 7)
#app.add_url_rule('/<path:filename>', view_func=app.send_static_file)
CORS(app)

system = platform.system()
development = False
production = False

if system == 'Windows':
    print('Running on Windows By Default Development Server')
    development = True
elif system == 'Linux':
    print('Running on Ubuntu or another Linux distribution By Default Production Server')
    production = True
elif system == 'Darwin':
    print('Running on macOS By Default Development Server')
    development = True
else:
    print(f'Unsupported operating system: {system}')

db.init_app(app)

# @app.errorhandler(404)
# def page_not_found(error):
#     return redirect('/')

# Import routes and create routes for each methods defined in api directory
app.route('/')(web_index)

app.route('/get_config', methods=['GET', 'POST'])(get_config)
app.route('/login', methods=['POST'])(login)
app.route('/signup', methods=['POST'])(signup2)
app.route('/logout', methods=['POST'])(logout)
app.route('/forgot_password', methods=['POST'])(forgot_password)
app.route('/update_password', methods=['POST'])(update_user_password)
app.route('/update_profile', methods=['POST'])(update_profile)

app.route('/send_otp', methods=['POST'])(send_otp2)
app.route('/get_bets', methods=['GET', 'POST'])(get_bets)
app.route('/place_bet', methods=['POST'])(place_bet)
app.route('/dashboard', methods=['GET', 'POST'])(dashboard)
app.route('/get_markets', methods=['GET', 'POST'])(get_markets)
app.route('/get_wallet', methods=['GET', 'POST'])(get_wallet)
app.route('/get_transactions', methods=['GET', 'POST'])(get_wallet_transactions)
app.route('/get_withdraw_modes', methods=['GET', 'POST'])(get_withdraw_modes)
app.route('/update_bank_details', methods=['POST'])(update_bank_details)
app.route('/submit_withdraw', methods=['POST'])(withdraw_money)
app.route('/create_deposit', methods=['POST'])(deposit_money)
app.route('/verify_deposit', methods=['POST'])(verify_deposit)
app.route('/deposit_bank', methods=['POST'])(deposit_via_bank)
app.route('/get_content', methods=['GET', 'POST'])(get_content)

app.route('/admin/login')(admin_login_index)
app.route('/admin/api/login', methods=['POST'])(admin_api_login)
app.route('/admin/logout')(admin_logout_index)
app.route('/admin/change_password')(admin_change_password_index)
app.route('/admin/api/change_password', methods=['POST'])(admin_api_change_password)

app.route('/admin/dashboard')(admin_index)
app.route('/admin/users')(admin_users_index)
app.route('/admin/update_user', methods=['POST'])(admin_update_user)
app.route('/admin/update_user_balance', methods=['POST'])(admin_update_user_balance)

app.route('/admin/markets')(admin_markets_index)
app.route('/admin/add_update_market')(admin_add_update_market_index)
app.route('/admin/api/add_update_market', methods=['POST'])(admin_add_update_market)
app.route('/admin/delhi_result_update', )(admin_delhi_result_update_index)
app.route('/admin/api/delhi_result_update', methods=['POST'])(admin_api_delhi_result_update)
app.route('/admin/delhi_result_history')(admin_delhi_result_history_index)
app.route('/admin/api/delhi_revert_result', methods=['POST'])(admin_api_revert_delhi_result)

app.route('/admin/transaction_history')(admin_transaction_history_index)
app.route('/admin/api/update_transaction', methods=['POST'])(admin_api_update_transaction)

app.route('/admin/manage_wallet')(admin_manage_wallet_index)

app.route('/admin/bet_history')(admin_bet_history_index)

app.route('/admin/image_slider')(admin_image_slider_index)
app.route('/admin/api/delete_image_slider', methods=['POST'])(admin_api_delete_image_slider)
app.route('/admin/add_image_slider')(admin_add_image_slider_index)
app.route('/admin/api/add_image_slider', methods=['POST'])(admin_api_add_image_slider)

app.route('/admin/withdraw_modes')(admin_withdraw_modes_index)
app.route('/admin/update_withdraw_mode')(admin_update_withdraw_mode_index)
app.route('/admin/api/update_withdraw_mode', methods=['POST'])(admin_api_update_withdraw_mode)

app.route('/admin/rates')(admin_rates_index)
app.route('/admin/api/update_rate', methods=['POST'])(admin_api_update_rate)

app.route('/admin/notice')(admin_notice_index)

app.route('/admin/settings')(admin_settings_index)
app.route('/admin/api/update_setting', methods=['POST'])(admin_api_update_setting)
app.route('/admin/api/update_settings', methods=['POST'])(admin_api_update_settings)


app.route('/admin/app_updates')(admin_app_update_index)
app.route('/admin/add_app_update')(admin_add_app_update_index)
app.route('/admin/api/add_app_update', methods=['POST'])(admin_api_add_app_update)
app.route('/admin/api/delete_app_update', methods=['POST'])(admin_api_remove_app_update)

from models.User import User
from models.Bet import Bet
from models.Transaction import Transaction
from models.Setting import Setting
from models.Market import Market
from models.Result import Result
from models.WithdrawMode import WithdrawMode
from models.Rate import Rate


with app.app_context():
    db.create_all()

if __name__ == '__main__':

    if development:
        app.run(host='0.0.0.0', port=5000, debug=True)

    if production:
        from gevent.pywsgi import WSGIServer

        port = 8006
        http_server = WSGIServer(('', port), app)
        print(f'Server is running on http://localhost:{port}')
        http_server.serve_forever()
