<?php
$con= mysqli_connect("localhost", "root", "", "pixData"); 
$id=$_GET["id"];
$sql = "select * from Pictures where id_picture=$id";
$res = $con->query($sql);
while($row = $res->fetch_assoc())
{ 
    $name = $row['title'];
    $size =  $row['size'];
    $type = $row['type'];
    $image = $row['picture'];
}

header("Content-type: ".$type);
header('Content-Disposition: attachment; filename="'.$name.'"');
header("Content-Transfer-Encoding: binary"); 
header('Expires: 0');
header('Pragma: no-cache');
header("Content-Length: ".$size);

echo $image;
exit();
?>