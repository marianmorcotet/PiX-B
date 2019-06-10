<?php
include("sharedFunctions.php");

//verifica daca sesiunea este aceeasi
header("Content-Type:application/json");
if($_SERVER["REQUEST_METHOD"] == "GET") {
	response($_SESSION['userId']);
	}else{
		response(NULL, NULL, 200,"No Record Found");
		}
}else{
	response(NULL, NULL, 400,"Invalid Request");
	}

function response($val){
	$response['userId'] = $val;
	
	$json_response = json_encode($response);
	echo $json_response;
}
?>