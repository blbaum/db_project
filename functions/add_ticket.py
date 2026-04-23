import os
import sys
import traceback
import logging

sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
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
    # terrible one liner but it works
    res = python_db.executeSelect('SELECT TicketId, Ticket.CustomerId, CustomerName, ArtistName, VenueName, City, ConcertDate, SeatNumber, Price FROM Ticket JOIN Concert ON Ticket.ConcertID = Concert.ConcertId JOIN Artist ON Concert.ArtistId = Artist.ArtistId JOIN Customer ON Ticket.CustomerID = Customer.CustomerId ORDER BY TicketId;')
    print("<h3 class='container'>Tickets:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    print(f'<table border="1" class="container"><tr><td>Duplicate entry for seat number {seat_number} - Please select a different seat number for this concert.</td></tr></table>')

# Use python3 add_new_ticket.py "Exisiting ConcertID" "Existing CustomerID" "Seat Number" "Price (ex: 123.45)"