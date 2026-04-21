import sys
import traceback
import logging
import python_db as python_db


mysql_username = 'lsilva'  # please change to your username
mysql_password = 'iubaoXu1'  # please change to your MySQL password

try:
    python_db.open_database('localhost', mysql_username,
                            mysql_password, mysql_username)  # open database
    
    # insert into item tables by getting the values passed from PHP
    if len(sys.argv) < 2:
        city = "null"
    else:
        city = sys.argv[1]

    if city.lower() == "null":
        res = python_db.executeSelect('SELECT * FROM Concert;')
    else:
        res = python_db.executeSelect("SELECT * FROM Concert WHERE City = '" + city + "';")
    
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 view_concerts_in_city.py "Null" for all cities or "City" for specific city