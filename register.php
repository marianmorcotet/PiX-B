<?php

    function clearInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function registerUser($email, $password){
        //conectare la baza de date
        $conn = new mysqli("localhost", "root", "", "pixData");
        //pentru siguranta folosesc query-uri pregatite
        $stmt = $conn->prepare("INSERT INTO USERS(email, password) VALUES (?, ?)");
        $stmt->bind_param("sss", $email, $password);
        $stmt->execute();
        //inchidem query-ul
        $stmt->close();
        //inchidem conexiunea la sfarsit
        mysqli_close($conn)
    }

    $username = $email = $password = "";
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
            $username = clearInput($_POST["username"]);
            $email = clearInput($_POST["email"]);
            $password = clearInput($_POST["password"]);
        }
        
    }


?>