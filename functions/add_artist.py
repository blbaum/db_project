import os
import sys
import traceback
import logging

sys.path.insert(0, os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
import python_db as python_db

try:
    python_db.open_database()   # open database
    
    # insert into item tables by getting the values passed from PHP
    name = sys.argv[1]
    genre = sys.argv[2]

    name = name.replace("'", "''")
    genre = genre.replace("'", "''")

    values = "'"+ name + "','" + genre + "'"

    python_db.insert("Artist (ArtistName, Genre)", values)
    res = python_db.executeSelect('SELECT * FROM Artist;')
    print("<h3 class='container'>Artists:</h3>")
    print(res)
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 add_new_artist.py "Artist Name" "Genre" in the terminal to test