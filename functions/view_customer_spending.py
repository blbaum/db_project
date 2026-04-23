import os
import sys
import traceback
import logging

sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
import python_db as python_db

try:
    python_db.open_database()   # open database
    
    # insert into item tables by getting the values passed from PHP
    if len(sys.argv) < 2:
        city = ""
    else:
        customer_id = sys.argv[1]

    if customer_id == "" or customer_id.lower() == "null":
        res = python_db.executeSelect('SELECT CustomerName, Customer.CustomerID, Sum(Price) as TotalSpent FROM Ticket JOIN Customer ON Ticket.CustomerId = Customer.CustomerId GROUP BY Customer.CustomerId;')
    else:
        customer_id = customer_id.replace("'", "''")
        res = python_db.executeSelect('SELECT CustomerName, Customer.CustomerID, Sum(Price) as TotalSpent FROM Ticket JOIN Customer ON Ticket.CustomerId = Customer.CustomerId WHERE Customer.CustomerId = ' + customer_id + ' GROUP BY Customer.CustomerId;')
    
    print("<h3 class='container'>Customer Spending:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 view_customer_spending.py