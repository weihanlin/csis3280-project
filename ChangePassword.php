<?php

require_once("inc/config.inc.php");
require_once("inc/Entity/Page.class.php");
require_once("inc/Entity/User.class.php");

require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/UserDAO.class.php");
require_once("inc/Utility/Validate.class.php");

session_start();

if(LoginManager::verifyLogin()){
UserDAO::initialize();
Page::$title = "Change your password";
$user = UserDAO::getUser($_SESSION['email']);

    if(isset($_POST['password_old'])){
        if ($user->verifyPassword($_POST['password_old'])) {
            if(Validate::validator()){
            UserDAO::updatePassword($_POST['password']);
            Page::header();
            echo "Your password has been updated";
            Page::changePassword();
            Page::footer();
            }
            else{
                Page::changePassword();
                Page::footer();
            }
        }
        else{
            Page::header();
            echo "Your password is incorrect!";
            Page::changePassword();
            Page::footer();
        }
}
else{

    Page::header();
    Page::changePassword();
    Page::footer();
}
}
?>
