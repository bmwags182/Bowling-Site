<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Home Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

require('includes/config.php');
include('includes/header.php');
 ?>

	<div id="content">

	<?php
	//if no page clicked on load home page default to it of 1
	if(!isset($_GET['p'])){
		$q = mysqli_query(db_connect(), "SELECT * FROM pages WHERE page_id='1'");
	} else { //load requested page based on the id
		$id = $_GET['p']; //get the requested id
		$id = mysqli_real_escape_string(db_connect(), $id); //make it safe for database use
		$q = mysqli_query(db_connect(), "SELECT * FROM pages WHERE page_title='$id'");
	}

	//get page data from database and create an object
	$r = mysqli_fetch_object($q);

	//print the pages content
	echo "<h1>$r->page_title</h2>";
	echo $r->page_content;
	?>

	</div><!-- close content div -->

<?php
include('includes/footer.php');
