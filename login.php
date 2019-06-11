<?php
    include("sharedFunctions.php");

    if(checkSession() != 0){
        startPersistentSession();
    }

    function getUserPassword($userId){
        $conn = mysqli_connect("localhost", "root", "", "pixData");

        $userId = mysqli_real_escape_string($conn, $userId);
        
        $stmt = $conn->prepare("SELECT password FROM Users WHERE id_user = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $stmt->bind_result($resultPassword);
        $stmt->fetch();
        
        $stmt->close();
        mysqli_close($conn);

        return $resultPassword;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST["email"]) && isset($_POST["password"])){
            $userId = getUserId($_POST["email"]);
            $password = clearInput($_POST["password"]);
            // $password = clearInput($password);
            // $password = mysqli_real_escape_string($password);

            if(password_verify($password, getUserPassword($userId))){
                startPersistentSession();
                header("Location: http://localhost/pixB/PiX-B/Gallery.php");
            }
        }
    }
?>