<?php 
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: December 8, 2022
 * Description: User page with permission adjustments by admin.
 */
    require_once('connect.php');

    $query = "SELECT * FROM user";
    $statement = $db->prepare($query);
    $statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Best Soccer League - Users</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.css"/>
    <title>Users</title>
</head>
<body>
    <div id="header">
        <h1><a href="index.php">Best Soccer League</a></h1>
        <h2>The greatest 6v6 Footy League in the world!</h2>
    </div> 

    <div>
        <h3>Need to change user permissions?</h3>
    </div>

    <?php while($row = $statement->fetch()):?>
        <?php if($row['admin'] > 0):?>
            <?php $admin = true ?>
        <?php else: ?>
            <?php $admin = false ?>
        <?php endif ?>
        <h2><?=$row['username']?></h2>
        <?php if($admin):?>
            <h3>User is admin</h3>
        <?php else:?>
            <h3>User is not admin</h3>
        <?php endif ?>
    <?php endwhile ?>
    <a href="index.php">Home</a>
</body>
</html>