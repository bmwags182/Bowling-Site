<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Registration Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

 require('../includes/config.php');
if(logged_in()) {header('Location: '.DIRADMIN);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo SITETITLE;?></title>
<link rel="stylesheet" href="<?php echo DIR;?>style/login.css" type="text/css" />
<link href="<?php echo DIR;?>/style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo DIR;?>/style/starter.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=0, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Anton|Domine|Montserrat|Titillium+Web" rel="stylesheet">
</head>
<body>
<div class="lwidth">
    <div class="page-wrap">
        <div class="content">

        <?php
        if(isset($_POST['register'])) {
            register_user($_POST['email'], $_POST['username'], $_POST['password'], $_POST['confirm_password']);
        }
        ?>

<div id="register">
    <p><?php messages();?></p>
    <form method="post" action="">
    <p><label><strong>Email</strong><input type="text" name="email" /></label></p>
    <p><label><strong>Username</strong><input type="text" name="username" /></label></p>
    <p><label><strong>Password</strong><input type="password" name="password" /></label></p>
    <p><label><strong>Confirm Password</strong><input type="password" name="confirm_password" /></label></p>
    <p><br /><br/><input type="submit" name="register" class="button" value="register" /><a href="<?php echo DIRADMIN;?>login.php">Already Registered?</a></p>
    </form>
</div>

        </div>
        <div class="clear"></div>
    </div>
<div class="footer">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div>
</body>
</html>
