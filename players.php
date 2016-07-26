<?php
//check if we can get teamid
if (isset($_GET["teamid"])) {
    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = "SELECT * FROM tblplayers WHERE team_id =:id";

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':id', $_GET["teamid"], PDO::PARAM_INT);

    //execute the sql statement
    $sth->execute();

    //store all the rows from database into players
    $players = $sth->fetchAll();

    //store all the row count from database into row_count
    $row_count = $sth->rowCount();

    //set the database connection to null, to end the connection
    $dbh = null;
}else{
    header("Location: teams.php");
}
?>
<!DOCTYPE HTML>
<html lang="en">
<!--head region of the page-->
<head>
    <!--link to stylesheets-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O" crossorigin="anonymous">
    <link href="stylesheets/common.css" rel="stylesheet">
    <!--title of the page-->
    <title>Players</title>
</head>
<body>
<div class="container">
    <!--include the background.php to get background of the page-->
    <?php include "background.php"; ?>
    <!--include the header.php to get header of the page-->
    <?php include "header.php" ?>
    <!--if there is any error after the validation of the form it goes here-->
    <section>
        <!--if there is any player stored then only build the table-->
        <?php if ($row_count > 0): ?>
            <div>
                <!--heading of the page-->
                <h1>Players</h1>
            </div>
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Player name</th>
                    <th>Position</th>
                    <th>Number</th>
                </tr>
                </thead>
                <tbody>
                <?php $number = 1 ?>
                <?php foreach ($players as $player): ?>
                    <tr>
                        <td><?= $number ?></td>
                        <td>
                            <?= $player["player_fname"] . " " . $player["player_lname"] ?>
                        </td>
                        <td><?= $player["player_position"] ?></td>
                        <td><?= $player["player_number"] ?></td>
                        <td>
                            <a href="update_player.php?playerid=<?= $player["id"] ?>&teamid=<?= $player["team_id"] ?>"><i
                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Update</a>
                        </td>
                        <td>
                            <a href="delete_player.php?playerid=<?= $player["id"] ?>&teamid=<?= $player["team_id"] ?>"><i
                                    class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a></td>
                        <?php $number++ ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!--if there was no player then give the warning to the user-->
            <div class="alert alert-warning">
                <p>No player found.<a href="new_player.php">&nbsp;&nbsp;Add Player</a></p>
            </div>
        <?php endif ?>
    </section>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>
