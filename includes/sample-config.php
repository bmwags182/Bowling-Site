<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Sample Configuration File
| You will need to edit this file to your needs, see the comments on each of the lines below
| Once you have changed what you need to, save the file as config.php and you should be on your way
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

ob_start();
session_start();
// db properties
define('DBHOST', /* ENTER DB HOST HERE */);
define('DBUSER', /* ENTER DB USERNAME HERE */);
define('DBPASS', /* ENTER DB PASSWORD HERE */);
define('DBNAME', /* ENTER DB NAME HERE */);

// make a connection to mysql here
$conn = @mysql_connect (DBHOST, DBUSER, DBPASS);
$conn = @mysql_select_db (DBNAME);
if(!$conn){
	die( "Sorry! There seems to be a problem connecting to our database.");
}

// define site path
define('DIR', /* ENTER YOUR HOME PAGE HERE */;

// define admin site path
define('DIRADMIN', /* ENTER ADDRESS OF YOUR ADMIN PANEL, USUALLY /admin */);

// define site title for top of the browser
define('SITETITLE', /* TITLE FOR YOUR SITE */);

//define include checker
define('included', 1);

include('functions.php');
?>
