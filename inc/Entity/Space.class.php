<?php

class Space
{
    private $SpaceID;
    private $LocationID;
    private $Price;
    private $ShortName;

    public function getSpaceID()
    {
        return $this->SpaceID;
    }

    public function setSpaceID($SpaceID)
    {
        $this->SpaceID = $SpaceID;
    }

    public function getLocationID()
    {
        return $this->LocationID;
    }

    public function setLocationID($LocationID)
    {
        $this->LocationID = $LocationID;
    }

    public function getPrice()
    {
        return $this->Price;
    }

    public function setPrice($Price)
    {
        $this->Price = $Price;
    }

    public function getShortName()
    {
        return $this->ShortName;
    }



}