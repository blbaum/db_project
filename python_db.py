import mysql.connector
import json
import os
from html import escape

_creds_path = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'credentials.json')
with open(_creds_path, 'r') as chud:
    creds = json.load(chud)

host=creds["hostname"]
user=creds["user"]
password=creds["password"]
database=creds["database"]

def open_database():
    global conn
    conn = mysql.connector.connect(host=host,
                                user=user,
                                password=password,
                                database=database
                                )
    global cursor
    cursor = conn.cursor()

def executeSelect(query):
    cursor.execute(query)
    rows = cursor.fetchall()
    headers = [cd[0] for cd in cursor.description]
    if not rows:
        return "<p>Query returned nothing.</p>"
    html = ['<table border="1" class="container"><tr>']
    html += [f"<th>{escape(h)}</th>" for h in headers]
    html.append("</tr>")
    for row in rows:
        html.append("<tr>")
        html += [f"<td>{escape(str(v))}</td>" for v in row]
        html.append("</tr>")
    html.append("</table>")
    return "".join(html)

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
