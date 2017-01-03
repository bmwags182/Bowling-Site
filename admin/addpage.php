<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Add New Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/
require('../includes/config.php');

if(isset($_POST['submit'])){

	$title = $_POST['page_title'];
	$content = $_POST['page_content'];

	$title = mysqli_real_escape_string(db_connect(), $title);
	$content = mysqli_real_escape_string(db_connect(), $content);
	$author = mysqli_real_escape_string(db_connect(), $_SESSION['memberID']);

	mysqli_query(db_connect(), "INSERT INTO pages (page_title,page_content,author) VALUES ('$title','$content', '$author')")or die(mysqli_error());
	$_SESSION['success'] = 'Page Added';
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
<link href="https://fonts.googleapis.com/css?family=Anton|Domine|Montserrat|Titillium+Web" rel="stylesheet"></head>
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

<h1>Add Page</h1>

<form action="" method="post">
<p>Title:<br /> <input name="page_title" type="text" value="" size="103" /></p>
<p>content<br /><textarea name="page_content" cols="100" rows="20"></textarea></p>
<p><input type="submit" name="submit" value="Submit" class="button" /></p>
</form>

</div>

<div id="footer">
		<div class="copy">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div><!-- close footer -->
</div><!-- close wrapper -->

</body>
</html>
