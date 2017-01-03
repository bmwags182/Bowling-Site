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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITETITLE;?></title>
<link href="<?php echo DIR;?>/style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo DIR;?>/style/starter.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=0, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Anton|Domine|Montserrat|Titillium+Web" rel="stylesheet">
<script language="JavaScript" type="text/javascript">
	function delpage(id, title)
	{
	   if (confirm("Are you sure you want to delete '" + title + "'"))
	   {
		  window.location.href = '<?php echo DIRADMIN;?>?delpage=' + id;
	   }
	}

	function delgame(id, date)
	{
	   if (confirm("Are you sure you want to delete '" + date + "'"))
	   {
		  window.location.href = '<?php echo DIRADMIN;?>?delgame=' + id;
	   }
	}
</script>
</head>
<body>

<div id="wrapper">

<div id="logo"><a href="<?php echo DIRADMIN;?>"><img src="images/logo.png" alt="<?php echo SITETITLE;?>" border="0" /></a></div>

<!-- NAV -->
<div id="navigation">
	<ul class="menu">
		<li><a href="<?php echo DIRADMIN;?>">Admin</a></li>
		<li><a href="<?php echo DIR . "/all-games.php/";?>" target="_blank">My Games</a></li>
		<li><a href="<?php echo DIRADMIN;?>?logout">Logout</a></li>
	</ul>
</div>
<!-- END NAV -->
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

<div id="footer">
		<div class="copy">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div><!-- close footer -->
</div><!-- close wrapper -->

</body>
</html>
