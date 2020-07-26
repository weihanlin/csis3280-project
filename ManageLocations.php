<?php

require ("inc/config.inc.php");

require ("inc/Entity/Location.class.php");
require ("inc/Entity/Page.class.php");

require ("inc/Utility/LocationDAO.class.php");
require ("inc/Utility/PDOService.class.php");

LocationDAO::initialize();

//process create
if(!empty($_POST) && isset($_POST['action'])){
    $nl = new Location();

    $nl->setLocationID($_POST['locationid']);
    $nl->setShortName($_POST['shortname']);
    $nl->setAddress($_POST['addr']);

    if($_POST['action'] == 'create')
        LocationDAO::createLocation($nl);

    if($_POST['action'] == 'edit')
        LocationDAO::updateLocation($nl);

    unset($nl);
}

//process delete
if(isset($_GET['action']) && $_GET['action'] == 'delete') {
    LocationDAO::delLocation($_GET['lid']);
}

Page::$title = "Parking Space Management - Location";
Page::header();

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