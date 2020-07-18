<?php

class PDOService {

    //Pull in the attributes from the config
    private $_host = DB_HOST;
    private $_user = DB_USER;
    private $_pass = DB_PASS;
    private $_dbname = DB_NAME;

    //Store the PDO Object
    private $_dbh;
    private $_error;

    //Store the class we will be working with;
    private $_className;

    //Store the Query Statement;
    private $_pstmt;

    //Construct our wrapper, build the DSN
    public function __construct(string $className)
    {
        $this->_className = $className;

        //Assemble the DSN (Data Source Name)
        $dsn = "mysql:host={$this->_host};dbname={$this->_dbname};port=3308";

        //Set the options for PDO
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        //Try to get a PDO class
        try {
            $this->_dbh = new PDO($dsn, $this->_user, $this->_pass, $options);
        } catch (PDOException $e) {
            $this->_error = $e->getMessage();
        }
    }

    //This function prepares a query that has be passed
    public function query(string $q) {
        $this->_pstmt = $this->_dbh->prepare($q);
    }

    //This function binds parameters
    public function bind($p, $v, $t=null) {
        if(is_null($t)){
            if(is_int($v))
                $t = PDO::PARAM_INT;
            elseif (is_bool($v))
                $t = PDO::PARAM_BOOL;
            elseif (is_null($v))
                $t = PDO::PARAM_NULL;
            else
                $t = PDO::PARAM_STR;
        }

        $this->_pstmt->bindValue($p, $v, $t);
    }

    //This function will excute the statement when its ready.
    public function execute() {
        return $this->_pstmt->execute();
    }

    //This function will return the result of the executed query
    public function resultSet() {
        return $this->_pstmt->fetchAll(PDO::FETCH_CLASS, $this->_className);
    }

    //This function will return a single result of the executed Query
    public function singleResult() {
        $this->_pstmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
        return $this->_pstmt->fetch(PDO::FETCH_CLASS);
    }

    //This function returns the rowCount
    public function rowCount() {
        return $this->_pstmt->rowCount();
    }

    //This function will return the last inserted Id
    public function lastInsertedId() {
        return $this->_pstmt->lastInsertId();
    }
}