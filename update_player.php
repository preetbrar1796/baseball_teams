<?php
//check if we can get playerid
if (isset($_GET['playerid'])) {

    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = "SELECT * FROM tblplayers WHERE id=:id";

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':id', $_GET["playerid"], PDO::PARAM_INT);

    //execute the sql statement
    $sth->execute();

    //store the row from database into player
    $player = $sth->fetch();

    //build the sql
    $sql = "SELECT id, team_name FROM tblteams";

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //execute the sql statement
    $sth->execute();

    //store all the rows from database into teams
    $teams = $sth->fetchAll();

    //store all the row count from database into row_count
    $row_count = $sth->rowCount();

    //set the database connection to null, to end the connection
    $dbh = null;
} //check if we can get teamid then we can redirect to that team's player page
else if (isset($_GET["teamid"])) {
    header('Location: players.php?teamid=' . $_GET["teamid"]);
} //otherwise redirect to teams page
else {
    header('Location: teams.php');
}
//start the session to get session variables
session_start();

//store the session array into variables
extract($_SESSION);

//unset the session variables
session_unset();
?>
<!DOCTYPE HTML>
<html lang="en">
<!--head region of the page-->
<head>
    <meta name="viewport" content="width=device-width initial-scale=1">
    <!--link to stylesheets-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O"
          crossorigin="anonymous">
    <link href="stylesheets/common.css" rel="stylesheet">
    <!--title of the page-->
    <title>Update Player</title>
</head>
<body>
<div class="container">
    <!--include the background.php to get background of the page-->
    <?php include "background.php"; ?>
    <!--include the header.php to get header of the page-->
    <?php include "header.php" ?>
    <!--if there is any error after the validation of the form it goes here-->
    <?php if ($row_count > 0): ?>
        <?php if (isset($_SESSION['errorPlayer'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['errorPlayer']; ?>
            </div>
        <?php endif; ?>
        <div>
            <!--heading of the page-->
            <h1>Please provide the information below to update the player</h1>
        </div>
        <!--input form for the page-->
        <form class="form-horizontal" method="post" action="edit_player.php">
            <fieldset>
                <legend>Player Information</legend>
                <div class="form-group <?php if (isset($errTeamId)): echo "has-error has-feedback"; endif; ?>">
                    <label class="col-sm-2 control-label" for="team_id">Team</label>
                    <div class="input-group">
                        <select name="team_id" class="form-control col-sm-3 col-sm-offset-1" required>
                            <option value="selectteam" selected>----Select Team----</option>
                            <?php foreach ($teams as $team) : ?>
                                <option value="<?= $team["id"] ?>"
                                    <?php if (isset($_GET["teamid"]) && $team["id"] == $_GET["teamid"]): ?>
                                        <?= "selected"; ?>
                                    <?php endif; ?>>
                                    <?= $team["team_name"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--if the error is in the selection of team then it goes here-->
                    <?php if (isset($errTeamId)): ?>
                        <div class="text-danger"><?= $errTeamId ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group <?php if (isset($errPlayerName)): echo "has-error has-feedback"; endif; ?>">
                    <label class="col-sm-2 control-label" for="player_fname">Player Name</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" type="text" name="player_fname" max="15" required
                               pattern="[A-Za-z]{3,15}" placeholder="Player's first name"
                               title="Please provide correct first name"
                               value="<?= $player["player_fname"] ?>">
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" type="text" name="player_lname" max="15" required
                               pattern="[A-Za-z]{3,15}" placeholder="Player's last name"
                               title="Please provide correct last name"
                               value="<?= $player["player_lname"] ?>">
                    </div>
                    <!--if the error is in the input of player name then it goes here-->
                    <?php if (isset($errPlayerName)): ?>
                        <div class="text-danger"><?= $errPlayerName ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="player_position">Position</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" type="text" name="player_position" max="15"
                               pattern="[1-3A-Za-z\s]{3,15}" placeholder="Player's position"
                               title="Please provide correct position"
                               value="<?= $player["player_position"] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="player_number">Player Number</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" type="number" name="player_number" max="99"
                               placeholder="Player's Number"
                               value="<?= $player["player_number"] ?>">
                    </div>
                </div>
                <div class="input-group col-sm-offset-2">
                    <input type="hidden" name="id" value="<?= $player['id'] ?>">
                    <button class="btn btn-primary"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Update Player</button>
                </div>
            </fieldset>
        </form>
    <?php else: ?>
        <div class='alert alert-warning'>
            <p>No team found.<a href="new_team.php">&nbsp;&nbsp;Add Team</a></p>
        </div>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>