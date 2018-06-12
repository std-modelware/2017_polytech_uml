from flask import Flask
from flask_bcrypt import Bcrypt
from flaskext.mysql import MySQL

app = Flask(__name__)
bcrypt = Bcrypt(app)
mysql = MySQL()

app.config['MYSQL_DATABASE_HOST'] = 'localhost'
app.config['MYSQL_DATABASE_PORT'] = 3306
app.config['MYSQL_DATABASE_DB'] = 'core'
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = 'root'
mysql.init_app(app)

from app import funcs
