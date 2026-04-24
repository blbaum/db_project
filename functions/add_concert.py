import os
import sys
import traceback
import logging

sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
import python_db as python_db

try:
    python_db.open_database()   # open database
    
    venue_id = sys.argv[1]
    concert_date = sys.argv[2]
    artist_id = sys.argv[3]

    values = "'" + venue_id + "','" + concert_date + "','" + artist_id + "'"

    python_db.insert("Concert (VenueId, ConcertDate, ArtistId)", values)

    query = ("SELECT ConcertId, VenueName, City, ConcertDate, Concert.ArtistId, ArtistName "
             "FROM Concert "
             "JOIN Artist ON Concert.ArtistId = Artist.ArtistId "
             "JOIN Venue  ON Concert.VenueId  = Venue.VenueId;")
    res = python_db.executeSelect(query)
    print("<h3 class='container'>Concerts:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 add_concert.py "Existing Venue ID" "Year-Month-Day" "Existing Artist ID" in the terminal to test