<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: November 17, 2022
 * Description: Logout page for Final Project
 */
session_start();
session_destroy();
header("location:index.php");
?>