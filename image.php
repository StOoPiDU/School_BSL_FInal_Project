<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: December 10, 2022
 * Description: Image uploading. First go at it, so please be nice!
 */
    require('connect.php');
    
    if(isset($_GET['player_id']))
    {
        $player_id = $_GET['player_id'];
    }

    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') 
    {
        $current_folder = dirname(__FILE__);

        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }
    function file_is_an_image($temporary_path, $new_path) 
    {
         $allowed_mime_types  = ['image/gif', 'image/jpeg', 'image/png'];
         $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'GIF', 'JPG', 'JPEG', 'PNG'];
         
         $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
         $actual_mime_type = getimagesize($temporary_path)['mime'];
         
         $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
         $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);
         
         return $file_extension_is_valid && $mime_type_is_valid;
    }
     
     $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
     $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);
     
    if ($image_upload_detected) 
    { 
        $image_filename = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path = file_upload_path($image_filename);
         

        if (file_is_an_image($temporary_image_path, $new_image_path)) {   
            
            $query = "INSERT INTO image (player_id, image_name) VALUES (:player_id, :image_name)";
            $statement = $db->prepare($query);
   
            $statement->bindValue(':player_id', $player_id);
            $statement->bindValue(':image_name', $image_filename);
   
            $statement->execute();

             move_uploaded_file($temporary_image_path, $new_image_path);

             header("Location: view.php?player_id={$player_id}");
        }
         
         
    }
 ?>
  <!DOCTYPE html>
  <html>
      <head><title>BSL - Image Uploading</title></head>
  <body>
      <form method='post' enctype='multipart/form-data'>
          <label for='image'>Image Filename:</label>
          <input type='file' name='image' id='image'>
          <input type='submit' name='submit' value='Upload Image'>
      </form>
      
     <?php if ($upload_error_detected): ?>
 
         <p>Error Number: <?= $_FILES['image']['error'] ?></p>
 
     <?php elseif ($image_upload_detected): ?>
 
         <p>Image: <?= $_FILES['image']['name'] ?> upload failed, file MUST be in image.</p>
 
     <?php endif ?>
     <a href='index.php'>Home</a>
  </body>
  </html>