<?php

require_once("inc/config.inc.php");
require_once("inc/Entity/Page.class.php");
require_once("inc/Entity/User.class.php");

require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/UserDAO.class.php");


session_start();
LoginManager::verifyLogin();
LoginManager::verifyAdmin();
    UserDAO::initialize();
    $user = UserDAO::getAllUsers();
    Page::header();
    Page::displayUsers($user);
    Page::footer();

?>