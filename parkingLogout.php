<?php

require_once("inc/config.inc.php");
require_once("inc/Entity/Page.class.php");


session_start();
unset($_SESSION);
session_destroy();


Page::header();
echo "<p>Thank you for using our Service</p>";
echo "<a href=\"parkingLogin.php\">Click here to return to login</a>";
Page::footer();

?>
