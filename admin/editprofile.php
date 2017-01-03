<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Edit Profile Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

require('../includes/config.php');

$mysqli = db_connect();

if (!isset($_SESSION['memberID']) || $_SESSION['memberID'] == '') {
    header("Location: " . DIRADMIN);
}

if(isset($_POST['submit'])){
    $memberID = $_SESSION['memberID'];

    if (isset($_POST['old-password']) && $_POST['old-password'] != '' && isset($_POST['new-password']) && $_POST['new-password'] != '' && isset($_POST['confirm-password']) && $_POST['confirm-password'] != '' ) {
        $oldpass = $_POST['old-password'];
        $newpass = $_POST['new-password'];
        $confirm = $_POST['confirm-password'];
        if ($newpass == $confirm) {
            change_password($memberID, $oldpass, $newpass);
        } else {
            $_SESSION['error'] = "New passwords do not match.";
        }
    }

    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $fname = mysqli_real_escape_string($mysqli, $_POST['fname']);
    $lname = mysqli_real_escape_string($mysqli, $_POST['lname']);
    $birthday = mysqli_real_escape_string($mysqli, $_POST['birthday']);
    $location = mysqli_real_escape_string($mysqli, $_POST['location']);
    $quote = mysqli_real_escape_string($mysqli, $_POST['quote']);
    $bio = mysqli_real_escape_string($mysqli, $_POST['bio']);

    $result = mysqli_query($mysqli, "UPDATE user_data SET email='$email', first_name='$fname', last_name='$lname', birthday='$birthday', location='$location', quote='$quote', about_me='$bio' WHERE memberID='$memberID'");
    if ($result == true) {
        $_SESSION['success'] = 'Profile Updated';
        header('Location: '.DIRADMIN);
        exit();
    } else {
        $_SESSION['error'] = 'Profile Update Failed' . mysqli_error($mysqli);
        header('Location: ' . DIRADMIN );
        exit();
    }
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

<h1>Edit Profile</h1>

<?php


$id = $_SESSION['memberID'];
$id = mysqli_real_escape_string($mysqli, $id);
$user_profile_query =   "SELECT members.username AS username,
                              user_data.admin AS is_admin,
                              user_data.first_name AS fname,
                              user_data.last_name AS lname,
                              user_data.email AS email,
                              user_data.birthday AS birthday,
                              user_data.join_date AS join_date,
                              user_data.avatar AS avatar,
                              user_data.location AS location,
                              user_data.quote AS quote,
                              user_data.about_me AS bio
                        FROM members INNER JOIN user_data ON members.memberID = user_data.memberID
                        WHERE user_data.memberID = '$id'";
$q = mysqli_query($mysqli,$user_profile_query) or die("Getting user profile failed" . mysqli_error($mysqli));
$row = mysqli_fetch_object($q);
?>

<!-- PUT FORM BELOW THIS -->

<form method="post" action="" >
<?php if ($row->avatar != '') {?>
<img src="<?php echo $row->avatar;?>" alt="Profile Image" />
<?php } ?>
<!-- User Photo upload will go here near the top -->
<p>Username:<br /> <input name="username" type="text" value="<?php echo $row->username;?>" size="103" disabled />
</p>
<p>Email:<br /><input type="text" name="email" value="<?php if($row->email != '') { echo $row->email; } ?>" />
</p>
<p>First Name:<br /><input type="text" name="fname" value="<?php if($row->fname != '') { echo $row->fname; } ?>" />
</p>
<p>Last Name:<br /><input type="text" name="lname" value="<?php if($row->lname != '') { echo $row->lname; } ?>" />
</p>
<p>Birthday:<br /><input type="date" name="birthday" value="<?php if($row->birthday != '' ) { echo $row->birthday; } ?>" />
</p>
<p>Location:<br /><input type="text" name="location" value="<?php if($row->location != '' ) { echo $row->location; } ?>" />
</p>
<p>Current Password:<br /><input type="password" name="old-password" />
</p>
<p>New Password:<br /><input type="password" name="new-password" />
</p>
<p>Confirm New Password:<br /><input type="password" name="confirm-password" />
</p>
<p>Quote:<br /><input type="text" name="quote" value="<?php if($row->quote != '' ) { echo $row->quote; } ?>" />
</p>
<p>About Me:<br /><textarea name="bio" cols="100" rows="20"><?php if($row->bio != '') { echo $row->bio;} ?></textarea>
<p><input type="submit" name="submit" value="Submit" class="button" /></p>
</form>

<!-- PUT FORM ABOVE THIS -->

</div>

<div id="footer">
        <div class="copy">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div><!-- close footer -->
</div><!-- close wrapper -->

</body>
</html>
