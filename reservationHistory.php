<?php

// require the config
require_once("inc/config.inc.php");

// require all the entities
require_once("inc/Entity/Record.class.php");
require_once("inc/Entity/Location.class.php");
require_once("inc/Entity/Page.class.php");
require_once("inc/Entity/User.class.php");

// require all the utilities: PDO and DAO(s)
require_once("inc/Utility/RecordDAO.class.php");
require_once("inc/Utility/LocationDAO.class.php");
require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/UserDAO.class.php");


//Validate Session
session_start();
LoginManager::verifyLogin();



//Initialize the DAO(s)
RecordDAO::initialize("Record");
LocationDAO::initialize("Location");
UserDAO::initialize();

//return if the session does not exist
if(!isset($_SESSION['email'])){
  return;
}

//Get user data
$user = UserDAO::getUser($_SESSION['email']);


//Evaluating the GET
if (isset($_GET["action"]))  {

    switch ($_GET["action"]) {
        case "paid":
          RecordDAO::paid_Reservation($_GET["id"]);
        break;
        case "delete":
          RecordDAO::delete_Record($_GET["id"]);
          break;
        default:
          echo "This function is not working";
        break;
      }
}

//Print header
Page::$title="History Module";
Page::header();



//List of reservartion records
$space = RecordDAO::getRecords($user->getId());

// show Data
Page::getHistoryData($space);

Page::footer();

?>