<?php

class LocationDAO {
    private static $db;

    static function initalize() {
        self::$db = new PDOService("Location");
    }

    static function getLocations() {

        $query = "SELECT * FROM Location";

        self::$db->query($query);

        self::$db->execute($query);

        return self::$db->resultSet();

    }

}