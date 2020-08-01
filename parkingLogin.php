<?php

require_once("inc/config.inc.php");
require_once("inc/Entity/Page.class.php");
require_once("inc/Entity/User.class.php");

require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/UserDAO.class.php");

session_start();
if(isset($_SESSION['email'])){
    header("Location: UserProfile.php");
}

if (!empty($_POST['email'])) {

    UserDAO::initialize();
    $user = UserDAO::getUser($_POST['email']);
    if ($user instanceof User) {

        if ($user->verifyPassword($_POST['password'])) {

            $_SESSION['email'] = $user->getEmail();
            if ($user->getManager()) {
                $_SESSION['isAdmin'] = true;
                header("Location: indexReservation.php");
            } else {
                header("Location: indexReservation.php");
            }
        } else {
            Page::header();
            echo ("Invalid Email/Password");
            Page::displayLogin();
            Page::footer();
        }
    } else {
        Page::header();
        echo ("Invalid User, Please Register an Account");
        Page::displayLogin();
        Page::footer();
    }
} else {
    Page::header();
    Page::displayLogin();
    Page::footer();
}
