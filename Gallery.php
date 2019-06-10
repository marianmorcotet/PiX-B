<?php  
//Upload database
 $connect = mysqli_connect("localhost", "root", "", "test");  
 if(isset($_POST["insert"]))  
 {  
     if(getimagesize ($_FILES['image']['tmp_name'])=== FALSE)
     {
         echo '<h3>Please select an image.</h3>';
     }
     else{
      $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
      $title= addslashes($_FILES['image']['name']);
      $query = "INSERT INTO tbl_images(name,title) VALUES ('$file','$title')";  
      if(mysqli_query($connect, $query))  
      {  
           echo '<script>alert("Image Inserted into Database")</script>';  
      }  
     }
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
                    <input type="file" name="image" id="image" multiple="" />
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
               </div> -->
          </header>
          <div class="gallery">
               <?php  
               //Afisare Imaginii
               $query = "SELECT * FROM tbl_images ORDER BY id DESC";  
               $result = mysqli_query($connect, $query);  
               while($row = mysqli_fetch_array($result))  
               {  
                    echo '  
                         <div class="image">
                              <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'" alt="">
                              <h3>About this photo:</h3>
                              <p>Descriere imagine</p>
                              <label class="image-menu">
                                   <button>Download</button>
                                   <button>Edit</button>
                                   <button>Delete</button>
                              </label>
                         </div>
                    ';
               }
               ?>  
          </div>
      </body>  

 </html>  
 <script>  
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
 </script>  