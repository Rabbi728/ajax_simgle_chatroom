<?php
include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
if (!isset($_SESSION)){
    session_start();
}
use Rabbi\Query\Query;

$query = new Query();

$users = $query->login_check($_POST);

    if (isset($users['username'])){
        $_SESSION['user_id'] = $users['id'];
        $_SESSION['user_fullname'] = $users['fullname'];
        $_SESSION['login_id'] = $query->activity_create($_SESSION['user_id'],date('y-m-d h:i:s'));
        header("location:../index.php");
    }else{
        header("location:../login.php");
    }