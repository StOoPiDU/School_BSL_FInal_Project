<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: December 10, 2022
 * Description: This deletes a comment. Failed trying to do this elsewhere. I quit!
 */
    require_once('connect.php');

    if (isset($_GET['player_id'])) 
    {
        $player_id = $_GET['player_id'];
    }

    if (isset($_GET['comment_id']))
    { 
        // The filter is broken? $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
        $comment_id = $_GET['comment_id'];
        //deb($comment_id,1);
        
        $query = "UPDATE comment SET post_is_active = 0 WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->execute();
        header("Location: view.php?player_id={$player_id}"); 
    }
?>