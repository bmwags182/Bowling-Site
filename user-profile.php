<?php
/*-------------------------------------------------------+
| Bowling Statistics
| User Profile Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

require('includes/config.php');
include('includes/header.php');

if(isset($_SESSION['memberID'])) {
    $memberID = $_SESSION['memberID'];
}

if ((!isset($_GET['user']) || $_GET['user'] == '') && !isset($memberID)) {
    $_SESSION['error'] = "No user selected.";
    header("Location: " . DIR);
} elseif (isset($_GET['user']) && $_GET['user'] != '') {
    $memberID = $_GET['user'];
}

$user_data_query = "SELECT
                    members.username AS username, --
                    members.memberID AS memberID,
                    user_data.admin AS admin, --
                    user_data.first_name AS fname, --
                    user_data.last_name AS lname, --
                    user_data.email AS email, --
                    user_data.birthday AS birthday, --
                    user_data.join_date AS join_date, --
                    user_data.avatar AS avatar, --
                    user_data.location AS location, --
                    user_data.quote AS quote, --
                    user_data.about_me AS about_me
                    FROM members INNER JOIN user_data ON members.memberID = user_data.memberID
                    WHERE user_data.memberID = '$memberID'";

$result = mysqli_query(db_connect(), $user_data_query) or die("Query Error ". mysqli_error(db_connect()));
if ($result == true) {
    $member = mysqli_fetch_object($result);
}

$phpdate = strtotime($member->birthday);
$birthday = date('n-j-Y', $phpdate);

$phpdate = strtotime($member->join_date);
$join_date = date('n-j-Y', $phpdate);
?>

<div id="content">
<h1><?php echo $member->username;?>'s Profile</h1>
<div class="profile-photo"><img src="<?php echo $member->avatar;?>" alt="<?php echo $member->username;?>" <?php if($member->admin == 1) { echo 'id="admin"';}?> />
<p id="quote"><?php echo $member->quote;?></p></div>
<div class="main-info"><h3><?php echo $member->fname . " " . $member->lname; if($member->admin == 1) { echo "  - ADMIN";}?></h3><p class="bbutton" id="view-games"><a href="<?php echo DIR . '/all-games.php/?user=' . $member->memberID; ?>" title="<?php echo $member->username;?>'s games" >View Games</a></p>
<p>Email: <a href="mailto:<?php echo $member->email;?>" rel="nofollow"><?php echo $member->email ?></a> &nbsp;&nbsp; Location: <?php echo $member->location; ?></p>
<p>Birthday: <?php echo $birthday; ?> &nbsp; &nbsp; Join Date: <?php echo $join_date; ?></p>
</div>
<div class="bio">
<h3>About Me</h3>
<p><?php echo $member->about_me; ?></p>
</div>
</div>

<?php
include('includes/footer.php');
