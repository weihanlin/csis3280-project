<?php

/*
+------------+-----------+----------------------+
| LocationID | ShortName | Address              |
+------------+-----------+----------------------+
|          1 | ALFRE     | 71 Continental Alley |
|          2 | NIKOL     | 048 Welch Junction   |
|          3 | FILMO     | 5 Ilene Junction     |
+------------+-----------+----------------------+
3 rows in set (0.06 sec)
*/
Class Location    {
    private $LocationID;
    private $ShortName;

    //setter
    function setLocationID($locationid){
        $this->LocationID=$locationid;
    }

    function setShortName($shortname){
        $this->ShortName=$shortname;
    }

    //getter
    function getLocationID():int{
            return $this->LocationID;
        }

    function getShortName():string{
            return $this->ShortName;
        }

}

?>