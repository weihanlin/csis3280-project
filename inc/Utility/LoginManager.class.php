<?php

class LoginManager  {

    static function verifyLogin()   {

        if(session_id() == "" && !isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION["email"])){
            return true;
        }

        else{
            session_destroy();
            header("Location: parkingLogin.php");
            return false;
        }
    }
    static function verifyAdmin(){
        if(session_id() == "" && !isset($_SESSION)){
            session_start();
        }
        if($_SESSION["isAdmin"] == true){
            return true;
        }
        else{
            session_destroy();
            header("Location: parkingLogin.php");
            return false;
        }
    }
    
}

?>