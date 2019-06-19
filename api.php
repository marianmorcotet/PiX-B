<?php
session_start();
function response($val){
	$response[$_GET['x']] = $val;
	
	$json_response = json_encode($response);
	echo $json_response;
}

include("sharedFunctions.php");

if(isset($_SESSION['userId'])){
	header("Content-Type:application/json");
	response($_SESSION[$_GET['x']]);
	}else{
		print_r("ses nula");
	}
?>