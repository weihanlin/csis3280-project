<?php
class SpaceDAO{
    private static $db;

    static function initialize() {
        self::$db = new PDOService("Space");
    }

    static function createSpace(Space $space) {

        //Validate the input value is clean
        if(!Validate::validateSpace($space))
            return 0;

        $q = "INSERT INTO Space (SpaceID, LocationID, Price)".
            " VALUES(:sid, :lid, :price)";

        self::$db->query($q);
        self::$db->bind(':sid', $space->getSpaceID());
        self::$db->bind(':lid', $space->getLocationID());
        self::$db->bind(':price', $space->getPrice());

        self::$db->execute();

        return self::$db->rowCount();
    }

    static function getSpace(int $sid, int $lid) {
        $q = "SELECT * FROM Space WHERE SpaceID =:sid AND LocationID =:lid";
        self::$db->query($q);
        self::$db->bind(':sid', $sid);
        self::$db->bind(':lid',$lid);
        self::$db->execute();

        return self::$db->singleResult();
    }

    static function delSpace(int $sid, int $lid) {
        $q = "DELETE FROM Space WHERE SpaceID =:sid AND LocationID =:lid";
        self::$db->query($q);
        self::$db->bind(':sid', $sid);
        self::$db->bind(':lid',$lid);
        self::$db->execute();
    }

    static function getSpaceList() {
        $q = "SELECT * FROM Space as s JOIN Location as l ON s.LocationID = l.LocationID ORDER BY s.LocationID ,s.SpaceID";
        self::$db->query($q);
        self::$db->execute();
        return self::$db->resultSet();

    }


    static function updateSpace(Space $s) {

        //Validate the input value is clean
        if(!Validate::validateSpace($s))
            return 0;

        $q = "UPDATE Space SET Price =:price WHERE SpaceID =:sid AND LocationID =:lid";
        self::$db->query($q);
        self::$db->bind(':price',$s->getPrice());
        self::$db->bind(':sid', $s->getSpaceID());
        self::$db->bind(':lid',$s->getLocationID());
        self::$db->execute();

        return self::$db->rowCount();
    }
}