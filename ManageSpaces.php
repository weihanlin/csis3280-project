<?php

require_once ("inc/config.inc.php");

require_once ("inc/Entity/Location.class.php");
require_once ("inc/Entity/Space.class.php");
require_once ("inc/Entity/Page.class.php");

require_once ("inc/Utility/LocationDAO.class.php");
require_once ("inc/Utility/SpaceDAO.class.php");
require_once ("inc/Utility/PDOService.class.php");
require_once ("inc/Utility/Validate.class.php");

Page::$title = "Parking Space Management - Space";
Page::header();

LocationDAO::initialize();
SpaceDAO::initialize();


//process create
if(!empty($_POST) && isset($_POST['action'])){

    $note = Validate::validateSpaceForm();
    if(count($note) != 0){
        foreach ($note as $value) {
            echo "<div>{$value}</div>";
        }
    }
    else {
        $ns = new Space();
        $ns->setLocationID($_POST['locationid']);
        $ns->setSpaceID($_POST['spaceid']);
        $ns->setPrice($_POST['price']);

        if ($_POST['action'] == 'create')
            SpaceDAO::createSpace($ns);

        if ($_POST['action'] == 'edit')
            SpaceDAO::updateSpace($ns);

        unset($ns);
    }
}

//process delete
if(isset($_GET['action']) && $_GET['action'] == 'delete') {
    SpaceDAO::delSpace($_GET['sid'],$_GET['lid']);
}



$location = LocationDAO::getLocations();
$space = SpaceDAO::getSpaceList();
Page::listSpaces($space);


//process edit
if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    $target = SpaceDAO::getSpace($_GET['sid'],$_GET['lid']);
    Page::editSpaceForm($target, $location);
}
else {
    Page::createSpaceForm($location);
}



Page::footer();