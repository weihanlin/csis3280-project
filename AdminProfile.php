<?php

require_once("inc/config.inc.php");
require_once("inc/Entity/Page.class.php");
require_once("inc/Entity/User.class.php");

require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/UserDAO.class.php");


session_start();
if(LoginManager::verifyLogin()){
LoginManager::verifyAdmin();

    UserDAO::initialize();

    Page::$title = "Modify Admin Permissions";
    Page::header();
    if(!empty($_GET)){
        if($_GET['action']=="add"){
            UserDAO::setAdmin($_GET['id'], true);
            echo"User ".$_GET['id']." was added to Admin";
        }
        if($_GET['action']=="remove"){
            UserDAO::setAdmin($_GET['id'], false);
            echo"User ".$_GET['id']." was removed from Admin";
        }
    }
    $user = UserDAO::getAllUsers();
    Page::displayUsers($user);
    Page::footer();
}
?>
