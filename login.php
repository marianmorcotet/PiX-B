<?php
    function getUserId($email){
        $conn = mysqli_connect("localhost", "root", "", "pixData");

        $stms = $conn->prepare();

        mysqli_close($conn);
    }


    if($_SERVER["REQUIRED_METHOD"] == "POST"){

        if(isset($_POST["email"]) && isset($_POST["password"])){

        }
    }





?>