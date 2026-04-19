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
DROP TABLE IF EXISTS Concert;
DROP TABLE IF EXISTS Customer;
DROP TABLE IF EXISTS Artist;

SET FOREIGN_KEY_CHECKS = 1;


CREATE TABLE Artist (
    ArtistId INT PRIMARY KEY,
    ArtistName VARCHAR(100),
    Genre VARCHAR(50)
);

CREATE TABLE Concert (
    ConcertId INT PRIMARY KEY,
    VenueName VARCHAR(100),
    City VARCHAR(50),
    ConcertDate DATE,
    ArtistId INT,
    FOREIGN KEY (ArtistId) REFERENCES Artist(ArtistId)
);

CREATE TABLE Customer (
    CustomerId INT PRIMARY KEY,
    CustomerName VARCHAR(100)
);

CREATE TABLE Ticket (
    TicketId INT PRIMARY KEY,
    ConcertId INT,
    CustomerId INT,
    SeatNumber VARCHAR(20),
    Price DECIMAL(10,2),

    FOREIGN KEY (ConcertId) REFERENCES Concert(ConcertId),
    FOREIGN KEY (CustomerId) REFERENCES Customer(CustomerId)
);

-- ARTIST
INSERT INTO Artist VALUES (1, 'SZA', 'R&B');
INSERT INTO Artist VALUES (2, 'Tame Impala', 'Alternative');
INSERT INTO Artist VALUES (3, 'Sabrina Carpenter', 'Pop');
INSERT INTO Artist VALUES (4, 'The Weeknd', 'R&B');

-- CONCERT
INSERT INTO Concert VALUES (1, 'River Stage', 'Chicago', '2026-06-01', 2);
INSERT INTO Concert VALUES (2, 'Starlight Arena', 'New York', '2026-05-10', 1);
INSERT INTO Concert VALUES (3, 'Blue Note Club', 'New Orleans', '2026-07-01', 4);
INSERT INTO Concert VALUES (4, 'Skyline Hall', 'Los Angeles', '2026-06-15', 3);

-- CUSTOMER
INSERT INTO Customer VALUES (1, 'John Cena');
INSERT INTO Customer VALUES (2, 'Satoru Gojo');
INSERT INTO Customer VALUES (3, 'Kareem Sanchez');
INSERT INTO Customer VALUES (4, 'Max Verstappen');

-- TICKET
INSERT INTO Ticket VALUES (1, 1, 1, 'A1', 120.00);
INSERT INTO Ticket VALUES (2, 1, 2, 'A2', 120.00);
INSERT INTO Ticket VALUES (3, 2, 3, 'B5', 95.00);
INSERT INTO Ticket VALUES (4, 3, 4, 'C10', 150.00);

EOFMYSQL
