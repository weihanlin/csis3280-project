DROP DATABASE IF EXISTS ParkingProject;
CREATE DATABASE ParkingProject;
use ParkingProject;

CREATE TABLE User (
    FullName VARCHAR(50) NOT NULL ,
    Email VARCHAR(50) ,
    Password VARCHAR(128) NOT NULL ,
    PhoneNumber VARCHAR(20) NOT NULL ,
    Manager BOOLEAN NOT NULL DEFAULT FALSE ,
    PRIMARY KEY (Email)
) ENGINE = InnoDB;

CREATE TABLE Location (
    LocationID INT AUTO_INCREMENT,
    ShortName CHAR(5) NOT NULL ,
    Address VARCHAR(255) NOT NULL ,
    PRIMARY KEY (LocationID)
) ENGINE = InnoDB;

CREATE TABLE Space (
    SpaceID INT,
    LocationID INT,
    Price FLOAT,
    PRIMARY KEY (SpaceID, LocationID),
    CONSTRAINT fk_space_location FOREIGN KEY (LocationID) REFERENCES Location (LocationID)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE Record (
    RecordID INT AUTO_INCREMENT,
    Email VARCHAR(50) ,
    SpaceID INT ,
    LocationID INT ,
    StartedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    EndedAt TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP ,
    Paid BOOLEAN NOT NULL DEFAULT FALSE,
    Amount FLOAT NOT NULL ,
    PRIMARY KEY (RecordID),
    CONSTRAINT fk_record_space FOREIGN KEY (SpaceID, LocationID) REFERENCES Space (SpaceID, LocationID)
        ON UPDATE CASCADE
        ON DELETE CASCADE ,
    CONSTRAINT fk_record_user FOREIGN KEY (Email) REFERENCES User (Email)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB;