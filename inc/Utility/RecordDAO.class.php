<?php

/*
| Field      | Type       | Null | Key | Default           | Extra                       |
+------------+------------+------+-----+-------------------+-----------------------------+
| RecordID   | int(11)    | NO   | PRI | NULL              | auto_increment              |
| UserID     | int(11)    | YES  | MUL | NULL              |                             |
| SpaceID    | int(11)    | YES  | MUL | NULL              |                             |
| LocationID | int(11)    | YES  |     | NULL              |                             |
| StartedAt  | timestamp  | NO   |     | CURRENT_TIMESTAMP |                             |
| EndedAt    | timestamp  | YES  |     | NULL              | on update CURRENT_TIMESTAMP |
| Paid       | tinyint(1) | NO   |     | 0                 |                             |
| Amount     | float      | NO   |     | NULL              |                             |
+------------+------------+------+-----+-------------------+-----------------------------+
8 rows in set (0.08 sec)
*/



class RecordDAO  {

    //Static DB member to store the database
    private static $db;  

    //Initialize the DepartmentDAO
    static function initialize($className)    {
        //Remember to send in the class name for this DAO
        self::$db = new PDOService($className);
    }

    //Get all the Department
    static function getRecords() : Array {
        
        // SELECT        

        //Prepare the Query
        
        //Return the results
        
        //Return the resultSet

        $selectAll="SELECT s.SpaceID, l.ShortName,
        (SELECT Paid
         FROM Record as r
         WHERE s.SpaceID = r.SpaceID
         ORDER BY RecordID
         LIMIT 1
        ) AS status
        FROM Space as s JOIN Location as l
        ON s.LocationID = l.LocationID
        HAVING status IS NULL
        Order by s.SpaceID;";

        self::$db->query($selectAll);
        self::$db->execute();
        return self::$db->resultSet();
    }
}


?>