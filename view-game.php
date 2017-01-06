<?php
/*-------------------------------------------------------+
| Bowling Statistics
| View Single Game Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/
$page_title = "View Single Game";
require('includes/config.php');
include('includes/header.php');
$mysqli = db_connect();

if(!isset($_GET['game']) || $_GET['game'] == '' ) {
    $_SESSION['error'] = "No Game Selected";
    header("Location: " . DIR);
    exit();
}

$game = mysqli_real_escape_string($mysqli, $_GET['game']);
$sql = "SELECT * from games WHERE game_id = '$game'";
$results = mysqli_query($mysqli, $sql);
$game = mysqli_fetch_object($results);
$frames = json_decode($game->frames, true);

foreach($frames as $frame => $score) {
    echo "<p>" . $frame . ": " . $score . "</p>";
}

include("includes/footer.php");


