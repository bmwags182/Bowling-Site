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

if((isset($_SESSION['memberID']) && $_SESSION['memberID'] != '') && (isset($_POST['username']) && $_POST['username'] != 'all' ) && !isset($_GET['all']) && !isset($_GET['user']) ) {
    $user = $_SESSION['memberID'];
    $user_filter = "WHERE member_id = '$user'";
} elseif (isset($_GET['all'])) {
    $user_filter = "WHERE member_id != 0";
} elseif ((isset($_GET['user']) && $_GET['user'] != '' )) {
    $user = mysqli_real_escape_string($mysqli, $_GET['user']);
    $user_filter = "WHERE member_id = '$user'";
} elseif (isset($_POST['username'] ) && $_POST['username'] == 'all') {
    $username = mysqli_real_escape_string(db_connect(), $_POST['username']);
    $user_filter = "WHERE username LIKE '%%'";
} else {
    $user_filter = "WHERE member_id != 0";
}

if(isset($_POST['filter']) && $_POST['filter'] != '') {
    $filter_array = game_filter($_POST);
    $game_filter = $user_filter . ' AND ' . $filter_array;
}

if(isset($game_filter) && $game_filter != '') {
    $user_games_query = "SELECT games.date AS date, games.member_id AS member_id, games.score AS score, games.full_game AS full_game, games.league_play AS league_play, games.game_id AS game_id, members.memberID AS memberID, members.username AS username, user_data.avatar AS avatar FROM games INNER JOIN members ON games.member_id = members.memberID INNER JOIN user_data ON user_data.memberID = games.member_id " . $game_filter . " ORDER BY score DESC";
} else{
    $user_games_query = "SELECT games.date AS date, games.member_id AS member_id, games.score AS score, games.full_game AS full_game, games.league_play AS league_play, games.game_id AS game_id, members.memberID AS memberID, members.username AS username, user_data.avatar AS avatar FROM games INNER JOIN members ON games.member_id = members.memberID INNER JOIN user_data ON user_data.memberID = games.member_id " . $user_filter . " ORDER BY score DESC";
}


$user_games = mysqli_query(db_connect(), $user_games_query) or die("failed: " . mysqli_error(db_connect()));

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
if (isset($user) && $user != '') {
    ?>
<h2><?php echo $username."'s Games"; ?><span class="avg"><?php echo "Avg: " .$avg; ?></span></h2>
<?php
} else {
    ?>
    <h2>All Games</h2>
    <?php
}
messages();
?>
<div class="filter-form"><form method="post" action=""><p>Min Date: <input type="date" name="min-date" />&nbsp;&nbsp;Max Date: <input type="date" name="max-date" /></p>
<p>Min Score: <input type="number" name="min-score" />&nbsp;&nbsp;Max Score:<input type="number" name="max-score" /></p>
<?php /*
<p>Username: <select name="username">
<?php
$sql = "SELECT username FROM members WHERE memberID != 0";
$result = mysqli_query(db_connect(), $sql);
    echo '<option name="username" value="all">Everyone</option>';
while($row = mysqli_fetch_object($result)) {
    echo '<option name="username" value="' . $row->username . '" >' . $row->username . '</option>';
}
// */
?>
</select>
League Games: <input type="radio" name="league" value="1">Yes <input type="radio" name="league" value="0">No</p>
<input class="button" type="submit" name="filter" value="Filter Results" />
</form>
<p class="legend"><span style="background-color: #333; height: 16px, width: 16px; margin-left: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp; Shaded rows are league games<span class="all-games"><a class="button" href="<?php echo DIR.'/all-games.php/?all';?>">All Games</a></span></p>
<table><tr><th id="date"><strong>Date</strong></th><?php if (!isset($user) || $user == '') { echo '<th id="avatar"><strong>Photo</strong></th><th id="username"><strong>Username</th>'; } ?></strong></th><th id="score"><strong>Score</strong></th><th id="action"><strong>Action</strong></th></tr>

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
        echo '<td id="date">' . $game_date .'</td>';
        echo '<td id="score">' . $game->score . '</td>';
        echo '<td id="action"><a href="' . DIR . '/view-game/?game=' . $game->game_id . '">View</a></td>';
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
        echo '<td id="date">' . $game_date .'</td>';
        echo '<td id="avatar"><img src="' . $game->avatar . '" style="max-height: 64px;" alt="' . $game->username . '" /></td>';
        $user_link = DIR . "/user-profile.php/?user=" . $game->member_id;
        echo '<td id="username"><a href="' . $user_link . '">' . $game->username .'</a></td>';
        echo '<td id="score">' . $game->score . '</td>';
        echo '<td id="action"><a href="' . DIR . '/view-game.php/?game=' . $game->game_id . '">View</a></td>';
        echo '</tr>';
    }
}
?>


</table>
</div>

<?php
include('includes/footer.php');
