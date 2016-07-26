<?php
//get connect.php to connect to database
require "connect.php";

//build the sql
$sql = "SELECT * FROM tblteams";

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
    <!--link to stylesheets-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O" crossorigin="anonymous">
    <link href="stylesheets/common.css" rel="stylesheet">
    <!--title of the page-->
    <title>Teams</title>
</head>
<body>
<div class="container">
    <!--include the background.php to get background of the page-->
    <?php include "background.php"; ?>
    <!--include the header.php to get header of the page-->
    <?php include "header.php" ?>
    <section>
        <!--if there is any team stored then only build the table-->
        <?php if ($row_count > 0): ?>
            <div>
                <!--heading of the page-->
                <h1>Teams</h1>
            </div>
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Team name</th>
                    <th>City</th>
                    <th>Arena</th>
                </tr>
                </thead>
                <tbody>
                <?php $number = 1 ?>
                <?php foreach ($teams as $team): ?>
                    <tr>
                        <td><?= $number ?></td>
                        <td>
                            <a href="players.php?teamid=<?= $team["id"] ?>"><?= $team["team_name"] ?></a>
                        </td>
                        <td><?= $team["team_city"] ?></td>
                        <td><?= $team["team_arena"] ?></td>
                        <td>
                            <a href="update_team.php?teamid=<?= $team["id"] ?>"><i class="fa fa-pencil">
                                </i>&nbsp;&nbsp;Update</a>
                        </td>
                        <td>
                            <a href="delete_team.php?teamid=<?= $team["id"] ?>"><i class="fa fa-trash">
                                </i>&nbsp;&nbsp;Delete</a>
                        </td>
                        <?php $number++ ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!--if there was no team then give the warning to the user-->
            <div class="alert alert-warning">
                <p>No team found.<a href="new_team.php">&nbsp;&nbsp;Add Team</a></p>
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