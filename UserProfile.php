<?php

require_once("inc/config.inc.php");
require_once("inc/Entity/Page.class.php");
require_once("inc/Entity/User.class.php");

require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/UserDAO.class.php");


session_start();

if(LoginManager::verifyLogin()){

    UserDAO::initialize();
    $user = UserDAO::getUser($_SESSION['email']);
    Page::$title = "User Profile";
    Page::header();
    Page::displayUserDetails($user);
    ?><a href="UserEdit.php"> Edit Profile</a><br><a href="ChangePassword.php">Change Password</a><?php
    Page::footer();
}
?>
