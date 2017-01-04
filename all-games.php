<?php
/*-------------------------------------------------------+
| Bowling Statistics
| View Multiple Games Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/
$page_title = "View Games";
require('includes/config.php');
include('includes/header.php');
$mysqli = db_connect();
?>

<?php

if((isset($_SESSION['memberID']) && $_SESSION['memberID'] != '') && (!isset($_GET['user']) && !isset($_GET['all'])) ) {
    $user = $_SESSION['memberID'];
    $user_filter = "WHERE member_id = '$user'";
} elseif (isset($_GET['all'])) {
    $user_filter = "WHERE member_id != 0";
} elseif ((isset($_GET['user']) && $_GET['user'] != '' )) {
    $user = mysqli_real_escape_string($mysqli, $_GET['user']);
    $user_filter = "WHERE member_id = '$user'";
} else {
    $user_filter = "WHERE member_id != 0";
}



$user_games_query = "SELECT games.date AS date, games.member_id AS member_id, games.score AS score, games.full_game AS full_game, games.league_play AS league_play, games.game_id AS game_id, members.memberID AS memberID, members.username AS username, user_data.avatar AS avatar FROM games INNER JOIN members ON games.member_id = members.memberID INNER JOIN user_data ON user_data.memberID = games.member_id " . $user_filter . " ORDER BY score DESC";

$user_games = mysqli_query(db_connect(), $user_games_query) or die("failed: " . mysqli_error($mysqli));

if (isset($user) && $user != '' ){
    $user_id_filter = "WHERE memberID = '$user'";
    $get_user = "SELECT memberID, username FROM members " . $user_id_filter;
    $row = mysqli_query($mysqli, $get_user);
    $result = mysqli_fetch_array($row) or die('Query failed. ' . mysqli_error($mysqli));
    $username = $result['username'];
}


$avg_query = "SELECT AVG(score) as avg FROM ( SELECT * FROM games " .$user_filter . ") AS avg_table";
$avg_result = mysqli_query($mysqli, $avg_query);
$avg = mysqli_fetch_array($avg_result);
$avg = intval($avg['avg']);
?>
<div id="content">

<?php
if (isset($username) && $username != '') {
    ?>
<h2><?php echo $username."'s Games"; ?><span class="avg"><?php echo "Avg: " .$avg; ?></span></h2>
<?php
} else {
    ?>
    <h2>All Games</h2>
    <?php
}
?>
<p class="legend"><span style="background-color: #333; height: 16px, width: 16px; margin-left: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp; Shaded rows are league games<span class="all-games bbutton"><a href="<?php echo DIR.'/all-games.php/?all';?>">All Games</a></span></p>
<table><tr><th><strong>Date</strong></th><?php if (!isset($user) || $user == '') { echo '<th><strong>Photo</strong></th><th><strong>Username</th>'; } ?></strong></th><th><strong>Score</strong></th><th><strong>Action</strong></th></tr>

<?php
if (isset($user) && $user != '' ) {
    while($game = mysqli_fetch_object($user_games))
    {
        if ($game->league_play == 'true') {
            echo '<tr class="league">';
        } else {
            echo '<tr>';
        }
        $phpdate = strtotime($game->date);
        $game_date = date('n-j-Y', $phpdate);
        echo '<td>' . $game_date .'</td>';
        echo '<td>' . $game->score . '</td>';
        echo '<td><a href="' . DIR . '/view-game/?game=' . $game->game_id . '">View</a></td>';
        echo '</tr>';
    }
} else {
    while($game = mysqli_fetch_object($user_games))
    {
        if ($game->league_play == 'true') {
            echo '<tr class="league">';
        } else {
            echo '<tr>';
        }
        $phpdate = strtotime($game->date);
        $game_date = date('n-j-Y', $phpdate);
        echo '<td>' . $game_date .'</td>';
        echo '<td><img src="' . $game->avatar . '" style="max-height: 64px;" alt="' . $game->username . '" /></td>';
        $user_link = DIR . "/user-profile.php/?user=" . $game->member_id;
        echo '<td><a href="' . $user_link . '">' . $game->username .'</a></td>';
        echo '<td>' . $game->score . '</td>';
        echo '<td><a href="' . DIR . '/view-game.php/?game=' . $game->game_id . '">View</a></td>';
        echo '</tr>';
    }
}
?>


</table>
</div>

<?php
include('includes/footer.php');
