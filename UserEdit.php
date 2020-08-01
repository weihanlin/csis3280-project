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
Page::$title = "User Profile";
$user = UserDAO::getUser($_SESSION['email']);

    if(isset($_POST['password'])){
        if ($user->verifyPassword($_POST['password'])) {
            if(Validate::validator()){
            $u = new User;

            $u->setFullName($_POST['fullname']);
            $u->setPhoneNumber($_POST['phonenumber']);
            UserDAO::updateUser($u);
            Page::header();
            echo "Your profile has been updated";
            $user = UserDAO::getUser($_SESSION['email']);
            Page::editUser($user);
            Page::footer();
        }
        else{
            Page::editUser($user);
            Page::footer();
        }
    }
    else{
    Page::header();
    echo "Your password is incorrect";
    Page::editUser($user);
    Page::footer();
    }
}
else{

    Page::header();
    Page::editUser($user);
    Page::footer();
}
}
?>
