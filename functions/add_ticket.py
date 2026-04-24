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

    seats = [seat.strip().upper() for seat in seat_number.split(",")]

    python_db.cursor.execute(
        "SELECT Venue.Capacity, COUNT(Ticket.TicketId) AS TicketsSold "
        "FROM Concert "
        "JOIN Venue ON Concert.VenueId = Venue.VenueId "
        "LEFT JOIN Ticket ON Ticket.ConcertId = Concert.ConcertId "
        "WHERE Concert.ConcertId = " + concert_id + " "
        "GROUP BY Concert.ConcertId, Venue.Capacity;"
    )
    row = python_db.cursor.fetchone()
    capacity = row[0]
    tickets_sold = row[1]
    remaining = capacity - tickets_sold
    if remaining < len(seats):
        raise Exception(
            f"Not enough seats. {tickets_sold} already sold ({remaining} left), {len(seats)} requested."
        )

    for seat in seats:
        if seat.strip() == '':
            continue
        python_db.cursor.execute(
            "SELECT * FROM Ticket WHERE ConcertId = " + concert_id +
            " AND SeatNumber = '" + seat + "';"
        )
        if python_db.cursor.fetchone():
            raise Exception(f"Seat {seat} is already taken for this concert - please select a different seat.")

        values = "'"+ concert_id + "','" + customer_id + "','" + seat + "','" + price + "'"

        python_db.insert("Ticket (ConcertID, CustomerID, SeatNumber, Price)", values)
    query = ("SELECT TicketId, Ticket.CustomerId, CustomerName, ArtistName, "
            "VenueName, City, ConcertDate, SeatNumber, Price "
            "FROM Ticket "
            "JOIN Concert  ON Ticket.ConcertID  = Concert.ConcertId "
            "JOIN Artist   ON Concert.ArtistId  = Artist.ArtistId "
            "JOIN Venue    ON Concert.VenueId   = Venue.VenueId "
            "JOIN Customer ON Ticket.CustomerID = Customer.CustomerId "
            "ORDER BY TicketId;")
    res = python_db.executeSelect(query)
    print("<h3 class='container'>Tickets:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    print(f'<table border="1" class="container"><tr><td>{e}</td></tr></table>')

# Use python3 add_new_ticket.py "Exisiting ConcertID" "Existing CustomerID" "Seat Number" "Price (ex: 123.45)"