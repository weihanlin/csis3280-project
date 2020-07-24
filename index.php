<?php

// require the config
require_once("inc/config.inc.php");

// require all the entities
require_once("inc/Entity/Record.class.php");
require_once("inc/Entity/Location.class.php");
require_once("inc/Entity/Page.class.php");

// require all the utilities: PDO and DAO(s)
require_once("inc/Utility/RecordDAO.class.php");
require_once("inc/Utility/LocationDAO.class.php");
require_once("inc/Utility/PDOService.class.php");


//Initialize the DAO(s)
RecordDAO::initialize("Record");
LocationDAO::initialize("Location");


//If there was post data from an edit form then process it
//Accion para crear y para editar documento
if (!empty($_POST)) {
    $nb = new Feedback();                
    // if it is an edit (remember the hidden input)
    if ($_POST["action"] == "filter")  {
        $nb->setFeedbackID($_POST['id']);
   
    }
    else{

        echo "love";
    }               
}

//If there was a delete that came in via GET
if (isset($_GET["action"]))  {
    //Use the DAO to delete the corresponding Feedback
    if($_GET["action"] == "reserve"){
        header("Location: history.php");
    }
    else if($_GET["action"] == "perfil"){
        //set your file into header (header("Location: history.php");)

    }
    else if($_GET["action"] == "logout"){
        //set your file into header (header("Location: history.php");)
    
    }    
    
}


Page::$title="Welcome to Douglas' parking APP";
Page::header();



// List all location
$locations = LocationDAO::getLocations();


// List of avaliable parking
$space = RecordDAO::getRecords();


// Note: You need to use the results from the corresponding DAO that gives you the reservation list
//$Deparment = DepartmentDAO::getDepartment();
Page::getSelectForm($locations);
Page::getOrderData($space);
//Page::listFeedbacks($Record);


// Finally I need to call the last function from the HTML

Page::footer();