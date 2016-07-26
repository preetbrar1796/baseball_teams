<?php
//start the session to get session variables
session_start();

//store the session array into variables
extract($_SESSION);

//unset the session variables
session_unset();

//get connect.php to connect to database
require "connect.php";

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
    <title>New Player</title>
</head>
<body>
<div class="container">
    <!--include the background.php to get background of the page-->
    <?php include "background.php"; ?>
    <!--include the header.php to get header of the page-->
    <?php include "header.php" ?>
    <!--if there is any team stored then ask the user to add new player-->
    <?php if ($row_count > 0): ?>
        <!--if there is any error after the validation of the form it goes here-->
        <?php if (isset($errorPlayer)): ?>
            <div class="alert alert-danger">
                <?= $errorPlayer; ?>
            </div>
        <?php endif; ?>
        <div>
            <!--heading of the page-->
            <h1>Please provide the information below to add a new player to the list</h1>
        </div>
        <!--input form for the page-->
        <form class="form-horizontal" method="post" action="add_player.php">
            <fieldset>
                <legend>Player Information</legend>
                <div class="form-group <?php if (isset($errTeamId)): echo "has-error has-feedback"; endif; ?>">
                    <label class="col-sm-2 control-label" for="team_id">Team</label>
                    <div class="input-group">
                        <select name="team_id" class="form-control col-sm-3 col-sm-offset-1" required>
                            <option value="selectteam" selected>----Select Team----</option>
                            <?php foreach ($teams as $team) : ?>
                                <option value="<?= $team["id"] ?>"
                                    <?php if (isset($team_id) && $team["id"] == $team_id): ?>
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
                            <?php if (isset($player_fname)): echo "value=" . $player_fname; endif; ?>>
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" type="text" name="player_lname" max="15" required
                               pattern="[A-Za-z]{3,15}" placeholder="Player's last name"
                               title="Please provide correct last name"
                            <?php if (isset($player_lname)): echo "value=" . $player_lname; endif; ?>>
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
                            <?php if (isset($player_position)): echo "value=" . $player_position; endif; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="player_number">Player Number</label>
                    <div class="col-sm-4">
                        <input class="form-control input-sm" type="number" name="player_number" max="99"
                               placeholder="Player's Number"
                            <?php if (isset($player_number)): echo "value=" . $player_number; endif; ?>>
                    </div>
                </div>
                <div class="input-group col-sm-offset-2">
                    <button class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Player</button>
                </div>
            </fieldset>
        </form>
    <?php else: ?>
        <div class="alert alert-warning">
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