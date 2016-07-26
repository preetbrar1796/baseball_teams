<?php
//delete the player by getting his id
if (isset($_GET["playerid"])) {
    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = "DELETE FROM tblplayers WHERE id =:id";

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':id', $_GET["playerid"], PDO::PARAM_INT);

    //execute the sql statement
    $sth->execute();

    //set the database connection to null, to end the connection
    $dbh = null;
}
//redirect to players page to show the remaining players
header("Location: players.php?teamid=".$_GET["teamid"]);