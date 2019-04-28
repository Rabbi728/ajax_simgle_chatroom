<?php
include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

ob_start();
?>
<div class="container">
    <br>
    <h2 class="text-center" style="color: red">Please Login Before Chat Start</h2>
    <hr>
    <form action="control/chack.php" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="username">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php
$output = ob_get_contents();
ob_end_clean();
$template = file_get_contents($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."layout".DIRECTORY_SEPARATOR."layout.php");

echo str_replace('|||rabbi|||',$output,$template);
