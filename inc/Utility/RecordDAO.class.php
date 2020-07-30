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

    //Initialize the RecordDAO
    static function initialize($className)    {
        self::$db = new PDOService($className); 
    }

    //Get Available space to park
    static function getAvailables_Parking($filter = null) : Array {


        if($filter==null){
            $selectAll="SELECT s.SpaceID, s.LocationID,l.ShortName,
            (SELECT Paid
             FROM Record as r
             WHERE s.SpaceID = r.SpaceID and Paid=0
             ORDER BY RecordID
             LIMIT 1
            ) AS status
            FROM Space as s JOIN Location as l
            ON s.LocationID = l.LocationID
            HAVING status IS NULL        
            Order by s.SpaceID;";
        }
        else{
            $selectAll="SELECT s.SpaceID, s.LocationID,l.ShortName,
            (SELECT Paid
             FROM Record as r
             WHERE s.SpaceID = r.SpaceID and Paid=0
             ORDER BY RecordID
             LIMIT 1
            ) AS status
            FROM Space as s JOIN Location as l
            ON s.LocationID = l.LocationID
            WHERE l.LocationID = :fil
            HAVING status IS NULL        
            Order by s.SpaceID;";
        }


        self::$db->query($selectAll);
        self::$db->bind(':fil', $filter);
        self::$db->execute();
        return self::$db->resultSet();
    }

    //Get record per user
    static function getRecords($user) : Array {
            //
            $selectAll="SELECT r.*, l.ShortName, ((TIMESTAMPDIFF(HOUR,r.StartedAt, NOW())+1)*s.Price) as temp_paid
            from Record as r 
            JOIN Location as L 
            ON r.LocationID = l.LocationID
            JOIN Space as s
            ON r.SpaceID = s.SpaceID
            WHERE UserID = :id
            ORDER BY r.RecordID desc";
    
            self::$db->query($selectAll);

            //bind                
            self::$db->bind(':id', $user);
            self::$db->execute();
            return self::$db->resultSet();
    
    }
    
    //Reservate a Space
    static function reserved(Record $nb):int{
            // QUERY BIND EXECUTE RETURN
        
            $sqlInsert ="INSERT INTO Record (UserID, SpaceID, LocationID, Paid, Amount) 
            values (:userID, :spaceID, :loc, false, 0)";            

            try{
                self::$db->query($sqlInsert);
                        //bind        
                
                        self::$db->bind(':userID', $nb->getUserID());
                        self::$db->bind(':spaceID', $nb->getSpaceID());
                        self::$db->bind(':loc', $nb->getLocationID());
                    
                
                        //Execute query
                        self::$db->execute();

            }
            catch(Exception $e){
                echo "Problem reservating place, please check the information. Thanks";
                return false;
            }
            
            return self::$db->rowCount();            

    }   

    static function paid_Reservation($id){
        
        //Calculate amount to paid.
        $amount = self::payment($id);

        //UPDATE RECORD to User
        $sql="UPDATE Record set EndedAt = now(), Paid = 1, Amount=:total where RecordID=:id;";
        self::$db->query($sql);

        //bind                
        self::$db->bind(':id', $id);
        self::$db->bind(':total', $amount->temp_paid);

        //Execute query
        self::$db->execute();
        return self::$db->rowCount();        

    }

    static function delete_Record($id){
        //UPDATE RECORD to User
        $sql="DELETE FROM Record where RecordID=:id;";
        self::$db->query($sql);

        //bind                
        self::$db->bind(':id', $id);

        //Execute query
        self::$db->execute();
        return self::$db->rowCount();        

    }

    //Get value to pay
    static function payment($id){

        $selectAll="SELECT ((TIMESTAMPDIFF(HOUR,r.StartedAt, NOW())+1)*s.Price) as temp_paid
            from Record as r 
            JOIN Space as s
            ON r.SpaceID = s.SpaceID
            WHERE RecordID = :id";

            self::$db->query($selectAll);
        //bind                
            self::$db->bind(':id', $id);
            self::$db->execute();
            return self::$db->singleResult();

    }
    
    static function last_reservation($id){

        $last="SELECT COUNT(RecordID) as pending, 
        (SELECT max(StartedAt) FROM record where UserID=:id) as lastdate  
        from record where EndedAt is null and UserID=:id";

        self::$db->query($last);
        //bind                
        self::$db->bind(':id', $id);
        self::$db->execute();
        return self::$db->singleResult();


    }
}



?>