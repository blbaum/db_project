import os
import sys
import traceback
import logging

sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
import python_db as python_db

try:
    python_db.open_database()   # open database
    
    # insert into item tables by getting the values passed from PHP

    query = """
        SELECT Artist.ArtistName, SUM(Ticket.Price) AS TotalRevenue
        FROM Artist
        JOIN Concert ON Artist.ArtistId = Concert.ArtistId
        JOIN Ticket ON Concert.ConcertId = Ticket.ConcertId
        GROUP BY Artist.ArtistId, Artist.ArtistName
        ORDER BY TotalRevenue DESC
        LIMIT 3;
        """

    res = python_db.executeSelect(query)
    print("<h3 class='container'>Concerts:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 view_top_3_artist_revenue.py