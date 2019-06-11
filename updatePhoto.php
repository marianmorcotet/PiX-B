<?php  
//Afisare Imaginii
$query = "SELECT * FROM Pictures ORDER BY id_picture DESC";  
$result = mysqli_query($connect, $query);  
while($row = mysqli_fetch_array($result))  
{  
    echo '  
            <div class="image">
                <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                <h3>About this photo:</h3>
                <p>Descriere imagine</p>
                <label class="image-menu">';
                ?>
                <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a> <?php
                    echo ' <button>Edit</button>
                    <button>Save</button>
                </label>
            </div>
    ';
}
?>