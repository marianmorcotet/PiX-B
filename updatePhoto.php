<?php  
include("sharedFunctions.php");
session_start();
$conn = mysqli_connect("localhost", "root", "", "pixData");
$imageId = $_GET['id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["newTitle"]) && ($_POST["newTitle"] != NULL)){
        $conn = mysqli_connect("localhost", "root", "", "pixData");
        $newTitle = $_POST["newTitle"];
        $newTitle = clearInput($newTitle);
        $newTitle = mysqli_real_escape_string($conn, $newTitle);
        
        $stmt = $conn->prepare("UPDATE Pictures SET title=? WHERE id_picture=?");
        $stmt->bind_param("si", $newTitle, $imageId);
        $stmt->execute();
        
        $stmt->close();
        mysqli_close($conn);
    }

    if(isset($_POST["newDescription"]) && ($_POST["newDescription"] != NULL)){
        $conn = mysqli_connect("localhost", "root", "", "pixData");
        $newDescription = $_POST["newDescription"];
        $newDescription = clearInput($newDescription);
        $newDescription = mysqli_real_escape_string($conn, $newDescription);
        
        $stmt = $conn->prepare("UPDATE Pictures SET description=? WHERE id_picture=?");
        $stmt->bind_param("si", $newDescription, $imageId);
        $stmt->execute();
        
        $stmt->close();
        mysqli_close($conn);
    }

    if(isset($_POST["newTags"]) && ($_POST["newTags"] != NULL)){
        $newTags = $_POST["newTags"];
        $conn = mysqli_connect("localhost", "root", "", "pixData");
        $newTags = clearInput($newTags);
        $newTags = mysqli_real_escape_string($conn, $newTags);

        $newTags = explode(",", $newTags);

        foreach($newTags as $newTag){
            $stmt = $conn->prepare("INSERT INTO Tags(tag_name) VALUES(?)");
            $stmt->bind_param("s", $newTag);
            $stmt->execute();

            $stmt->close();

            $stmt = $conn->prepare("SELECT max(id_tag) FROM TAGS");
            $stmt->execute();
            $stmt->bind_result($tagId);
            $stmt->fetch();
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO TagRelations(id_tag, id_picture) VALUES(?, ?)");
            $stmt->bind_param("ii", $tagId, $imageId);
            $stmt->execute();

            $stmt->close();

        }
    }

    if(isset($_POST['newImage']) && ($_POST['newImage'] != NULL)){
        $pos = strpos($_POST['newImage'], 'base64,');
        if($pos != 0){
            $blobData= base64_decode(substr($_POST['newImage'], $pos + 7));

            $stmt = $conn->prepare("UPDATE Pictures SET picture = ? WHERE id_picture = ?");
            $stmt->bind_param("si", $blobData, $imageId);
            $stmt->execute();

            $stmt->close();
        }
    }

    mysqli_close($conn);
}

header("Location: Gallery.php");
?>