<?php
include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";
if (!isset($_SESSION)){
    session_start();
}
if (empty($_SESSION['user_id'])){
    header("location:login.php");
}
ob_start();

?>
<div class="container">
    <br>
    <h2 class="text-center" style="color: red">Online simple chatbox </h2>
    <hr>
    <p class="text-right"><?= $_SESSION['user_fullname']?>-<a href="logout.php">Logout</a></p>

    <div id="userlist"></div>
    <div id="user_modal_details"></div>



</div>
<?php
$output = ob_get_contents();
ob_end_clean();
$template = file_get_contents($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."layout".DIRECTORY_SEPARATOR."layout.php");
echo str_replace('|||rabbi|||',$output,$template);



