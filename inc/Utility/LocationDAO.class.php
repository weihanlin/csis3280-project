<?php

class LocationDAO {
    private static $db;

    //init PDO for Location
    static function initialize() {
        self::$db = new PDOService("Location");
    }

    //get list from location
    static function getLocations() {

        $query = "SELECT * FROM Location";
        self::$db->query($query);
        self::$db->execute($query);

        return self::$db->resultSet();

    }

    //get location by id
    static function getLocation(int $lid) {
        $q = "SELECT * FROM Location WHERE LocationID =:lid";
        self::$db->query($q);
        self::$db->bind(':lid',$lid);
        self::$db->execute();

        return self::$db->singleResult();
    }

    //insert  data to location
    static function createLocation(Location $location) {

        //Validate the input value is clean
        if(!Validate::validateLocation($location))
            return 0;

        $q = "INSERT INTO Location (ShortName, Address)".
            " VALUES(:name, :addr)";

        self::$db->query($q);
        self::$db->bind(':name', $location->getShortName());
        self::$db->bind(':addr', $location->getAddress());

        self::$db->execute();

        return self::$db->rowCount();
    }

    //update location data
    static function updateLocation(Location $location) {

        //Validate the input value is clean
        if(!Validate::validateLocation($location))
            return 0;

        $q = "UPDATE Location SET ShortName =:name , Address =:addr WHERE LocationID =:lid";
        self::$db->query($q);
        self::$db->bind(':lid', $location->getLocationID());
        self::$db->bind(':name', $location->getShortName());
        self::$db->bind(':addr', $location->getAddress());
        self::$db->execute();

        return self::$db->rowCount();
    }

    //delete data from location
    static function delLocation(int $lid) {
        $q = "DELETE FROM Location WHERE LocationID =:lid";
        self::$db->query($q);
        self::$db->bind(':lid',$lid);
        self::$db->execute();
    }

    //search location by specific condition
    static function findLocations($name, $addr) {

        $name = filter_var($name,FILTER_SANITIZE_STRING);
        $addr = filter_var($addr,FILTER_SANITIZE_STRING);

        if(strlen($name) > 0 && strlen($addr) > 0) {
            $q = "SELECT * FROM Location WHERE ShortName =:name AND Address =:addr";
            self::$db->query($q);
            self::$db->bind(':name',$name);
            self::$db->bind(':addr',$addr);
        } elseif (strlen($name) > 0) {
            $q = "SELECT * FROM Location WHERE ShortName =:name";
            self::$db->query($q);
            self::$db->bind(':name',$name);
        } elseif (strlen($addr) > 0) {
            $q = "SELECT * FROM Location WHERE Address =:addr";
            self::$db->query($q);
            self::$db->bind(':addr',$addr);
        } else {
            $q = "SELECT * FROM Location";
            self::$db->query($q);
        }

        self::$db->execute();
        return self::$db->resultSet();
    }

    //Available location to reserve
    static function availableLoc(){
 
//        $query = "SELECT DISTINCT s.LocationID, l.ShortName,
//        (SELECT Paid
//         FROM Record as r
//         WHERE s.SpaceID = r.SpaceID and Paid=0 and s.LocationID = r.LocationID
//         ORDER BY RecordID
//         LIMIT 1
//        ) AS status
//        FROM Space as s JOIN Location as l
//        ON s.LocationID = l.LocationID
//        HAVING status IS NULL
//        Order by l.ShortName;";

        //replace the query command with efficient one
        $query = "SELECT s.LocationID , l.ShortName
                    FROM space as s join location as l on s.locationid = l.locationid
                    WHERE spaceid
                    NOT IN (select record.spaceid from record where paid = 0)
                    GROUP BY s.locationid";


        self::$db->query($query);
        self::$db->execute($query);

        return self::$db->resultSet();

    }
}