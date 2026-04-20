import sys
import traceback
import logging
import python_db


mysql_username = 'lsilva'  # please change to your username
mysql_password = 'iubaoXu1'  # please change to your MySQL password

try:
    python_db.open_database('localhost', mysql_username,
                            mysql_password, mysql_username)  # open database
    
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
    print(res)
    # res = res.split('\n')  # split the header and data for printing
    # print("<br/>" + "<br/>")
    # print("<br/>" + "Table Artist after:"+"<br/>" +
    #       res[0] + "<br/>"+res[1] + "<br/>")
    # for i in range(len(res)-2):
    #     print(res[i+2]+"<br/>")
    python_db.close_db()  # close db
except Exception as e:
    logging.error(traceback.format_exc())

# Use python3 view_top_3_artist_revenue.py