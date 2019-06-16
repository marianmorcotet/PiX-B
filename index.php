<?php
session_start();
if(isset($_SESSION['userId'])){
    header("Location: Gallery.php");
}

include("login.html");
include("sharedFunctions.php");
 ?>
