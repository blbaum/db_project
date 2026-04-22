import sys
import traceback
import logging
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
    # print(res)
    res = res.split('\n')  # split the header and data for printing
    print("<br/>" + "<br/>")
    print("<br/>" + "Table Artist after:"+"<br/>" +
          res[0] + "<br/>"+res[1] + "<br/>")
    for i in range(len(res)-2):
        print(res[i+2]+"<br/>")
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 add_new_artist.py "Artist Name" "Genre" in the terminal to test