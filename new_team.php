<?php
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
    <!--link to stylesheets-->
    <meta name="viewport" content="width=device-width initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O"
          crossorigin="anonymous">
    <link href="stylesheets/common.css" rel="stylesheet">
    <!--title of the page-->
    <title>New Team</title>
</head>
<body>
<div class="container clear-top">
    <!--include the background.php to get background of the page-->
    <?php include "background.php"; ?>
    <!--include the header.php to get header of the page-->
    <?php include "header.php" ?>
    <!--if there is any error after the validation of the form it goes here-->
    <?php if (isset($errorTeam)): ?>
        <div class="alert alert-danger">
            <?= $errorTeam; ?>
        </div>
    <?php endif; ?>
    <div>
        <!--heading of the page-->
        <h1>Please provide the information below to add a new team to the list</h1>
    </div>
    <!--input form for the page-->
    <form class="form-horizontal" method="post" action="add_team.php">
        <fieldset>
            <legend>Team Information</legend>
            <div class="form-group <?php if (isset($errTeamName)): echo "has-error has-feedback"; endif; ?>">
                <label class="col-sm-2 control-label" for="team_name">Team Name</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" type="text" name="team_name" max="20" required
                           pattern="[A-Za-z\s]{3,20}" placeholder="Team's name" title="Please enter correct team name"
                        <?php if (isset($team_name)): echo "value=" . $team_name; endif; ?>>
                </div>
                <!--if the error is in the name then it goes here-->
                <?php if (isset($errTeamName)): ?>
                    <div class="text-danger"><?= $errTeamName ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group <?php if (isset($errTeamCity)): echo "has-error has-feedback"; endif; ?>">
                <label class="col-sm-2 control-label" for="team_city">City</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" type="text" name="team_city" max="20" required
                           pattern="[A-Za-z\s]{3,20}" placeholder="Team's City" title="Please provide correct city name"
                        <?php if (isset($team_city)): echo "value=" . $team_city; endif; ?>>
                </div>
                <!--if the error is in the team city then it goes here-->
                <?php if (isset($errTeamCity)): ?>
                    <div class="text-danger"><?= $errTeamCity ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="team_arena">Arena</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" type="text" name="team_arena" max="20"
                           pattern="[A-Za-z\s]{3,20}" placeholder="Team's Arena"
                           title="Please provide correct arena name"
                        <?php if (isset($team_arena)): echo "value=" . $team_arena; endif; ?>>
                </div>
            </div>
            <div class="input-group col-sm-offset-2">
                <button class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Team</button>
            </div>
        </fieldset>
    </form>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>