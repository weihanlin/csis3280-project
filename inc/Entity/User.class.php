<?php

class User {

   private $UserID;
   private $FullName;
   private $Email;
   private $Password;
   private $PhoneNumber;
   private $Manager;

    function setID($id){
        $this->UserID = $id;
    }
    function setFullName($fullname){
        $this->FullName = $fullname;
    }
    function setEmail($email){
        $this->Email = $email;
    }
    function setPassword($Password){
        $this->Password = $Password;
    }
    function setPhoneNumber($number){
        $this->PhoneNumber = $number;
    }
    function setManager($manager){
        $this->Manager = $manager;
    }


    function getID(){
        return $this->UserID;
    }
    function getFullName(){
        return $this->FullName;
    }
    function getEmail(){
        return $this->Email;
    }
    function getPassword(){
        return $this->Password;
    }
    function getPhoneNumber(){
        return $this->PhoneNumber;
    }
    function getManager(){
       if($Manager == 1|| $Manager == true){
          return true;
       }
       else{
          return false;
       }
    }


    function verifyPassword(string $passwordToVerify){

        if(password_verify($passwordToVerify, $this->Password)){
            return true;
        }
        else{
            return false;
        }
    }
}



?>
