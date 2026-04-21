import sys
import traceback
import logging
import python_db as python_db


mysql_username = 'lsilva'  # please change to your username
mysql_password = 'iubaoXu1'  # please change to your MySQL password

try:
    python_db.open_database('localhost', mysql_username,
                            mysql_password, mysql_username)  # open database
    
    # insert into item tables by getting the values passed from PHP
    artist_id = sys.argv[1]

    query = "SELECT ArtistName, VenueName, City, ConcertDate FROM Artist JOIN Concert ON Artist.ArtistId = Concert.ArtistId WHERE Artist.ArtistId = " + artist_id + ";"

    res = python_db.executeSelect(query)
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 view_concerts_per_artist "Existing ArtistID"