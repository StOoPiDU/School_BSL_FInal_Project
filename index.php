<?php
/*
 * Final Project - Best Soccer League
 * Name: Cedric Pereira
 * Start Date: November 11, 2022
 * Description: Main landing page for the Final Project
 */
    require_once('connect.php');
    
    if(isset($_SESSION['admin']))
    {
        $admin = $_SESSION['admin'];
    }

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }

    $query = "SELECT * FROM player INNER JOIN teams on player.team_id = teams.team_id WHERE post_is_active = 1 ORDER BY player_id DESC LIMIT 5";
    $statement = $db->prepare($query);
    $statement->execute(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Best Soccer League</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div id="wrapper">
        <?php if(!isset($_SESSION['username'])): ?>
            <a href="login.php">Login</a>
        <?php endif ?>
        <?php if(isset($_SESSION['username'])): ?>
            <a href="logout.php">Logout</a>
        <?php endif ?>
        <?php if(!isset($_SESSION['username'])): ?>
            <a href="signup.php">Register</a>
        <?php endif ?>
        <?php if(isset($_GET['success'])): ?>
            <h3>Hello <?= $username?></h3>
        <?php endif ?>


        <div id="header">
            <h1><a href="index.php">Best Soccer League</a></h1>
            <h2>The greatest 6v6 Footy League in the world!</h2>
        </div> 

        <div>
            <h3>Welcome to the landing page for BSL.</h3>
            <h4>View players, stats, team information, and market evaluations for the leading 6v6 Soccer League.</h4>
            <h4>Below you can see a couple examples. Select "List of All Players" to see every player in the database.</h4>
        </div>

        <form method ="post" action="search.php">
            <select name="category" class="form-control" id="sele">
                <option value="nationality" selected="selected">Nationality</option>
                <option value="goals">Goals</option>
                <option value="saves">Saves</option>
            </select>
            <input type="text" name="searchResult" placeholder="Search">
            <button type="submit">Search</button>
        </form>

        <ul id="menu">
            <li><a href="view_all.php" class='active'>List Of All Players</a></li>
            <li><a href="create.php">Add A New Player</a></li>
        </ul> 

        <ul id="menu">
            <li><a href="view_team.php?team_id=1">Leafs</a></li>
            <li><a href="view_team.php?team_id=2">Lovers</a></li>
            <li><a href="view_team.php?team_id=3">Waves</a></li>
            <li><a href="view_team.php?team_id=4">Jerks</a></li>
            <li><a href="view_team.php?team_id=5">Footsies</a></li>
            <li><a href="view_team.php?team_id=6">Invaders</a></li>
        </ul>

        <div id="all_blogs">
            <?php if($statement->rowCount() != 0): ?>
            <!-- Fetch each table row. -->
                <?php while($row = $statement->fetch()): ?>
                <div id="blog_post">
                    <h2><a href="view.php?player_id=<?= $row['player_id'] ?>"><?= $row['first_name']?> <?=$row['last_name']?></a></h2>
                    <h3><?=$row['position']?></h3>
                    <h3><?=$row['nationality']?></h3>
                    <h3><?=$row['team_name']?></h3>
                    <p><small><a href="edit.php?player_id=<?= $row['player_id'] ?>">Edit Player</a></small></p>
                </div>
                <?php endwhile ?> 
        
            <?php else: ?> 
                <h1> No players found. The league is dead!</h1>
            <?php endif ?> 
        </div>
        <div id="footer"> Copyright <?=date('Y')?> - Please Give Me 100% Marks :D</div>
    </div>
</body>
</html> 