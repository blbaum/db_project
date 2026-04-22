import sys
import traceback
import logging
import python_db as python_db

try:
    python_db.open_database()   # open database
    
    # insert into item tables by getting the values passed from PHP
    customer_name = sys.argv[1]

    values = "'"+ customer_name + "'"

    python_db.insert("Customer (CustomerName)", values)
    res = python_db.executeSelect('SELECT * FROM Customer;')
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 add_new_customer.py "Customer Name"