<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: December 9, 2022
 * Description: This turns a user into an admin. Failed trying to do this elsewhere. I quit!
 */
require_once('connect.php');
//$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$user_id = $_GET['user_id'];
$query = "UPDATE user SET admin = 1 WHERE user_id = :user_id";
$statement = $db->prepare($query);
$statement->bindValue(':user_id', $user_id);
$statement->execute();
header("Location: user.php");
?>