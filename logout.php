<?php
include("sharedFunctions.php");
session_start();
deletePersistentSession(session_id());
session_destroy();
header('Location: index.php');
exit;
?>