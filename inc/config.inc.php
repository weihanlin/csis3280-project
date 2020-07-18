<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "ParkingProject");

// definition for log file
define('LOGFILE','log/error_log.txt');
ini_set("log_errors", TRUE);
ini_set('error_log', LOGFILE);