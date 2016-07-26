<?php
//delete the team by getting team id
if (isset($_GET["teamid"])) {
    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = "DELETE FROM tblteams WHERE id =:id";
  
    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':id', $_GET["teamid"], PDO::PARAM_INT);

    //execute the sql statement
    $sth->execute();

    //set the database connection to null, to end the connection
    $dbh = null;
}
//redirect to teams page to show the remaining teams
header("Location: teams.php");