<?php  
//Upload database
include("sharedFunctions.php");
checkSession();
// if ( != 0){
//      startPersistentSession();
// }
// }else{
//      // Header("Location: http://localhost/pixB/PiX-B/");
// }

 $connect = mysqli_connect("localhost", "root", "", "pixData"); 
  
 if(isset($_POST["insert"]))  
 {  
     
     $file_array=reArrayFiles($_FILES['image']);
     $file_count=count($file_array);

     if($file_array['0']['size']== 0)
     {
          echo "Please select an image.";
     }
     else
     {
     
          for($i=0;$i<$file_count;$i++){
               $file = addslashes(file_get_contents($file_array[$i]['tmp_name']));  
               $title= addslashes($file_array[$i]['name']);
               $query = "INSERT INTO Pictures(id_user_owner, picture,title) VALUES (1, '$file','$title')";

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
		     <h1>Your images</h1>
               <form method="post" enctype="multipart/form-data">
                    <input type="file" name="image[]" id="image" multiple="" />
                    <br />
                    <input id="Describe" type="text" name="Describe" placeholder="Describe" />
                    <br />
                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
               </form>
          
		     <select>
			     <option>All image</option>
			     <option>Sort by data</option>
			     <option>Sort by #montain</option>
		     </select>
               <!-- <div class="filter">
               <button type="filter-by">Filter by</button>
               <input type="text" placeholder="date/tag">
               </div> -->9
          </header>
          <div class="gallery">
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
          </div>
      </body>  

 </html>  
 <!-- <script>  
 $(document).ready(function(){  
      $('#insert').click(function(){  
           var image_name = $('#image').val();  
           if(image_name === '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script>   -->