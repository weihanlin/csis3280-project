<?php

require_once ("inc/config.inc.php");

require_once ("inc/Entity/Location.class.php");
require_once ("inc/Entity/Page.class.php");

require_once ("inc/Utility/LocationDAO.class.php");
require_once ("inc/Utility/PDOService.class.php");
require_once ("inc/Utility/Validate.class.php");

Page::$title = "Parking Space Management - Location";
Page::header();

LocationDAO::initialize();


//process create
if(!empty($_POST) && isset($_POST['action'])){

    $note = Validate::validateLocationForm();
    if(count($note) > 0) {
        foreach ($note as $value) {
            echo "<div>{$value}</div>";
        }
    }
    else {

        $nl = new Location();

        $nl->setShortName($_POST['shortname']);
        $nl->setAddress($_POST['addr']);

        if ($_POST['action'] == 'create')
            LocationDAO::createLocation($nl);

        if ($_POST['action'] == 'edit') {
            $nl->setLocationID($_POST['locationid']);
            LocationDAO::updateLocation($nl);
        }

        unset($nl);
    }
}

//process delete
if(isset($_GET['action']) && $_GET['action'] == 'delete') {
    LocationDAO::delLocation($_GET['lid']);
}



$location = LocationDAO::getLocations();


//process edit
if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    $target = LocationDAO::getLocation($_GET['lid']);
    Page::editLocationForm($target);
}
else {
    Page::createLocationForm();
}

Page::listLocations($location);


Page::footer();