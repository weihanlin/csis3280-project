<?php

class Validate {


    static function validateLocation(Location $target){

        $target->setLocationID(filter_var($target->getLocationID(),FILTER_SANITIZE_NUMBER_INT));
        if(!filter_var($target->getLocationID(),FILTER_VALIDATE_INT)) {
            error_log("LocationID invalid:".$target->getLocationID()." ".__FILE__.":".__LINE__);
            return false;
        }

        $target->setShortName(filter_var($target->getShortName(), FILTER_SANITIZE_STRING));
        if($target->getShortName() == false || strlen($target->getShortName()) > 5
                || preg_match_all('/(?![a-zA-Z\d])./', $target->getShortName())) {
            error_log("ShortName invalid:".$target->getShortName()." ".__FILE__.":".__LINE__);
            return false;
        }

        $addr = filter_var($target->getAddress(), FILTER_SANITIZE_STRING);
        if($addr) {
            preg_replace('/(?![a-zA-Z\d\s\-])./','', $addr);
            $target->setAddress(strtolower($addr));
        }
        else {
            error_log("Address invalid:".$target->getShortName()." ".__FILE__.":".__LINE__);
            return false;
        }

        return true;

    }


    static function validateSpace(Space $target){

        $target->setLocationID(filter_var($target->getLocationID(),FILTER_SANITIZE_NUMBER_INT));
        if(!filter_var($target->getLocationID(),FILTER_VALIDATE_INT)) {
            error_log("LocationID invalid:".$target->getLocationID()." ".__FILE__.":".__LINE__);
            return false;
        }

        $target->setSpaceID(filter_var($target->getSpaceID(),FILTER_SANITIZE_NUMBER_INT));
        if(!filter_var($target->getSpaceID(),FILTER_VALIDATE_INT)) {
            error_log("SpaceID invalid:".$target->getSpaceID()." ".__FILE__.":".__LINE__);
            return false;
        }

        $target->setPrice(filter_var($target->getPrice(),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        if(!filter_var($target->getPrice(),FILTER_VALIDATE_FLOAT)){
            error_log("Unit Price invalid:".$target->getPrice()." ".__FILE__.":".__LINE__);
            return false;
        }


        return true;

    }


    static function validateSpaceForm() {
        $error = array();

        if($_POST['action'] == 'create') {
            if (filter_input(INPUT_POST, 'spaceid', FILTER_VALIDATE_INT)) {
                $sp = SpaceDAO::getSpace($_POST['spaceid'], $_POST['locationid']);
                if (is_object($sp))
                    $error[] = "Failed: Space ID is duplicated";
            } else
                $error[] = "Failed: Invalid Space ID";
        }

        if(!filter_input(INPUT_POST,'price',FILTER_VALIDATE_FLOAT)) {
            $error[] = "Failed: Invalid Unit Price";
        }

        return $error;
    }


    static function validateLocationForm() {
        $error = array();

        $_POST['shortname'] = filter_input(INPUT_POST, 'shortname', FILTER_SANITIZE_STRING);
        if( $_POST['shortname'] == false || strlen($_POST['shortname']) > 5|| preg_match_all('/(?![a-zA-Z\d])./',$_POST['shortname']) )
            $error[] = "Failed: Invalid Short Name";
        else
            $_POST['shortname'] = strtoupper($_POST['shortname']);

        if($_POST['addr'] = filter_input(INPUT_POST,'addr',FILTER_SANITIZE_STRING)) {
            preg_replace('/(?![a-zA-Z\d\s\-])./','',$_POST['addr']);
            $_POST['addr'] = strtolower($_POST['addr']);
        } else
            $error[] = "Failed: Invalid address";

        return $error;
    }



}