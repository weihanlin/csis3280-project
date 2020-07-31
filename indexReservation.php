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
require_once("inc/Utility/LoginManager.class.php");
require_once("inc/Utility/LocationDAO.class.php");
require_once("inc/Utility/PDOService.class.php");
require_once("inc/Utility/UserDAO.class.php");


//Validate Session
session_start();
LoginManager::verifyLogin();


//Initialize the DAO(s)
RecordDAO::initialize("Record");
LocationDAO::initialize("Location");

UserDAO::initialize();
$user = UserDAO::getUser($_SESSION['email']);



//If there was post data from an edit form then process it
//Accion para crear y para editar documento

$opt = NULL;

if (!empty($_POST)) {               
    
    if ($_POST["action"] == "reserve")  {

            $nb = new Record();
            $nb->setUserID($user->getId());
            $nb->setSpaceID($_POST["id"]);
            $nb->setLocationID($_POST["lo"]);
            RecordDAO::reserved($nb);
   
    }
    else if ($_POST["action"] == "Filter")  {
      if($_POST["loc"] !="all"){
        $opt = $_POST["loc"];
      }
    }
              
}

//Evaluating the GET
if (isset($_GET["action"]))  {
    if($_GET["action"]=="reserve") {        
            $nb = new Record();
            $nb->setUserID($user->getId());
            $nb->setSpaceID($_GET["id"]);
            $nb->setLocationID($_GET["lo"]);
            RecordDAO::reserved($nb);
            echo "</br><p1>Your reservation is done!</p1>";        
      }
}

Page::$title="Douglas' parking APP";
Page::header();



// List all location
$locations = LocationDAO::availableLoc();


// List of avaliable parking
$space = RecordDAO::getAvailables_Parking($opt);

// Active reservation of User
$last = RecordDAO::last_reservation($user->getId());

// Note: You need to use the results from the corresponding DAO that gives you the reservation list
Page::getSelectForm($locations, $opt);
Page::statusUser($last, $user);
Page::getOrderData($locations, $space);


Page::footer();

?>