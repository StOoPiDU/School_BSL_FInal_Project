<?php 
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: December 10, 2022
 * Description: This deletes the image. Failed trying to do this elsewhere. I quit!
 */
    require_once('connect.php');
    $imageName = "";

    if(isset($_GET['player_id']))
    {
        $player_id = $_GET['player_id'];
    }

    $query = "SELECT image_name FROM image WHERE player_id = :player_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':player_id', $player_id, PDO::PARAM_INT);
    $statement->execute();
    
    // Opted to fully delete the image here too since it would make more sense
    $query2 = "DELETE FROM image WHERE player_id = :player_id"; 
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':player_id', $player_id, PDO::PARAM_INT);
    $statement2->execute();

    if($statement->rowCount() != 0)
    {
        while($row = $statement->fetch())
        {
            $imageName = $row['image_name'];
        }
    }

    $path = "C:/xampp/htdocs/wd2o/final/uploads/$imageName";

    if(!unlink($path))
    {
        echo "Cannot unlink!";
    }
    else
    {
        header("Location: view.php?player_id={$player_id}");
    }
?>