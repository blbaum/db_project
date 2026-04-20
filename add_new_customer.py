import sys
import traceback
import logging
import python_db


mysql_username = 'lsilva'  # please change to your username
mysql_password = 'iubaoXu1'  # please change to your MySQL password

try:
    python_db.open_database('localhost', mysql_username,
                            mysql_password, mysql_username)  # open database
    
    # insert into item tables by getting the values passed from PHP
    customer_name = sys.argv[1]

    values = "'"+ customer_name + "'"

    python_db.insert("Customer (CustomerName)", values)
    res = python_db.executeSelect('SELECT * FROM Customer;')
    print(res)
    # res = res.split('\n')  # split the header and data for printing
    # print("<br/>" + "<br/>")
    # print("<br/>" + "Table Artist after:"+"<br/>" +
    #       res[0] + "<br/>"+res[1] + "<br/>")
    # for i in range(len(res)-2):
    #     print(res[i+2]+"<br/>")
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 add_new_customer "Customer Name"