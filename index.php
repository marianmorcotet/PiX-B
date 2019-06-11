<?php
include("login.html");
include("sharedFunctions.php");

if (checkSession() != 0){
    startPersistentSession();
}else{
    Header("Location: http://localhost/pixB/PiX-B/");
}
 ?>
