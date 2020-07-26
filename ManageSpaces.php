<?php

require ("inc/config.inc.php");

require ("inc/Entity/Location.class.php");
require ("inc/Entity/Space.class.php");
require ("inc/Entity/Page.class.php");

require ("inc/Utility/LocationDAO.class.php");
require ("inc/Utility/SpaceDAO.class.php");
require ("inc/Utility/PDOService.class.php");

LocationDAO::initalize();
SpaceDAO::initialize();

//process create
if(!empty($_POST) && isset($_POST['action'])){
    $ns = new Space();
    $ns->setLocationID($_POST['locationid']);
    $ns->setSpaceID($_POST['spaceid']);
    $ns->setPrice($_POST['price']);

    if($_POST['action'] == 'create')
        SpaceDAO::createSpace($ns);

    if($_POST['action'] == 'edit')
        SpaceDAO::updateSpace($ns);

    unset($ns);
}

//process delete
if(isset($_GET['action']) && $_GET['action'] == 'delete') {
    SpaceDAO::delSpace($_GET['sid'],$_GET['lid']);
}

Page::$title = "Parking Space Management";
Page::header();

$location = LocationDAO::getLocations();
$space = SpaceDAO::getSpaceList();
Page::listData($space);


//process edit
if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    $target = SpaceDAO::getSpace($_GET['sid'],$_GET['lid']);
    Page::editSpaceForm($target, $location);
}
else {
    Page::createSpaceForm($location);
}



Page::footer();