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
}