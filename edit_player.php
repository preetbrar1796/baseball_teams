<?php
//store the post array into variables
extract($_POST);

//start the session to store variables
session_start();

//set the validation to true
$validated = true;

//validate and sanitize the team id
if ($team_id == "selectteam") {
    $_SESSION["errTeamId"] = "Please select a team";
    $validated = false;
} else {
    $team_id = filter_var($team_id, FILTER_SANITIZE_NUMBER_INT);
}

//validate and sanitize the player's first name and last name
if (empty($player_fname) || empty($player_lname)) {
    $_SESSION["errPlayerName"] = "Please enter the correct player name";
    $validated = false;
} else {
    $player_fname = filter_var($player_fname, FILTER_SANITIZE_STRING);
    $player_lname = filter_var($player_lname, FILTER_SANITIZE_STRING);
}

//sanitize the player position
if (!empty($player_position)) {
    $player_position = filter_var($player_position, FILTER_SANITIZE_STRING);
}

//sanitize the player number
if (!empty($player_number)) {
    $player_number = filter_var($player_number, FILTER_SANITIZE_NUMBER_INT);
}

//if there is any error redirect to form page and show the errors and populate the user's data
if ($validated == false) {
    $_SESSION["errorPlayer"] = "Player could not be updated due to following error(s)";
    header("Location: update_player.php?playerid=" . $id);
} else {
    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = 'UPDATE tblplayers SET player_fname = :player_fname, player_lname = :player_lname, player_position = :player_position, player_number = :player_number, team_id = :team_id WHERE id = :id';

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':player_fname', $player_fname, PDO::PARAM_STR, 15);
    $sth->bindParam(':player_lname', $player_lname, PDO::PARAM_STR, 15);
    $sth->bindParam(':player_position', $player_position, PDO::PARAM_STR, 15);
    $sth->bindParam(':player_number', $player_number, PDO::PARAM_INT, 2);
    $sth->bindParam(':team_id', $team_id, PDO::PARAM_INT);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);

    //execute the sql statement
    $sth->execute();

    //set the database connection to null, to end the connection
    $dbh = null;

    //redirect to players page to show the updated player
    header("Location: players.php?teamid=" . $team_id);
}