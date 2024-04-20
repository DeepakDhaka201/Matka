import platform
from datetime import timedelta

import pymysql
from flask import Flask, redirect
from flask_cors import CORS
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.orm import DeclarativeBase

from api.bet import get_bets, place_bet
from api.dashboard import dashboard
from api.login import login, forgot_password, update_profile, update_user_password
from api.market import get_markets, get_content
from api.send_otp import send_otp, send_otp2
from api.signup import signup, logout, signup2
from api.wallet import get_wallet, get_wallet_transactions, get_withdraw_modes, update_bank_details, withdraw_money, \
    deposit_money, verify_deposit, deposit_via_bank 
from extension import db
from api.admin.single import *
from api.admin.single import render_admin_index, list_users, list_bets, list_transactions, list_user_transactions, list_user_bets, \
                                toggle_activation_user, cancel_bet_id, add_market, view_market_details, edit_market, \
                                delete_market ,list_all_results , view_all_market_details
                                

pymysql.install_as_MySQLdb()

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://root:@localhost:3306/test'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
app.config['UPLOAD_FOLDER'] = 'uploads/'

app.secret_key = 'UnseenUmbrellaNeverGotaShower'
app.permanent_session_lifetime = timedelta(minutes=60 * 24 * 7)
app.add_url_rule('/static/<path:filename>', view_func=app.send_static_file)
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

app.route('/admin_get_users')(list_users)
app.route('/admin_get_bets')(list_bets)
app.route('/admin_get_transactions')(list_transactions)
app.route('/admin_get_user_transactions',methods=['GET','POST'])(list_user_transactions)
app.route('/admin_get_user_bets',methods=['GET','POST'])(list_user_bets)
app.route('/admin_toggle_user_activation',methods=['GET','POST'])(toggle_activation_user)
app.route('/admin_cancel_bet_id',methods=['GET','POST'])(cancel_bet_id)
app.route('/admin_add_market',methods=['GET','POST'])(add_market)
app.route('/admin_view_market_details',methods=['GET','POST'])(view_market_details)
app.route('/admin_edit_market',methods=['GET','POST'])(edit_market)
app.route('/admin_delete_market',methods=['GET','POST'])(delete_market)
app.route('/admin_list_all_results')(list_all_results)
app.route('/admin_list_all_markets')(view_all_market_details)
app.route('/admin')(render_admin_index)
app.route('/render_users2admin')(render_users2admin)
app.route('/render_newusers2admin')(render_newusers2admin)
app.route('/render_bets2admin')(render_bets2admin)
app.route('/render_bets2daydepoits2admin')(render_today_withdrawals)
app.route('/render_2daywithdrawals2admin')(render_today_deposits)
app.route('/render_add_market',methods=['GET','POST'])(render_add_market)
app.route('/render_edit_market',methods=['GET','POST'])(render_edit_market)
app.route('/list_all_markets')(all_markets)
app.route('/delhi_result_update')(delhi_result_update)
app.route('/delhi_batch_result')(delhi_batch_history)
app.route('/batch_history')(batch_history)



from models.User import User
from models.Bet import Bet
from models.Transaction import Transaction
from models.Setting import Setting
from models.Market import Market
from models.Result import Result
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



