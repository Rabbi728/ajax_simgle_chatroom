<?php
include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
if (!isset($_SESSION)){
    session_start();
}

use Rabbi\Query\Query;
$query = new Query();
$query->update_last_activity($_SESSION['login_id'],date('y-m-d h:i:s'));