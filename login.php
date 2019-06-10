<?php
    include("sharedFunctions.php");

    function getUserId($email){
        $conn = mysqli_connect("localhost", "root", "", "pixData");

        $email = clearInput($email);
        $email = mysqli_real_escape_string($conn, $email);

        $stmt = $conn->prepare("SELECT id_user FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        $stmt->bind_result($userId);
        $stmt->fetch();

        $stmt->close();
        mysqli_close($conn);

        return $userId;
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

    function savePersistentSession($sessionName, $userId, $dateTime){
        $conn = mysqli_connect("localhost", "root", "", "pixData");
        //sa verificam
        $stmt = $conn->prepare("INSERT INTO PersistentSession(token, id_user, expires) VALUES(?, ?, ?)");
        // $dateTime = date('Y-m-d G:i:s');
        $stmt->bind_param("sid", $sessionName, $userId, $dateTime);
        $stmt->execute();

        $stmt->close();
        mysqli_close($conn);
    }

    function startPersistentSession(){
        $lifetime = 60 * 60 * 2;
        session_start();
        $dateTime = date('Y-m-d G:i:s') + $lifetime;
        echo $dateTime;
        setcookie(session_name(), session_id(), $dateTime);
        savePersistentSession(session_name(), getUserId($_POST["email"]), $dateTime);
        echo "am inceput";
        header("Location: http://localhost/pixB/PiX-B/home.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST["email"]) && isset($_POST["password"])){
            $userId = getUserId($_POST["email"]);
            $password = clearInput($_POST["password"]);
            // $password = clearInput($password);
            // $password = mysqli_real_escape_string($password);

            if(password_verify($password, getUserPassword($userId))){
                startPersistentSession();
            }
        }
    }





?>