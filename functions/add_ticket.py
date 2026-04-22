import sys
import traceback
import logging
import python_db as python_db

try:
    python_db.open_database()   # open database
    
    # insert into item tables by getting the values passed from PHP
    concert_id = sys.argv[1]
    customer_id = sys.argv[2]
    seat_number = sys.argv[3]
    price = sys.argv[4]

    values = "'"+ concert_id + "','" + customer_id + "','" + seat_number + "','" + price + "'"

    python_db.insert("Ticket (ConcertID, CustomerID, SeatNumber, Price)", values)
    res = python_db.executeSelect('SELECT * FROM Ticket;')
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 add_new_ticket.py "Exisiting ConcertID" "Existing CustomerID" "Seat Number" "Price (ex: 123.45)"