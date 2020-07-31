<?php

class LocationDAO {
    private static $db;

    static function initialize() {
        self::$db = new PDOService("Location");
    }

    static function getLocations() {

        $query = "SELECT * FROM Location";
        self::$db->query($query);
        self::$db->execute($query);

        return self::$db->resultSet();

    }

    static function getLocation(int $lid) {
        $q = "SELECT * FROM Location WHERE LocationID =:lid";
        self::$db->query($q);
        self::$db->bind(':lid',$lid);
        self::$db->execute();

        return self::$db->singleResult();
    }

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

    static function delLocation(int $lid) {
        $q = "DELETE FROM Location WHERE LocationID =:lid";
        self::$db->query($q);
        self::$db->bind(':lid',$lid);
        self::$db->execute();
    }

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
 
        $query = "SELECT DISTINCT s.LocationID, l.ShortName, 
        (SELECT Paid
         FROM Record as r
         WHERE s.SpaceID = r.SpaceID and Paid=0 and s.LocationID = r.LocationID
         ORDER BY RecordID
         LIMIT 1
        ) AS status
        FROM Space as s JOIN Location as l
        ON s.LocationID = l.LocationID
        HAVING status IS NULL        
        Order by l.ShortName;";

        self::$db->query($query);
        self::$db->execute($query);

        return self::$db->resultSet();

    }
}