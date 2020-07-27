<?php

class Validate{
static function validator(){
    $isCorrect = true;
    $header = 0;

        if(!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)){
            $isCorrect = false;
            if($header == 0){
                Page::header();
                $header = 1;
            }
            echo nl2br("Email is invalid");

        }

        if(strlen($_POST['password']) < 8){
            $isCorrect = false;
            if($header == 0){
                Page::header();
                $header = 1;
            }
            echo nl2br("Password must be longer than 8 characters\n");
        }

        if($_POST['password']!=$_POST['password_confirm']){
            $isCorrect = false;
            if($header == 0){
                Page::header();
                $header = 1;
            }
            echo nl2br("Passwords do not match\n");
        };
    


    if (!preg_match("/^[a-zA-Z ]*$/",$_POST['fullname'])) {
        $isCorrect = false;
        if($header == 0){
            Page::header();
            $header = 1;
        }
        echo nl2br("Only letters and white space allowed in Full Name\n");
      }

return $isCorrect;
}
}

?>