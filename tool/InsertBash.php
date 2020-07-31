<?php

require_once ("../inc/config.inc.php");
require_once ("../inc/Entity/Location.class.php");
require_once ("../inc/Utility/LocationDAO.class.php");
require_once ("../inc/Utility/PDOService.class.php");
require_once ("../inc/Utility/Validate.class.php");
require_once ("../inc/Entity/User.class.php");
require_once ("../inc/Utility/UserDAO.class.php");
require_once ("../inc/Entity/Space.class.php");
require_once ("../inc/Utility/SpaceDAO.class.php");

define("MOCK_USER", "MOCK_USER.csv");
define("MOCK_LOCATION", "MOCK_LOCATION.csv");
define("MOCK_SPACE", "MOCK_SPACES.csv");

$file_list = [MOCK_USER, MOCK_LOCATION, MOCK_SPACE];

LocationDAO::initialize();
UserDAO::initialize();
SpaceDAO::initialize();

if($argc == 3) {
    $fh = fopen($argv[2], 'r');
    if(!$fh){
        echo "Couldn't open the file:{$argv[1]}";
        return -1;
    }

    try {
        while (!feof($fh)) {
            $line = fgets($fh);
            if(trim($line) === "")
                continue;

            $temp = explode(',',$line);

            switch ($argv[1]){
                case '-u': //Insert User
                    inserUser($temp);
                    break;
                case '-l': //Insert Location
                    insertLocation($temp);
                    break;
                case '-s': //Insert Space
                    insertSpace($temp);
                    break;
                default:
                    echo "Please verify your command";
            }

            unset($target);

        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        fclose($fh);
    }
} elseif($argc == 2 && $argv[1] == '-a' ){

    foreach ($file_list as $item){
        $fh = fopen($item, 'r');

        if(!$fh){
            echo "Couldn't open the file: ".$item;
            return -1;
        }

        try {
            while (!feof($fh)) {
                $line = fgets($fh);
                if(trim($line) === "")
                    continue;
                $temp = explode(',',$line);

                if(!strcmp($item,MOCK_USER)){
                    inserUser($temp);
                }
                elseif (!strcmp($item,MOCK_LOCATION)) {
                    insertLocation($temp);
                }
                elseif (!strcmp($item,MOCK_SPACE)){
                    insertSpace($temp);
                }
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
        } finally {
            fclose($fh);
        }

        echo $item.": Done\n";
    }

}
else {
    echo "Usage: php InsertBash.php -[u|l|s] FILE_PATH\n";
    echo "  u: user file\n";
    echo "  l: location file\n";
    echo "  s: space file\n";
    echo "or php InsertBash.php -a";
}


function inserUser($temp) {
    $target = new User();
    $target->setFullName(trim($temp[0]));
    $target->setEmail(trim($temp[1]));
    $target->setPassword(trim($temp[2]));
    $target->setPhoneNumber(trim($temp[3]));
    UserDAO::createUser($target);

    if(!strcmp(trim($temp[4]),"TRUE"))
        UserDAO::setAdmin(trim($temp[1]),true);

    return true;
}

function insertSpace($temp) {
    $target = new Space();
    $target->setLocationID(trim($temp[0]));
    $target->setSpaceID(trim($temp[1]));
    $target->setPrice(trim($temp[2]));
    try{
        SpaceDAO::createSpace($target);
    } catch (Exception $e) {
        //mock data is generated randomly
        //just print out those constraint violation
        echo $e;
    }

    return true;
}

function insertLocation($temp) {
    $target = new Location();
    $target->setShortName(trim($temp[0]));
    $target->setAddress(trim($temp[1]));
    LocationDAO::createLocation($target);

    return true;
}