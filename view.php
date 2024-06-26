<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Date: November 11, 2022
 * Description: Viewing a player
 */
    require_once('connect.php');
    if (isset($_GET['player_id']))
    {
        // Build and prepare SQL String with :player_id placeholder parameter.
        $query = "SELECT * FROM player INNER JOIN teams on player.team_id = teams.team_id WHERE player.player_id = :player_id";
        $statement = $db->prepare($query);
        // This one is for the comment(s).
        $query2 = "SELECT * FROM comment WHERE player_id = :player_id AND post_is_active = 1 ORDER BY comment_id DESC";
        $statement2 = $db->prepare($query2);
        // This one is for the image.
        $query3 = "SELECT * FROM image WHERE player_id = :player_id LIMIT 1";
        $statement3 = $db->prepare($query3);

        // Sanitize $_GET['player_id'] to ensure it's a number.
        $player_id = filter_input(INPUT_GET, 'player_id', FILTER_SANITIZE_NUMBER_INT);
        
        // Bind the :player_id parameter in the query to the sanitized
        // $player_id specifying a binding-type of Integer.
        $statement->bindValue(':player_id', $player_id, PDO::PARAM_INT);
        $statement->execute();
        $statement2->bindValue(':player_id', $player_id, PDO::PARAM_INT);
        $statement2->execute();
        $statement3->bindValue(':player_id', $player_id, PDO::PARAM_INT);
        $statement3->execute();
        
        // Fetch the row selected by primary key id. (This is for the player value(s))
        $value = $statement->fetch();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Player - <?= $value['first_name'] ?> <?= $value['last_name'] ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div id="wrapper">

        <form method ="post" action="search.php">
            <select name="category" class="form-control" id="sele">
                <option value="nationality" selected="selected">Nationality</option>
                <option value="goals">Goals</option>
                <option value="saves">Saves</option>
            </select>
            <input type="text" name="searchResult" placeholder="Search">
            <button type="submit">Search</button>
        </form>
        
        <div id="header">
            <h1><a href="index.php">Best Soccer League - <?= $value['first_name'] ?> <?= $value['last_name'] ?></a></h1>
        </div> 

        <ul id="menu">
            <li><a href="view_all.php" class='active'>List Of All Players</a></li>
            <li><a href="create.php">Add A New Player</a></li>
        </ul> 

        <div id="all_blogs">
            <div id="blog_post">
                <?php while($imageRows = $statement3->fetch()): ?>
                    <a href="uploads/<?=$imageRows['image_name']?>"><img src="uploads/<?=$imageRows['image_name']?>" height="200" width="300"></a>
                    <?php if(isset($_SESSION['admin'])):?>
                        <p><small><a href="image_delete.php?player_id=<?= $imageRows['player_id'] ?>">Delete Image</a></small></p>
                    <?php endif ?>
                <?php endwhile ?>
                <h2><a><?=$value['first_name'] ?></a></h2>
                <h2><?=$value['last_name']?></h2>
                <h3><?=$value['position']?></h3>
                <h3><?=$value['nationality']?></h3>
                <h3><?=$value['team_name']?></h3>
                <p><small><a href="edit.php?player_id=<?= $value['player_id'] ?>">Edit Player</a></small></p>
            </div> 
        </div>

        <div id="all_blogs">
            <?php if(isset($_SESSION['admin'])):?>
                <p><a href="image.php?player_id=<?=$value['player_id']?>">Upload an Image</a></p>
            <?php endif ?>
            <p><a href="comment.php?player_id=<?= $value['player_id'] ?>">Leave A Comment</a></p>
            <?php if($statement2->rowCount() != 0): ?>
            <!-- Fetch each table row. -->
                <?php while($row = $statement2->fetch()): ?>
                <div id="blog_post">
                    <h3><?=$row['title']?></h3>
                    <h4><?=$row['comment']?></h4>
                    <?php if($row['name'] != NULL): ?> <h5><em> Comment left by <?=$row['name']?></em></h5><?php endif ?>
                    <p><small><?=$row['date']?></small></p>
                    <?php if(isset($_SESSION['admin'])):?>
                        <p><small><a href="comment_delete.php?comment_id=<?= $row['comment_id'] ?>&player_id=<?= $row['player_id'] ?>">Delete Comment</a></small></p>
                    <?php endif ?>
                </div>
            <?php endwhile ?> 
            <?php else: ?> 
                <h1> No comments.</h1>
            <?php endif ?> 
        </div>

        <div id="footer"> Copyright YadaYada - Please Give Me 100% Marks :D</div>
    </div>
</body>
</html> 