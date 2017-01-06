<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Header File
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

if(isset($_SESSION['memberID'])) {
    $memberID = $_SESSION['memberID'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if (isset($page_title) && $page_title != '') {
    echo '<title>'. $page_title .'</title>';
} else {
    echo '<title>'. SITETITLE .'</title>';
}
?>

    <link href="<?php echo DIR;?>/style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo DIR;?>/style/starter.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=0, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Anton|Domine|Montserrat|Titillium+Web" rel="stylesheet">

</head>
<body>
<div id="wrapper">
<p style="text-align:center; display:inline"><a href="<?php echo DIR;?>" class="logo"><img src="images/logo.png" alt="<?php echo SITETITLE;?>" title="<?php echo SITETITLE;?>" border="0" /></a></p><!-- close logo -->
<!-- NAV -->
    <div id="navigation">
    <div class="menu">
    <a href="<?php echo DIR;?>">Home</a>
    <a href="<?php echo DIR . '/all-games.php/'; ?>">View Games</a>

    <?php if(isset($_SESSION['authorized'])) { ?><a href="<?php echo DIR . "/user-profile.php"; ?>">Profile</a><?php } else { ?><a href="<?php echo DIRADMIN;?>">Login</a><?php } ?>
        </div>
    </div>
    <!-- END NAV -->

