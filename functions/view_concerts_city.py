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
        city = sys.argv[1]

    if city == "" or city.lower() == "null":
        res = python_db.executeSelect('SELECT ConcertId, VenueName, City, ConcertDate, Concert.ArtistId, ArtistName FROM Concert JOIN Artist ON Concert.ArtistId = Artist.ArtistId;')
    else:
        city = city.replace("'", "''")
        res = python_db.executeSelect('SELECT ConcertId, VenueName, City, ConcertDate, Concert.ArtistId, ArtistName FROM Concert JOIN Artist ON Concert.ArtistId = Artist.ArtistId WHERE City = "' + city + '";')

    print("<h3 class='container'>Concerts:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 view_concerts_in_city.py "Null" for all cities or "City" for specific city