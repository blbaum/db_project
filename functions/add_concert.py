import sys
import traceback
import logging
import python_db as python_db

try:
    python_db.open_database()   # open database
    
    # insert into item tables by getting the values passed from PHP
    venue_name = sys.argv[1]
    city = sys.argv[2]
    concert_date = sys.argv[3]
    artist_id = sys.argv[4]

    values = "'"+ venue_name + "','" + city + "','" + concert_date + "','" + artist_id + "'"

    python_db.insert("Concert (VenueName, City, ConcertDate, ArtistId)", values)
    res = python_db.executeSelect('SELECT * FROM Concert;')
    print(res)
    res = res.split('\n')  # split the header and data for printing
    print("<br/>" + "<br/>")
    print("<br/>" + "Concerts:"+"<br/>" +
          res[0] + "<br/>"+res[1] + "<br/>")
    for i in range(len(res)-2):
        print(res[i+2]+"<br/>")
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 add_new_concert.py "Venue Name" "City" "Year-Month-Day" "Existing Artist ID" in the terminal to test

# <select name="artist_id">
#   <option value="1">SZA</option>
#   <option value="2">Tame Impala</option>
# </select>