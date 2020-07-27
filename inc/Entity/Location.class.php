<?php

class Location{
    private $LocationID;
    private $ShortName;
    private $Address;

    public function getLocationID()
    {
        return $this->LocationID;
    }

    public function setLocationID($LocationID)
    {
        $this->LocationID = $LocationID;
    }

    public function getShortName()
    {
        return $this->ShortName;
    }

    public function setShortName($ShortName)
    {
        $this->ShortName = $ShortName;
    }

    public function getAddress()
    {
        return $this->Address;
    }

    public function setAddress($Address)
    {
        $this->Address = $Address;
    }


}