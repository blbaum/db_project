import mysql.connector
import json

with open('credentials.json', 'r') as fart:
    creds = json.load(fart)

host=creds["hostname"]
user=creds["user"]
password=creds["password"]
database=creds["database"]

print(host)
print(user)
print(password)
print(database)

def open_database(hostname=host, user_name=user, mysql_pw=password, database_name=database):
    global conn
    conn = mysql.connector.connect(host=hostname,
                                   user=user_name,
                                   password=mysql_pw,
                                   database=database_name
                                   )
    global cursor
    cursor = conn.cursor()

def executeSelect(query):
    return cursor.execute(query)

def insert(table, values):
    query = "INSERT into " + table + " values (" + values + ")" + ';'
    cursor.execute(query)
    conn.commit()

def executeUpdate(query):  # use this function for delete and update
    cursor.execute(query)
    conn.commit()


def close_db():  # use this function to close db
    cursor.close()
    conn.close()
