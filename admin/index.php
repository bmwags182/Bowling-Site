<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Admin Panel
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

require('../includes/config.php');

//make sure user is logged in, function will redirect use if not logged in
login_required();

include('../includes/admin-header.php');

//if logout has been clicked run the logout function which will destroy any active sessions and redirect to the login page
if(isset($_GET['logout'])){
	logout();
}

//run if a page deletion has been requested
if(isset($_GET['delgame'])){

	$delgame = $_GET['delgame'];
	$delgame = mysqli_real_escape_string(db_connect(), $delgame);
	$sql = mysqli_query(db_connect(), "DELETE FROM games WHERE game_id = '$delgame'");
    $_SESSION['success'] = "Game Deleted";
    header('Location: ' .DIRADMIN);
   	exit();
}

if(isset($_GET['delpage'])) {
	$delpage = $_GET['delpage'];
	$delpage = mysqli_real_escape_string(db_connect(), $delpage);
	$sql = mysqli_query(db_connect(), "DELETE FROM `pages` WHERE `page_id` = '$delpage'");
	$_SESSION['success'] = "Page Deleted";
}

?>

<div id="content">

<h2>Manage Games</h2>

<?php
	//show any messages if there are any.
	messages();
?>

<table>
<tr>
	<th><strong>Date</strong></th>
	<th><strong>League</strong></th>
	<th><strong>Frame Data</strong></th>
	<th><strong>Score</strong></th>
	<th><strong>Action</strong></th>
</tr>

<?php
if (isset($_SESSION['memberID'])) {
	$memberID = $_SESSION['memberID'];
}

$sql = mysqli_query(db_connect(), "SELECT * FROM games WHERE `member_id` = '$memberID' ORDER BY `date`");
while($row = mysqli_fetch_object($sql))
{
	echo "<tr>";
		echo "<td>$row->date</td>";
		if ($row->league_play == 'true') {
			echo "<td>Yes</td>";
		} elseif ($row->league_play == 'false' ) {
			echo "<td>No</td>";
		} else {
			echo "<td>Error</td>";
		}
		if($row->full_game == 'true') {
			echo "<td>Yes</td>";
		} elseif($row->full_game == 'false') {
			echo "<td>No</td>";
		} else {
			echo "<td>Error</td>";
		}
		echo "<td>$row->score</td>";
		echo "<td><a href=\"".DIRADMIN."editgame.php?id=$row->game_id\">Edit</a> | <a href=\"javascript:delgame('$row->game_id','$row->date');\">Delete</a></td>";


	echo "</tr>";
}
?>
</table>
<p><a href="<?php echo DIRADMIN;?>addgame.php/" class="button">Add Game</a></p>
<?php
if ($_SESSION['memberID'] == 1 ) {
?>
	<h2>Manage Pages</h2>

	<table>
	<tr>
		<th><strong>Title</strong></th>
		<th><strong>Action</strong></th>
	</tr>

	<?php

	$sql = mysqli_query(db_connect(), "SELECT * FROM pages WHERE `author` = '$memberID' ORDER BY page_id");
	while($row = mysqli_fetch_object($sql))
	{
		echo "<tr>";
			echo "<td>$row->page_title</td>";
			if($row->page_id == 1){ //home page hide the delete link
				echo "<td><a href=\"".DIRADMIN."editpage.php?id=$row->page_id\">Edit</a></td>";
			} else {
				echo "<td><a href=\"".DIRADMIN."editpage.php?id=$row->page_id\">Edit</a> | <a href=\"javascript:delpage('$row->page_id','$row->page_title');\">Delete</a></td>";
			}

		echo "</tr>";
	}
	?>
	</table>
	<p><a href="<?php echo DIRADMIN;?>addpage.php/?<?php echo $_SESSION['memberID']?>" class="button">Add Page</a></p>
<?php
}
?>


</div>


<?php
include('../includes/admin-footer.php');
