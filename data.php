<?php
require_once ("inc/config.inc.php");
require_once ("inc/Utility/PDOService.class.php");

if(isset($_GET['q']) && $_GET['q'] == 'sum') {
    $db = new PDOService("");
    $q = "SELECT ShortName, count(1) as Count FROM Space as s JOIN Location as l ON s.LocationID = l.LocationID GROUP BY ShortName";
    $db->query($q);
    $db->execute();
    $rst = $db->getJSON();
    echo $rst;
}

if(isset($_GET['q']) && $_GET['q'] == 'avg') {
    $db = new PDOService("");
    $q = "SELECT ShortName, avg(Price) as Avg FROM Space as s JOIN Location as l ON s.LocationID = l.LocationID GROUP BY ShortName";
    $db->query($q);
    $db->execute();
    $rst = $db->getJSON();
    echo $rst;
}
