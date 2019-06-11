<?php
$connect = mysqli_connect("localhost", "root", "", "test"); 
$id=$_GET["id"];
mysqli_query($connect,"delete from tbl_images where id=$id");
mysqli_close($connect);
?>


<script type="text/javascript">
window.location ="Gallery.php";
</script>
