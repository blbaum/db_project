import os
import sys
import traceback
import logging

sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
import python_db as python_db

try:
    python_db.open_database()   # open database
    
    # insert into item tables by getting the values passed from PHP
    artist_id = sys.argv[1]

    query = "SELECT ArtistName, VenueName, City, ConcertDate FROM Artist JOIN Concert ON Artist.ArtistId = Concert.ArtistId WHERE Artist.ArtistId = " + artist_id + ";"

    res = python_db.executeSelect(query)
    print("<h3 class='container'>Concerts for Artist:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 view_concerts_per_artist "Existing ArtistID"