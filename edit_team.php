<?php
//store the post array into variables
extract($_POST);

//start the session to store variables
session_start();

//set the validation to true
$validated = true;

//validate and sanitize the team name
if (empty($team_name)) {
    $_SESSION["errTeamName"] = "Please enter the correct team name";
    $validated = false;
} else {
    $team_name = filter_var($team_name, FILTER_SANITIZE_STRING);
}

//validate and sanitize the team city
if (empty($team_city)) {
    $_SESSION["errTeamCity"] = "Please enter the correct city name";
    $validated = false;
} else {
    $team_city = filter_var($team_city, FILTER_SANITIZE_STRING);
}

//validate and sanitize the team arena
if (!empty($team_arena)) {
    $team_arena = filter_var($team_arena, FILTER_SANITIZE_STRING);
}

//if there is any error redirect to form page and show the errors
if ($validated == false) {
    $_SESSION["errorTeam"] = "Team could not update due to following error(s)";
    header("Location: update_team.php?teamid=" . $id);
} else {
    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = "UPDATE tblteams SET team_name = :team_name, team_city = :team_city , team_arena = :team_arena WHERE id= :id";

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':team_name', $team_name, PDO::PARAM_STR, 20);
    $sth->bindParam(':team_city', $team_city, PDO::PARAM_STR, 20);
    $sth->bindParam(':team_arena', $team_arena, PDO::PARAM_STR, 20);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);

    //execute the sql statement
    $sth->execute();

    //set the database connection to null, to end the connection
    $dbh = null;

    //redirect to teams page to show the updated team
    header("Location: teams.php");
}