<?php
    function clearInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function checkSession(){
        $userId = 0;
        $userId = checkExistingSession();
        if($userId == 0){
            //daca nu exista deja sesiunea, se creeaza
            startPersistentSession();
            $_SESSION['userId'] = $userId;
            // header("Location: http://localhost/pixB/PiX-B/home.php");
        }
    }

    function checkExistingSession(){
        $conn = mysqli_connect("localhost", "root", "", "pixData");

        $stmt = $conn->prepare("SELECT id_user FROM PersistentSession WHERE token = ?");
        $stmt->bind_param("s", session_id());
        $stmt->execute();

        $stmt->bind_result($userId);
        $stmt->fetch();

        $stmt->close();
        mysqli_close($conn);
        
        return $userId;
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
        setcookie(session_name(), session_id(), $dateTime);
        savePersistentSession(session_id(), getUserId($_POST["email"]), $dateTime);
        echo "am inceput";
        header("Location: http://localhost/pixB/PiX-B/home.php");
    }

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
?>