<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

if (!isset($_SESSION)) {
    session_start();
}
$data = [
    'to_user_id' => $_POST['to_user_id'],
    'from_user_id' => $_SESSION['user_id'],
    'message' => $_POST['chat_message'],
    'status' => '1'
];

use Rabbi\Query\Query;

$query = new Query();

$inserted = $query->insert_chat($data);

if($inserted){
    include_once "control/fetch_user_chat_history.php";
}

