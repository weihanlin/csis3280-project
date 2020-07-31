<?php

require_once ("inc/config.inc.php");

require_once ("inc/Entity/Location.class.php");
require_once ("inc/Entity/Page.class.php");

require_once ("inc/Utility/LocationDAO.class.php");
require_once ("inc/Utility/PDOService.class.php");
require_once ("inc/Utility/Validate.class.php");
//for checking login session
require_once("inc/Utility/LoginManager.class.php");
session_start();
LoginManager::verifyLogin();
LoginManager::verifyAdmin();

Page::$title = "Parking Space Management - Location";
Page::header();

LocationDAO::initialize();


//process create
if(!empty($_POST) && isset($_POST['action']) && $_POST['action'] != 'search'){

    $note = Validate::validateLocationForm();
    if(count($note) > 0) {
        foreach ($note as $value) {

            echo "<div class='alert alert-warning alert-dismissible' role='alert'>"
                ."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"
                ."<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>"
                ." {$value}</div>";
        }
    }
    else {

        $nl = new Location();

        $nl->setShortName($_POST['shortname']);
        $nl->setAddress($_POST['addr']);

        if ($_POST['action'] == 'create')
            LocationDAO::createLocation($nl);

        elseif ($_POST['action'] == 'edit') {
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
Page::confirmDeletion("Location");

//process search
if(!empty($_POST) && isset($_POST['action']) && $_POST['action'] == 'search')
    $location = LocationDAO::findLocations($_POST['shortname'], $_POST['addr']);
else
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