<?php
    function clearInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function checkSession(){
        session_start();
        
        $userId = checkExistingSession();
        $username = getUserName($userId);
        $_SESSION['userId'] = $userId;
        $_SESSION['userName'] = $username;
        if(!$userId){
            // Header("Location: http://localhost/pixB/PiX-B/");
        }
        return $userId;
    }

    function checkExistingSession(){
        $conn = mysqli_connect("localhost", "root", "", "pixData");

        $stmt = $conn->prepare("SELECT id_user FROM PersistentSession WHERE token = ?");
        $sesId = session_id();
        $stmt->bind_param("s", $sesId);
        $stmt->execute();

        $stmt->bind_result($userId);
        $stmt->fetch();

        $stmt->close();
        mysqli_close($conn);

        return $userId;
    }

    function savePersistentSession($sessToken, $userId, $dateTime){
        $conn = mysqli_connect("localhost", "root", "", "pixData");
        
        $stmt = $conn->prepare("INSERT INTO PersistentSession(token, id_user, expires) VALUES(?, ?, ?)");
        $stmt->bind_param("sid", $sessToken, $userId, $dateTime);
        $stmt->execute();

        $stmt->close();
        mysqli_close($conn);
    }

    function deletePersistentSession($sessToken){
        $conn = mysqli_connect("localhost", "root", "", "pixData");

        $stmt = $conn->prepare("DELETE FROM PersistentSession WHERE token = ?");
        $stmt->bind_param("s", $sessToken);
        $stmt->execute();

        $stmt->close();
        mysqli_close($conn);
    }

    function startPersistentSession(){
        $lifetime = 60 * 60 * 2;

        $dateTime = time() + $lifetime;
        
        setcookie(session_name(), session_id(), $dateTime);

        $_SESSION['userId'] = getUserId($_SESSION['email']);

        savePersistentSession(session_id(), $_SESSION["userId"], $dateTime);

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

    function getUserName($userId){
        $conn = mysqli_connect("localhost", "root", "", "pixData");

        $userId = clearInput($userId);
        $userId = mysqli_real_escape_string($conn, $userId);

        $stmt = $conn->prepare("SELECT username FROM Users WHERE id_user = ?");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        
        $stmt->bind_result($username);
        $stmt->fetch();

        $stmt->close();
        mysqli_close($conn);

        return $username;
    }
?>