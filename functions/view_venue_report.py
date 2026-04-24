import os
import sys
import traceback
import logging

sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
import python_db as python_db

try:
    python_db.open_database()   # open database

    if len(sys.argv) < 2:
        venue_id = ""
    else:
        venue_id = sys.argv[1]

    # coalesce makes nulls zero
    base_query = ("SELECT Artist.ArtistName, Venue.VenueName, Venue.City, Concert.ConcertDate, "
                  "Venue.Capacity, "
                  "COUNT(Ticket.TicketId) AS Sold, "
                  "ROUND(100 * COUNT(Ticket.TicketId) / Venue.Capacity, 2) AS PercentFull, "
                  "COALESCE(SUM(Ticket.Price), 0) AS Revenue "
                  "FROM Concert "
                  "JOIN Venue  ON Concert.VenueId  = Venue.VenueId "
                  "JOIN Artist ON Concert.ArtistId = Artist.ArtistId "
                  "LEFT JOIN Ticket ON Ticket.ConcertId = Concert.ConcertId ")

    group_order = ("GROUP BY Concert.ConcertId, Artist.ArtistName, Venue.VenueName, Venue.City, "
                   "Concert.ConcertDate, Venue.Capacity "
                   "ORDER BY PercentFull DESC")

    if venue_id == "" or venue_id.lower() == "null":
        res = python_db.executeSelect(base_query + group_order + ";")
    else:
        venue_id = venue_id.replace("'", "''")
        res = python_db.executeSelect(base_query + " WHERE Venue.VenueId = " + venue_id + group_order + ";")

    print("<h3 class='container'>Venue Sellout Report:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())


