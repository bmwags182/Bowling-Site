<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Admin Header File
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php
if(isset($page['title']) && $page['title'] != '' ) {
    echo $page['title'];
} else {
    echo SITETITLE;
}
?></title>
<link href="<?php echo DIR;?>/style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo DIR;?>/style/starter.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=0, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Anton|Domine|Montserrat|Titillium+Web" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
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
        <li><a href="<?php echo DIRADMIN . "/editprofile.php";?>">Edit Profile</a></li>
        <li><a href="<?php echo DIRADMIN;?>?logout">Logout</a></li>
    </ul>
</div>
<!-- END NAV -->
