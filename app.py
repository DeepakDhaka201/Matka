import platform
from datetime import timedelta

import pymysql
from flask import Flask, redirect
from flask_cors import CORS
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.orm import DeclarativeBase

pymysql.install_as_MySQLdb()

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://root:password@localhost:3306/test'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

app.secret_key = 'UnseenUmbrellaNeverGotaShower'
app.permanent_session_lifetime = timedelta(minutes=60 * 24 * 7)
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


class Base(DeclarativeBase):
    pass


db = SQLAlchemy(model_class=Base)
db.init_app(app)


@app.errorhandler(404)
def page_not_found(error):
    return redirect('/')

from models.User import User
with app.app_context():
        db.create_all()

if __name__ == '__main__':

    if development:
        app.run(host='0.0.0.0', port=8000, debug=True)

    if production:
        from gevent.pywsgi import WSGIServer

        port = 8000
        http_server = WSGIServer(('', port), app)
        print(f'Server is running on http://localhost:{port}')
        http_server.serve_forever()
