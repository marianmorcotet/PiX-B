<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" media="screen" href="styles/edit.css">
    <link rel="stylesheet" type="text/css" media="screen" href="styles/loginStyles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
</head>
<body>
    
    <div id="mainImage">
        <header>
                <!-- <h1 id="imageTitle">image title</h1> -->
        </header>

        <canvas id="editedCanvas" height="500" width="700">
            <?php
            session_start();
            $pictureId = $_GET['id'];
            $connect = mysqli_connect("localhost", "root", "", "pixData");

            $query = "SELECT * FROM pictures WHERE id_picture=$pictureId";  
            $result = mysqli_query($connect, $query);  
            while($row = mysqli_fetch_array($result))  
            {  
                echo '<img id="editedImage" src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">';
            }
            
            mysqli_close($connect);
            // $conn = mysqli_connect("localhost", "root", "", "pixData");

            // $stmt = $conn->prepare("SELECT picture from Pictures WHERE id_picture = ?");
            // $stmt->bind_param("i", $pictureId);
            // $stmt->execute();

            // $stmt->bind_result($picture);
            // $stmt->fetch();

            // $stmt->close();
            // mysqli_close($conn);
            // echo '<img id="editedImage" src="data:image/jpeg;base64,'.base64_encode($picture).'" alt="">';
            ?>
        </canvas>

        <div id="bottomMenu">
                <form method="post" name="updateDatabase" action="updatePhoto.php?id=<?php echo $_GET['id']?>">
                    <input type="text" name="newTitle" placeholder="write new title">
                    <input type="text" name="newDescription" placeholder="write new description">
                    <input type="text" name="newTags" placeholder="tag1,tag2,tag3..">
                    <button type="submit">Save changes</button>
                </form>
            </div>
    </div>

    <div id="rightMenu">
        <!-- <input type="text" placeholder="write new title">
        <input type="text" name="" placeholder="write new description">
        <hr> -->
        <label for="">Blur</label>
        <input type="range" min="0" max="100" value="0" step="1" onchange="applyFilter()" data-filter="blur" data-scale="px"><br>
        <label for="">Brightness</label>
        <input type="range" min="0" max="200" value="100" step="1" onchange="applyFilter()" data-filter="brightness" data-scale="%"><br>
        <label for="">Contrast</label>
        <input type="range" min="0" max="200" value="100" step="1" onchange="applyFilter()" data-filter="contrast" data-scale="%"><br>
        <label for="">Grayscale</label>
        <input type="range" min="0" max="100" value="0" step="1" onchange="applyFilter()" data-filter="grayscale" data-scale="%"><br>
        <label for="">Hue Rotate</label>
        <input type="range" min="0" max="360" value="0" step="1" onchange="applyFilter()" data-filter="hue-rotate" data-scale="deg"><br>
        <label for="">Invert</label>
        <input type="range" min="0" max="100" value="0" step="1" onchange="applyFilter()" data-filter="invert" data-scale="%"><br>
        <label for="">Opacity</label>
        <input type="range" min="0" max="100" value="100" step="1" onchange="applyFilter()" data-filter="opacity" data-scale="%"><br>
        <label for="">Saturate</label>
        <input type="range" min="1" max="100" value="1" step="1" onchange="applyFilter()" data-filter="saturate" data-scale=""><br>
        <label for="">Sepia</label>
        <input type="range" min="0" max="100" value="0" step="1" onchange="applyFilter()" data-filter="sepia" data-scale="%"><br>

    </div>

    
    <script src="scripts/edit.js"></script>
    <!-- <script src="scripts"></script> -->
</body>