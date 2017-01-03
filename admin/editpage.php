<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Edit Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

require('../includes/config.php');

if(!isset($_GET['id']) || $_GET['id'] == ''){ //if no id is passed to this page take user back to previous page
	header('Location: '.DIRADMIN);
}

check_authorized_page($_GET['id'], $_SESSION['memberID']);

if(isset($_POST['submit'])){

	$title = $_POST['page_title'];
	$content = $_POST['page_content'];
	$page_id = $_POST['page_id'];

	$title = mysqli_real_escape_string(db_connect(), $title);
	$content = mysqli_real_escape_string(db_connect(), $content);

	mysqli_query(db_connect(), "UPDATE pages SET page_title='$title', page_content='$content' WHERE page_id='$page_id'");
	$_SESSION['success'] = 'Page Updated';
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

<h1>Edit Page</h1>

<?php
$id = $_GET['id'];
$id = mysqli_real_escape_string(db_connect(), $id);
$q = mysqli_query(db_connect(), "SELECT * FROM pages WHERE page_id='$id'");
$row = mysqli_fetch_object($q);
?>


<form action="" method="post">
<input type="hidden" name="page_id" value="<?php echo $row->page_id;?>" />
<p>Title:<br /> <input name="page_title" type="text" value="<?php echo $row->page_title;?>" size="103" />
</p>
<p>content<br /><textarea name="page_content" cols="100" rows="20"><?php echo $row->page_content;?></textarea>
</p>
<p><input type="submit" name="submit" value="Submit" class="button" /></p>
</form>

</div>

<div id="footer">
		<div class="copy">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div><!-- close footer -->
</div><!-- close wrapper -->

</body>
</html>
