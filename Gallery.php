<?php  
//Upload database
include("sharedFunctions.php");
session_start();
if(!isset($_SESSION['userId'])){
    header("Location: index.php");
}

 $connect = mysqli_connect("localhost", "root", "", "pixData"); 
 if(isset($_POST["insert"]))  
 {  
     
     $file_array=reArrayFiles($_FILES['image']);
     $file_count=count($file_array);
     $describe=$_POST['Describe'];
     //print_r($describe);
     //print_r($file_array);
     //print_r($file_count);

     if($file_array['0']['size']== 0)
     {
          echo "Please select an image.";
     }
     else
     {
     
          for($i=0;$i<$file_count;$i++){
               $file = addslashes(file_get_contents($file_array[$i]['tmp_name']));  
               $title= addslashes($file_array[$i]['name']);
               $type=$file_array[$i]['type'];
               //$ext = pathinfo($title, PATHINFO_EXTENSION);
               $size= $file_array[$i]['size'];
               $id_user=$_SESSION['userId'];
               $date=date("Y-m-d");
               $query = "INSERT INTO pictures(id_user_owner,picture,title,type,size,description,date) VALUES ('$id_user','$file','$title','$type','$size','$describe','$date')";
               if(mysqli_query($connect, $query))  
               {  
                    $ok=1; 
               }
          }
          if($ok!=0){
               echo '<script>alert("Image Inserted into Database")</script>';
          }  
     }
     
 }
 function reArrayFiles($file_post){
     $file_ary=array();
     $file_count= count($file_post['name']);
     $file_keys=array_keys($file_post);

     for($i=0;$i<$file_count;$i++){
         foreach($file_keys as $key){
             $file_ary[$i][$key]=$file_post[$key][$i];
         }
     }
     return $file_ary;
}  
 ?>  
 <!DOCTYPE html>  
 <html>  
     <head>
          <link rel="stylesheet" type="text/css" media="screen" href="styles/Gallery.css">
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta http-equiv="X-UA-Compatible" content="ie=edge">
          <title>Gallery</title>
     </head>
     <body>  
          <header>
		     <h1 id="galleryTitle"></h1>
               <form method="post" enctype="multipart/form-data">
                    <input type="file" name="image[]" id="image" multiple="" />
                    <br />
                    <input id="Describe" type="text" name="Describe" placeholder="Describe" />
                    <br />
                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
               </form>

               <a href=" logout.php">Logout</a>

               <form  method="post">
                    <p>Filter by:</p>
                    <input type="text" name="tag" placeholder="Example: #nameTag" />
                    <br />
                    <select name="Filter">
                         <option value="Default">Nothing</option>
                         <option value="jpg">Jpg picture's</option>
                         <option value="png">Png picture's</option>
                         <option value="gif">Gif picture's</option>
                    </select>
                    <br />
                    <input type="date" name="dateFrom" id="date" value="<?php 
                    if(isset($_POST['select'])) {
                         echo $_POST['date'];
                     }
                ?>">
                    <input type="submit" name="select" value="Apply" />
               </form>

               <!-- <div class="filter">
               <button type="filter-by">Filter by</button>
               <input type="text" placeholder="date/tag">
               </div> -->
          </header>
          <div class="gallery">

               <?php
                    if(isset($_POST['select'])){
                         $selected_val = $_POST['Filter'];  // Storing Selected Value In Variable
                         //echo "You have selected :" .$selected_val;  // Displaying Selected Value
                         $date = date('Y-m-d', strtotime($_POST['dateFrom']));
                         //print_r($date);
                         $tag = $_POST['tag'];


                         if($selected_val=="Default" and $date=="1970-01-01" and $tag==NULL){
                              $id_user=$_SESSION['userId'];
                              $query = "SELECT * FROM pictures WHERE id_user_owner=$id_user ORDER BY id_picture DESC";  
                              $result = mysqli_query($connect, $query);  
                              while($row = mysqli_fetch_array($result))  
                              {    
                                   $idPicture = $row['id_picture'];
                                   $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                                   $resultt = mysqli_query($connect, $queryy);
                                   $tagList = "";
                                   while($roww = mysqli_fetch_array($resultt)){
                                        $tagList = $tagList.$roww['tag_name'].',';
                                   }
                                   echo '  
                                        <div class="image">
                                             <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                             <h3>About this photo:</h3>
                                             <p>'.$row['description'].'</p>
                                             <p>'.$tagList.'</p>
                                             <label class="image-menu">';
                                             ?>
                                             <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                             <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                             <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                                  echo '
                                             </label>
                                        </div>
                                   ';
                              }    
                         }
                         if($selected_val=="Default" and $date!="1970-01-01" and $tag==NULL){
                              $id_user=$_SESSION['userId'];
                              
                              $query = "SELECT * FROM pictures WHERE id_user_owner=$id_user and date='$date' ORDER BY id_picture DESC";  
                              $result = mysqli_query($connect, $query);  
                              while($row = mysqli_fetch_array($result))  
                              {    
                                   $idPicture = $row['id_picture'];
                                   $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                                   $resultt = mysqli_query($connect, $queryy);
                                   $tagList = "";
                                   while($roww = mysqli_fetch_array($resultt)){
                                        $tagList = $tagList.$roww['tag_name'].',';
                                   }
                                   echo '  
                                        <div class="image">
                                             <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                             <h3>About this photo:</h3>
                                             <p>'.$row['description'].'</p>
                                             <p>'.$tagList.'</p>
                                             <label class="image-menu">';
                                             ?>
                                             <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                             <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                             <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                                  echo '
                                             </label>
                                        </div>
                                   ';
                              }    
                         }
                         if($selected_val!="Default" and $date=="1970-01-01" and $tag==NULL){
                              $id_user=$_SESSION['userId'];
                              
                              $query = "SELECT * FROM pictures WHERE id_user_owner=$id_user and lower(title) like '%$selected_val%' ORDER BY id_picture DESC";  
                              $result = mysqli_query($connect, $query);  
                              while($row = mysqli_fetch_array($result))  
                              {    
                                   $idPicture = $row['id_picture'];
                                   $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                                   $resultt = mysqli_query($connect, $queryy);
                                   $tagList = "";
                                   while($roww = mysqli_fetch_array($resultt)){
                                        $tagList = $tagList.$roww['tag_name'].',';
                                   }
                                   echo '  
                                        <div class="image">
                                             <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                             <h3>About this photo:</h3>
                                             <p>'.$row['description'].'</p>
                                             <p>'.$tagList.'</p>
                                             <label class="image-menu">';
                                             ?>
                                             <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                             <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                             <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                                  echo '
                                             </label>
                                        </div>
                                   ';
                              }    
                         }
                         if($selected_val!="Default" and $date!="1970-01-01" and $tag==NULL){
                              $id_user=$_SESSION['userId'];
                              
                              $query = "SELECT * FROM pictures WHERE id_user_owner=$id_user and date='$date' and lower(title) like '%$selected_val%' ORDER BY id_picture DESC";  
                              $result = mysqli_query($connect, $query);  
                              while($row = mysqli_fetch_array($result))  
                              {    
                                   $idPicture = $row['id_picture'];
                                   $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                                   $resultt = mysqli_query($connect, $queryy);
                                   $tagList = "";
                                   while($roww = mysqli_fetch_array($resultt)){
                                        $tagList = $tagList.$roww['tag_name'].',';
                                   }
                                   echo '  
                                        <div class="image">
                                             <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                             <h3>About this photo:</h3>
                                             <p>'.$row['description'].'</p>
                                             <p>'.$tagList.'</p>
                                             <label class="image-menu">';
                                             ?>
                                             <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                             <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                             <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                                  echo '
                                             </label>
                                        </div>
                                   ';
                              }    
                         }
                         if($selected_val=="Default" and $date=="1970-01-01" and $tag!=NULL){
                              $id_user=$_SESSION['userId'];
                              $query = "SELECT * FROM pictures NATURAL JOIN tagrelations
                              NATURAL JOIN tags WHERE id_user_owner=$id_user and tag_name='$tag' ORDER BY id_picture DESC";  
                              $result = mysqli_query($connect, $query);  
                              while($row = mysqli_fetch_array($result))  
                              {    
                                   $idPicture = $row['id_picture'];
                                   $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                                   $resultt = mysqli_query($connect, $queryy);
                                   $tagList = "";
                                   while($roww = mysqli_fetch_array($resultt)){
                                        $tagList = $tagList.$roww['tag_name'].',';
                                   }
                                   echo '  
                                        <div class="image">
                                             <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                             <h3>About this photo:</h3>
                                             <p>'.$row['description'].'</p>
                                             <p>'.$tagList.'</p>
                                             <label class="image-menu">';
                                             ?>
                                             <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                             <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                             <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                                  echo '
                                             </label>
                                        </div>
                                   ';
                              }    
                         }
                         if($selected_val!="Default" and $date=="1970-01-01" and $tag!=NULL){
                              $id_user=$_SESSION['userId'];
                              $query = "SELECT * FROM pictures NATURAL JOIN tagrelations
                              NATURAL JOIN tags WHERE id_user_owner=$id_user and tag_name='$tag' and lower(title) like '%$selected_val%' ORDER BY id_picture DESC";  
                              $result = mysqli_query($connect, $query);  
                              while($row = mysqli_fetch_array($result))  
                              {    
                                   $idPicture = $row['id_picture'];
                                   $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                                   $resultt = mysqli_query($connect, $queryy);
                                   $tagList = "";
                                   while($roww = mysqli_fetch_array($resultt)){
                                        $tagList = $tagList.$roww['tag_name'].',';
                                   }
                                   echo '  
                                        <div class="image">
                                             <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                             <h3>About this photo:</h3>
                                             <p>'.$row['description'].'</p>
                                             <p>'.$tagList.'</p>
                                             <label class="image-menu">';
                                             ?>
                                             <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                             <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                             <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                                  echo '
                                             </label>
                                        </div>
                                   ';
                              }    
                         }
                         if($selected_val=="Default" and $date!="1970-01-01" and $tag!=NULL){
                              $id_user=$_SESSION['userId'];
                              $query = "SELECT * FROM pictures NATURAL JOIN tagrelations
                              NATURAL JOIN tags WHERE id_user_owner=$id_user and tag_name='$tag' and date='$date' ORDER BY id_picture DESC";  
                              $result = mysqli_query($connect, $query);  
                              while($row = mysqli_fetch_array($result))  
                              {    
                                   $idPicture = $row['id_picture'];
                                   $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                                   $resultt = mysqli_query($connect, $queryy);
                                   $tagList = "";
                                   while($roww = mysqli_fetch_array($resultt)){
                                        $tagList = $tagList.$roww['tag_name'].',';
                                   }
                                   echo '  
                                        <div class="image">
                                             <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                             <h3>About this photo:</h3>
                                             <p>'.$row['description'].'</p>
                                             <p>'.$tagList.'</p>
                                             <label class="image-menu">';
                                             ?>
                                             <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                             <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                             <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                                  echo '
                                             </label>
                                        </div>
                                   ';
                              }    
                         }
                         if($selected_val!="Default" and $date!="1970-01-01" and $tag!=NULL){
                              $id_user=$_SESSION['userId'];
                              $query = "SELECT * FROM pictures NATURAL JOIN tagrelations
                              NATURAL JOIN tags WHERE id_user_owner=$id_user and tag_name='$tag' and date='$date' and lower(title) like '%$selected_val%' ORDER BY id_picture DESC";  
                              $result = mysqli_query($connect, $query);  
                              while($row = mysqli_fetch_array($result))  
                              {    
                                   $idPicture = $row['id_picture'];
                                   $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                                   $resultt = mysqli_query($connect, $queryy);
                                   $tagList = "";
                                   while($roww = mysqli_fetch_array($resultt)){
                                        $tagList = $tagList.$roww['tag_name'].',';
                                   }
                                   echo '  
                                        <div class="image">
                                             <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                             <h3>About this photo:</h3>
                                             <p>'.$row['description'].'</p>
                                             <p>'.$tagList.'</p>
                                             <label class="image-menu">';
                                             ?>
                                             <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                             <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                             <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                                  echo '
                                             </label>
                                        </div>
                                   ';
                              }    
                         }
                         
                    }
                    else{
                         //Afisare Imaginii

                         
                         $id_user=$_SESSION['userId'];
                         $query = "SELECT * FROM pictures WHERE id_user_owner=$id_user ORDER BY id_picture DESC";  
                         $result = mysqli_query($connect, $query);  
                         while($row = mysqli_fetch_array($result))  
                         {    
                              $idPicture = $row['id_picture'];
                              $queryy = "SELECT tag_name FROM Tags natural join TagRelations WHERE id_picture = $idPicture";
                              $resultt = mysqli_query($connect, $queryy);
                              $tagList = "";
                              while($roww = mysqli_fetch_array($resultt)){
                                   $tagList = $tagList.$roww['tag_name'].',';
                              }
                              echo '  
                                   <div class="image">
                                        <img src="data:image/jpeg;base64,'.base64_encode($row['picture'] ).'" alt="">
                                        <h3>About this photo:</h3>
                                        <p>'.$row['description'].'</p>
                                        <p>'.$tagList.'</p>
                                        <label class="image-menu">';
                                        ?>
                                        <a href="delete.php?id=<?php echo $row["id_picture"]; ?>">Delete</a>
                                        <a href="download.php?id=<?php echo $row["id_picture"]; ?>">Download</a>
                                        <a href="Edit.php?id=<?php echo $row["id_picture"]; ?>">Edit</a> <?php
                                             echo '
                                        </label>
                                   </div>
                              ';
                         }

                    }
               ?>

               
          </div>
          <script src="scripts/handleSession.js"></script>
      </body>  

</html>