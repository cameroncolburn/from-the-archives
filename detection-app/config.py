import mysql.connector
from mysql.connector import Error

db_config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'photos_db',
    'raise_on_warnings': True
}

def create_conn():
    conn = None
    try:
        conn = mysql.connector.connect(**db_config)
    except Error as e:
        print(e)
    return conn