<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Functions File
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

if (!defined('included')){
die('You cannot access this file directly!');
}

//log user in ---------------------------------------------------
function login($user, $pass){
    $mysqli = db_connect();
   //strip all tags from varible
    $user = strip_tags(mysqli_real_escape_string(db_connect(),$user));
    $pass = strip_tags(mysqli_real_escape_string(db_connect(),$pass));

    $pass = md5($pass);

    // check if the user id and password combination exist in database
    $sql = "SELECT * FROM members WHERE username = '$user' AND password = '$pass'";
    $result = mysqli_query($mysqli, $sql) or die('Query failed. ' . mysqli_error($mysqli));
    $result_array = mysqli_fetch_array($result);


    if (mysqli_num_rows($result) == 1) {
        // the username and password match,
        // set the session
	    $_SESSION['authorized'] = true;
        $_SESSION['memberID'] = $result_array['memberID'];

	    // direct to admin
        header('Location: '.DIRADMIN );
	    exit();
    } else {
	    // define an error message
	    $_SESSION['error'] = 'Sorry, wrong username or password';
    }
}

// Authentication
function logged_in() {
	if(isset($_SESSION['authorized']) && $_SESSION['authorized'] == true) {
		return true;
	} else {
		return false;
	}
}

function login_required() {
	if(logged_in()) {
		return true;
	} else {
		header('Location: '.DIRADMIN.'login.php');
		exit();
	}
}

function logout(){
	unset($_SESSION['authorized']);
    unset($_SESSION['memberID']);
	header('Location: '.DIRADMIN.'login.php');
	exit();
}

function register_user($username, $password, $confirm) {
    $user = strip_tags(mysqli_real_escape_string(db_connect(),$username));
    $mysqli = db_connect();
    $sql = "SELECT * FROM `members` WHERE `username` = '$user'";
    $r = mysqli_query($mysqli, $sql);
    if(mysqli_num_rows($r) > 0) {
        $_SESSION['error'] = 'Username Already Exists';
    } else {
        if ($password != $confirm ) {
            $_SESSION['error'] = "Passwords Do Not Match";
        } else {
            $password = strip_tags(mysqli_real_escape_string($mysqli, $password));
            $password = md5($password);

            $sql = "INSERT INTO `members` (username, password) VALUES ('$username', '$password')";
            $result = mysqli_query($mysqli, $sql);
            if ($result != true) {
                $_SESSION['error'] = "Unable to insert user into members table";
            } else {
                $last_user_query = "SELECT memberID FROM members WHERE memberID = ( SELECT max(memberID) FROM members)";
                $last_user_data = mysqli_query($mysqli, $last_user_query);
                $last_user_data = mysqli_fetch_array($last_user_data);
                $last_user = $last_user_data['memberID'];
                $_SESSION['info'] = $last_user;
                $user_data_query = "INSERT INTO user_data (admin, memberID, join_date) VALUES (0, '$last_user', CURDATE())";
                $result = mysqli_query($mysqli, $user_data_query) or die("Registration failure " . mysqli_error($mysqli));
                if ($result == true) {
                    $_SESSION['success'] = "Registration Successful";
                } else {
                    $_SESSION['error'] = "Unable to update user data";

                }
            }
        }
    }


}

// Render error messages
function messages() {
    if(isset($_SESSION['success']) && $_SESSION['success'] != '') {
        $message_success = '<div class="msg-ok"><p id="success" class="message">'.$_SESSION['success'].'</p></div>';
        echo "$message_success";
    }
    if(isset($_SESSION['attention']) && $_SESSION['attention'] != '') {
        $message_attention = '<div class="msg-atten"><p id="attention" class="message">'.$_SESSION['attention'].'</p></div>';
        echo "$message_attention";
    }
    if(isset($_SESSION['error']) && $_SESSION['error'] != '') {
        $message_error = '<div class="msg-error"><p id="error" class="message">'.$_SESSION['error'].'</p></div>';
        echo "$message_error";
    }
    if (isset($_SESSION['info']) && $_SESSION['info'] != '') {
        $message_info = '<div class="msg-info"><p id="info" class="message">'.$_SESSION['info'].'</p></div>';
        echo "$message_info";
    }
    $_SESSION['success'] = '';
    $_SESSION['attention'] = '';
    $_SESSION['error'] = '';
    $_SESSION['info'] = '';

}

function errors($error){
	if (!empty($error))
	{
			$i = 0;
			while ($i < count($error)){
			$showError.= "<div class=\"msg-error\">".$error[$i]."</div>";
			$i ++;}
			echo $showError;
	}// close if empty errors
} // close function

function db_connect() {
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    return $mysqli;
}

function get_frames($form_data) {
    if (isset($form_data['full_game'])) {
        $frames = array(
            'frame1a'  => $form_data['frame1a'],
            'frame1b'  => $form_data['frame1b'],
            'frame2a'  => $form_data['frame2a'],
            'frame2b'  => $form_data['frame2b'],
            'frame3a'  => $form_data['frame3a'],
            'frame3b'  => $form_data['frame3b'],
            'frame4a'  => $form_data['frame4a'],
            'frame4b'  => $form_data['frame4b'],
            'frame5a'  => $form_data['frame5a'],
            'frame5b'  => $form_data['frame5b'],
            'frame6a'  => $form_data['frame6a'],
            'frame6b'  => $form_data['frame6b'],
            'frame7a'  => $form_data['frame7a'],
            'frame7b'  => $form_data['frame7b'],
            'frame8a'  => $form_data['frame8a'],
            'frame8b'  => $form_data['frame8b'],
            'frame9a'  => $form_data['frame9a'],
            'frame9b'  => $form_data['frame9b'],
            'frame10a' => $form_data['frame10a'],
            'frame10b' => $form_data['frame10b'],
            'frame10c' => $form_data['frame10c'],
        );
        $frames = json_encode($frames);
        return $frames;
    } else {
        $_SESSION['error'] = 'Full game frames not submitted';
    }
}

function check_authorized_game($gameID, $memberID) {
    $gameID = strip_tags(mysqli_real_escape_string(db_connect(), $gameID));
    $memberID = strip_tags(mysqli_real_escape_string(db_connect(), $memberID));

    $sql = "SELECT * FROM `games` WHERE `game_id` = '$gameID'";
    $result = mysqli_query(db_connect(), $sql);
    $result_array = mysqli_fetch_array($result);

    if($result_array['member_id'] != $_SESSION['memberID']) {
        $_SESSION['error'] = "That's not yours to edit.";
        header("Location: " .DIRADMIN);
        exit();
    }
}

function check_authorized_page($pageID, $memberID) {
    $pageID = strip_tags(mysqli_real_escape_string(db_connect(), $pageID));
    $memberID = strip_tags(mysqli_real_escape_string(db_connect(), $memberID));

    $sql = "SELECT * FROM `pages` WHERE `page_id` = '$pageID'";
    $result = mysqli_query(db_connect(), $sql);
    $result_array = mysqli_fetch_array($result);

    if($result_array['author'] != $_SESSION['memberID']) {
        $_SESSION['error'] = "That's not yours to edit.";
        header("Location: " .DIRADMIN);
        exit();
    }
}

