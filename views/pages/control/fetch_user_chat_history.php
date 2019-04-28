<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

if (!isset($_SESSION)) {
    session_start();
}

use Rabbi\Query\Query;

$query = new Query();

    $chats = $query->fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id']);
    ?>
    <ul class="list-unstyled">
        <?php foreach ($chats as $chat):
            $username = "";
            if ($chat['from_user_id'] == $_SESSION['user_id']) {
                $username = '<b class="text-success">You</b>';
            } else {
                $username = '<b class="text-success">' . $query->get_user_name($chat['from_user_id']) . '</b>';
            }
            ?>
            <li style="border-bottom: 1px dotted #ccc">
                <p align="<?php
                if ($username == "<b class=\"text-success\">You</b>") {
                    echo "right";
                } else {
                    echo "left";
                }
                ?>"><b><?php echo $username ?></b>-<?php echo $chat['message'] ?>
                <div align="<?php
                if ($username == "<b class=\"text-success\">You</b>") {
                    echo "left";
                } else {
                    echo "right";
                }
                ?>">
                    <small><em><?= $chat['created_at'] ?></em></small>
                </div>
                </p>
            </li>
        <?php endforeach; ?>
    </ul>