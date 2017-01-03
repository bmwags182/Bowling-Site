<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Add New Game Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/
require('../includes/config.php');

if(isset($_POST['submit'])){

	$date = strip_tags(mysqli_real_escape_string(db_connect(), $_POST['date']));
	$league_play = strip_tags(mysqli_real_escape_string(db_connect(),$_POST['league_play']));
	$memberID = strip_tags(mysqli_real_escape_string(db_connect(),$_SESSION['memberID']));
	if (isset($_POST['full_game'])) {
		$frames = get_frames($_POST);
		$full_game = mysqli_real_escape_string(db_connect(), $_POST['full_game']);
	} else {
		$frames = '';
		$full_game = mysqli_real_escape_string(db_connect(), 'false');
	}
	$score = strip_tags(mysqli_real_escape_string(db_connect(), $_POST['score']));

	mysqli_query(db_connect(), "INSERT INTO games (member_id,date,league_play,full_game,frames,score) VALUES ('$memberID','$date','$league_play', '$full_game', '$frames','$score')")or die(mysqli_error());
	$_SESSION['success'] = 'Game Added';
	header('Location: '.DIRADMIN);
	exit();

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
</head>
<body>
<div id="wrapper">

<div id="logo"><a href="<?php echo DIR;?>"><img src="images/logo.png" alt="<?php echo SITETITLE;?>" title="<?php echo SITETITLE;?>" border="0" /></a></div><!-- close logo -->

<!-- NAV -->
<div id="navigation">
<ul class="menu">
<li><a href="<?php echo DIRADMIN;?>">Admin</a></li>
<li><a href="<?php echo DIR;?>" target="_blank">My Games</a></li>
<li><a href="<?php echo DIRADMIN;?>?logout">Logout</a></li>
</ul>
</div>
<!-- END NAV -->

<div id="content">

<h1>Add Game</h1>

<form action="" method="post">
<p>Date:<br /> <input name="date" type="date" value="<?php echo date('m-d-Y'); ?>" placeholder="<?php echo date('m-d-Y'); ?>" size="103" /></p>
<p>League Play:<input name="league_play" type="radio" value="true" />Yes<input type="radio" name="league_play" value="false" />No</p>
<p>Score:<br/><input type="number" name="score"/><br />
<p>Enter all Frames?<input name="full_game" type="radio" value="true" />Yes<input type="radio" name="full_game" value="false" />No</p>
<p>Frame 1:<input type="text" name="frame1a" style="width: 20px;" /><input type="text" name="frame1b" style="width: 20px;" /></p>
<p>Frame 2:<input type="text" name="frame2a" style="width: 20px;"/><input type="text" name="frame2b" style="width: 20px;"/></p>
<p>Frame 3:<input type="text" name="frame3a" style="width: 20px;"/><input type="text" name="frame3b" style="width: 20px;"/></p>
<p>Frame 4:<input type="text" name="frame4a" style="width: 20px;"/><input type="text" name="frame4b" style="width: 20px;"/></p>
<p>Frame 5:<input type="text" name="frame5a" style="width: 20px;"/><input type="text" name="frame5b" style="width: 20px;"/></p>
<p>Frame 6:<input type="text" name="frame6a" style="width: 20px;"/><input type="text" name="frame6b" style="width: 20px;"/></p>
<p>Frame 7:<input type="text" name="frame7a" style="width: 20px;"/><input type="text" name="frame7b" style="width: 20px;"/></p>
<p>Frame 8:<input type="text" name="frame8a" style="width: 20px;"/><input type="text" name="frame8b" style="width: 20px;"/></p>
<p>Frame 9:<input type="text" name="frame9a" style="width: 20px;"/><input type="text" name="frame9b" style="width: 20px;"/></p>
<p>Frame 10:<input type="text" name="frame10a" style="width: 20px;"/><input type="text" name="frame10b" style="width: 20px;"/><input type="text" name="frame10c" style="width: 20px;"/></p>

<p><input type="submit" name="submit" value="Submit" class="button" /></p>
</form>

</div>

<div id="footer">
		<div class="copy">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div><!-- close footer -->
</div><!-- close wrapper -->

</body>
</html>
