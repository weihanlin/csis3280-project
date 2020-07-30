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

Class Record    {
        //Attributes
        private $RecordID;
        private $UserID;
        private $SpaceID;
        private $LocationID;
        private $StartedAt;
        private $EndedAt;
        private $Paid;
        private $Amount;

        //Getters
        function getRecordID():int{
                return $this->RecordID;
            }

        function getUserID():int{
                return $this->UserID;
            }


        function getSpaceID():int{
                return $this->SpaceID;
            }
            
        function getLocationID():int{
                return $this->LocationID;
            }

        function getStartedAt():string{
                return $this->StartedAt;
            }
        
        function getEndedAt():string{   
            if($this->EndedAt==null){
                    $this->EndedAt = "";
            }

            return $this->EndedAt;

            }

        function getPaid():string{
            if($this->EndedAt==null || $this->EndedAt=="" ){
                $this->Paid = "Reservated";
            }
            
            if($this->Paid == 1){
                $this->Paid = "Paided";
            }
            return $this->Paid;
        }            

        function getAmount():string{
                return $this->Amount;
            }
        //Setters

        function setRecordID($record){
                $this->RecordID = $record;
            }

        function setUserID($userid){
                $this->UserID=$userid;
            }


        function setSpaceID($spaceid){
                $this->SpaceID=$spaceid;
            }
            
        function setLocationID($locationid){
                $this->LocationID=$locationid;
            }

        function setStartedAt($startedAt){
                $this->StartedAt=$startedAt;
            }
        
        function setEndedAt($endedAt){
                $this->EndedAt=$endedAt;
            }

        function setPaid($paid){
                $this->Paid=$paid;
        }            

        function setAmounts($amount){
                $this->Amount=$amount;
            }

}


?>