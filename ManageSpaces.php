<?php

require_once ("inc/config.inc.php");

require_once ("inc/Entity/Location.class.php");
require_once ("inc/Entity/Space.class.php");
require_once ("inc/Entity/Page.class.php");

require_once ("inc/Utility/LocationDAO.class.php");
require_once ("inc/Utility/SpaceDAO.class.php");
require_once ("inc/Utility/PDOService.class.php");
require_once ("inc/Utility/Validate.class.php");
//for checking login session
require_once("inc/Utility/LoginManager.class.php");
session_start();
if(LoginManager::verifyLogin() == false || LoginManager::verifyAdmin() == false )
    return;


Page::$title = "Parking Space Management - Space";
Page::header();

LocationDAO::initialize();
SpaceDAO::initialize();


//process create
if(!empty($_POST) && isset($_POST['action']) && $_POST['action'] != 'search'){

    $note = Validate::validateSpaceForm();
    if(count($note) != 0){
        foreach ($note as $value) {
            echo "<div class='alert alert-warning alert-dismissible' role='alert'>"
                ."<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"
                ."<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>"
                ." {$value}</div>";
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
Page::confirmDeletion("Space");


$location = LocationDAO::getLocations();

//process search
if(!empty($_POST) && isset($_POST['action']) && $_POST['action'] == 'search')
    $space = SpaceDAO::findSpaces($_POST['locationid'], $_POST['spaceid'], $_POST['price']);
else
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