<?php

require_once("inc/config.inc.php");
require_once("inc/Entity/Page.class.php");
require_once("inc/Entity/User.class.php");

require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/UserDAO.class.php");
require_once("inc/Utility/Validate.class.php");

session_start();
if(isset($_SESSION['email'])){
    header("Location: UserProfile.php");
}
if(!empty($_POST)){
    if(Validate::validator()){
        UserDAO::initialize();
        $u = new User;
        $u->setPassword($_POST['password']);
        $u->setEmail($_POST['email']);
        $u->setFullName($_POST['fullname']);
        $u->setPhoneNumber($_POST['phonenumber']);

       UserDAO::createUser($u);
    header("Location: parkingLogin.php");
    }
    else{
        echo nl2br("Your entered info is incorrect\n");
        Page::displayRegistrationForm();
        Page::footer();
    }

}
else{

Page::header();
Page::displayRegistrationForm();
Page::footer();
}
?>
