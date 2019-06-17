<?php
$connect = mysqli_connect("localhost", "root", "", "pixData"); 
$id=$_GET["id"];
<<<<<<< HEAD
$result=mysqli_query($connect,"select id_tag from tagrelations where id_picture=$id LIMIT 1");
while($row = mysqli_fetch_array($result)){
    $idTag=$row["id_tag"];
    mysqli_query($connect,"delete from tagrelations where id_picture=$id and id_tag=$idTag");
    mysqli_query($connect,"delete from tags where id_tag=$idTag");
    $result=mysqli_query($connect,"select id_tag from tagrelations where id_picture=$id LIMIT 1");
}
=======
>>>>>>> master
mysqli_query($connect,"delete from Pictures where id_picture=$id");
mysqli_close($connect);
?>


<script type="text/javascript">
window.location ="Gallery.php";
</script>
