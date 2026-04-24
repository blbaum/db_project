#!/bin/bash
# Remember to do turing$ chmod 755 database.sh
# to make it executable; 
#
# To run:  turing$ ./database.sh
# Create the textbook example tables in your own database on turing
# Replace "sgauch" with your own username
mysql <<EOFMYSQL

USE lsilva;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Venue;
DROP TABLE IF EXISTS Concert;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS Artist;

SET FOREIGN_KEY_CHECKS = 1;


CREATE TABLE Artist (
    ArtistId INT AUTO_INCREMENT PRIMARY KEY,
    ArtistName VARCHAR(100) NOT NULL,
    Genre VARCHAR(50) NOT NULL
);

CREATE TABLE Venue (
    VenueId INT PRIMARY KEY AUTO_INCREMENT,
    VenueName VARCHAR(100) NOT NULL,
    City VARCHAR(50) NOT NULL,
    State VARCHAR(2),
    Capacity INT NOT NULL
);

CREATE TABLE Concert (
    ConcertId INT AUTO_INCREMENT PRIMARY KEY,
    ConcertDate DATE NOT NULL,
    ArtistId INT NOT NULL,
    VenueId INT NOT NULL,
    
    FOREIGN KEY (ArtistId) REFERENCES Artist(ArtistId),
    FOREIGN KEY (VenueId) REFERENCES Venue(VenueId)
);

CREATE TABLE Customer (
    CustomerId INT AUTO_INCREMENT PRIMARY KEY,
    CustomerName VARCHAR(100) NOT NULL
);

CREATE TABLE Ticket (
    TicketId INT AUTO_INCREMENT PRIMARY KEY,
    ConcertId INT NOT NULL,
    CustomerId INT NOT NULL,
    SeatNumber VARCHAR(20) NOT NULL,
    Price DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (ConcertId) REFERENCES Concert(ConcertId),
    FOREIGN KEY (CustomerId) REFERENCES Customer(CustomerId),

    UNIQUE (ConcertId, SeatNumber)
);

-- ARTIST
INSERT INTO Artist (ArtistName, Genre) VALUES ('SZA', 'R&B');
INSERT INTO Artist (ArtistName, Genre) VALUES ('Tame Impala', 'Alternative');
INSERT INTO Artist (ArtistName, Genre) VALUES ('Sabrina Carpenter', 'Pop');
INSERT INTO Artist (ArtistName, Genre) VALUES ('The Weeknd', 'R&B');

-- VENUE
INSERT INTO Venue (VenueName, City, State, Capacity)
VALUES ('Starlight Arena', 'New York City', 'NY', 350);

INSERT INTO Venue (VenueName, City, State, Capacity)
VALUES ('River Stage', 'Chicago', 'IL', 500);

INSERT INTO Venue (VenueName, City, State, Capacity)
VALUES ('Skyline Hall', 'Los Angeles', 'CA', 200);

INSERT INTO Venue (VenueName, City, State, Capacity)
VALUES ('Blue Note Club', 'New Orleans', 'LA', 800);

-- CONCERT
INSERT INTO Concert (ConcertDate, ArtistId, VenueId)
VALUES ('2026-05-10', 1, 1);

INSERT INTO Concert (ConcertDate, ArtistId, VenueId)
VALUES ('2026-06-01', 2, 2);

INSERT INTO Concert (ConcertDate, ArtistId, VenueId)
VALUES ('2026-06-15', 3, 3);

INSERT INTO Concert (ConcertDate, ArtistId, VenueId)
VALUES ('2026-07-01', 4, 4);


-- CUSTOMER
INSERT INTO Customer (CustomerName) VALUES ('John Cena');
INSERT INTO Customer (CustomerName) VALUES ('Satoru Gojo');
INSERT INTO Customer (CustomerName) VALUES ('Kareem Sanchez');
INSERT INTO Customer (CustomerName) VALUES ('Max Verstappen');

-- TICKET
INSERT INTO Ticket (ConcertId, CustomerId, SeatNumber, Price)
VALUES (1, 1, 'A1', 120.00);

INSERT INTO Ticket (ConcertId, CustomerId, SeatNumber, Price)
VALUES (1, 2, 'A2', 120.00);

INSERT INTO Ticket (ConcertId, CustomerId, SeatNumber, Price)
VALUES (2, 3, 'B5', 95.00);

INSERT INTO Ticket (ConcertId, CustomerId, SeatNumber, Price)
VALUES (3, 4, 'C10', 150.00);


EOFMYSQL
