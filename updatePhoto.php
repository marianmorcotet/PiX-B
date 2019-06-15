<?php  
include("sharedFunctions.php");
session_start();
$imageId = $_GET['id'];
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["newTitle"])){
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

    if(isset($_POST["newDescription"])){
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

    if(isset($_POST["newTags"])){
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

        mysqli_close($conn);

    }

}

header("Location: Gallery.php");
?>