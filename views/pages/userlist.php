<?php
include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

if (!isset($_SESSION)){
    session_start();
}
if (empty($_SESSION['login_id'])){
    header("location:login.php");
}
use Rabbi\Query\Query;
$query = new Query();
$users = $query->userlist($_SESSION['user_id']);


?>
<table class="table">
    <tr>
        <th>FullName</th>
        <th>Status</th>
        <th>Chat</th>
    </tr>
    <tbody>
    <?php foreach ($users as $user):
        $status = "";
        $current_timestamp = strtotime(date('y-m-d h:i:s').'-10 second') ;

        $last_activity = $query->user_activity($user['id']);
        $last_activity = strtotime($last_activity['last_activity']);

        if($last_activity > $current_timestamp){
            $status = "<span class='btn btn-success'>Online</span>";
        }
        else{
            $status = "<span class='btn btn-danger'>Offline</span>";
        }

        $count = $query->count_unseen_message($_SESSION['user_id'],$user['id']);
        $unseen_message = "";
        if($count >0){
            $unseen_message = "<span class='badge badge-success'>$count</span>";
        }
        ?>
    <tr>
        <td><?php echo $user['fullname']." ".$unseen_message?></td>
        <td><?php echo $status ?></td>
        <td><button class="btn btn-info start_chat" data-touserid = "<?= $user['id']?>" data-tousername = "<?= $user['username']?>">Chat Start</button></td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>