<?php
require_once("inc/Entity/User.class.php");
require_once("inc/Utility/PDOService.class.php");
class UserDAO   {


private static $db;

static function initialize(){
    self::$db = new PDOService("User");
} 
    

    static function createUser(User $user){

        $insert = "INSERT INTO User (FullName, Email, Password, PhoneNumber, Manager)
                    VALUES(:FullName, :Email, :Password, :PhoneNumber, :Manager)";
        
        self::$db->query($insert);
        self::$db->bind(':FullName', $user->getFullName());
        self::$db->bind(':Email',$user->getEmail());
        self::$db->bind(':Password', password_hash($user->getPassword(), PASSWORD_DEFAULT));
        self::$db->bind(':PhoneNumber', $user->getPhoneNumber());
        self::$db->bind(':Manager', false);

        self::$db->execute();
return self::$db->rowCount();
    }


    static function getUser(string $email)  {

        $select = "SELECT * FROM User WHERE email = :email;";
        self::$db->query($select);
        self::$db->bind(':email', $email);
        self::$db->execute();
        return self::$db->singleResult();
    }


    static function getAllUsers()  {
        
        $select = "SELECT * FROM User ORDER BY UserID";
        self::$db->query($select);
        self::$db->execute();
        return self::$db->resultSet();
    }
    
    static function setAdmin(string $email, bool $manager){
        $select = "UPDATE User SET Manager = :manager WHERE email = :email;";
        self::$db->query($select);
        self::$db->bind(':manager', $manager);
        self::$db->bind(':email', $email);
        self::$db->execute();
        return;
    }
    static function updateUser(User $u){
        $update = "UPDATE User SET FullName = :fullname, PhoneNumber = :phonenumber WHERE Email = :email;";
        self::$db->query($update);
        self::$db->bind(':fullname', $u->getFullName());
        self::$db->bind(':phonenumber', $u->getPhoneNumber());
        self::$db->bind(':email', $_SESSION['email']);
        self::$db->execute();
        return true;
    }
    static function updatePassword($password){
        $update = "UPDATE user SET Password = :password WHERE Email = :email;";
        self::$db->query($update);
        self::$db->bind(':password', password_hash($password, PASSWORD_DEFAULT));
        self::$db->bind(':email', $_SESSION['email']);
        self::$db->execute();
    }
}
