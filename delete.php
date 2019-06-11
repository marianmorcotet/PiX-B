<?php
$connect = mysqli_connect("localhost", "root", "", "pixData"); 
$id=$_GET["id"];
mysqli_query($connect,"delete from Pictures where id_picture=$id");
mysqli_close($connect);
?>


<script type="text/javascript">
window.location ="Gallery.php";
</script>
