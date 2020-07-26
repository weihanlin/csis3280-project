<?php

class Validate {


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