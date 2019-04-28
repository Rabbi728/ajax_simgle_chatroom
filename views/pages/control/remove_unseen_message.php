<?php

include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

if (!isset($_SESSION)) {
    session_start();
}

use Rabbi\Query\Query;

$query = new Query();

$chats = $query->remove_unseen_message($_SESSION['user_id'], $_POST['to_user_id']);