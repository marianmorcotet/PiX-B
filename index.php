<?php
include("login.html");
include("sharedFunctions.php");
session_start();
if(isset($_SESSION['userName'])){
    header("Location: Gallery.php");
}
 ?>
