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
    $user = strip_tags(mysqli_real_escape_string($mysqli,$user));
    $pass = strip_tags(mysqli_real_escape_string($mysqli,$pass));

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

// Checks logged in status on admin pages.
function login_required() {
	if(logged_in()) {
		return true;
	} else {
		header('Location: '.DIRADMIN.'login.php');
		exit();
	}
}


// Log user out
function logout(){
	unset($_SESSION['authorized']);
    unset($_SESSION['memberID']);
	header('Location: '.DIRADMIN.'login.php');
	exit();
}

// Registers new user and creates their data in the user_data table as well
// Gets values for $username, $password, and $confirm from registration form $_POST
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
                // Insert new user into members failed
                $_SESSION['error'] = "Unable to insert user into members table";
            } else {
                // New user created, now create user_data
                $last_user_query = "SELECT memberID FROM members WHERE memberID = ( SELECT max(memberID) FROM members)";
                $last_user_data = mysqli_query($mysqli, $last_user_query);
                $last_user_data = mysqli_fetch_array($last_user_data);
                $last_user = $last_user_data['memberID'];
                $user_data_query = "INSERT INTO user_data (admin, memberID, join_date) VALUES (0, '$last_user', CURDATE())";
                $result = mysqli_query($mysqli, $user_data_query) or die("Registration failure " . mysqli_error($mysqli));
                if ($result == true) {
                    // User data stored
                    $_SESSION['success'] = "Registration Successful";
                } else {
                    // Unable to store user data
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
        foreach ($_SESSION['info'] as $message) {
            if (is_array($message) == true) {
                foreach($message as $key => $info) {
                    if (is_array($info) == true) {
                        foreach ($info as $key => $test) {
                            $message_info = '<div class="msg-info"><p id="info" class="message">'.$key.' => '.$test.'</p></div>';
                            echo "$message_info";

                        }
                    } else {
                        $message_info = '<div class="msg-info"><p id="info" class="message">'.$key.' => '.$info.'</p></div>';
                        echo "$message_info";
                    }
                }
            } else {
                $message_info = '<div class="msg-info"><p id="info" class="message">'.$message.'</p></div>';
                echo "$message_info";
            }
        }
    }
    $_SESSION['success'] = '';
    $_SESSION['attention'] = '';
    $_SESSION['error'] = '';
    $_SESSION['info'] = '';

}

function errors($error){
	if (!empty($error)) {
			$i = 0;
		    while ($i < count($error)) {
			    $showError.= "<div class=\"msg-error\">".$error[$i]."</div>";
			    $i++;
            }
		echo $showError;
	}
}

// Connect to database from config file
function db_connect() {
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    return $mysqli;
}

function get_frames($form_data) {
    if (isset($form_data['full_game'])) {
        $frames = array(
            'frame1a'  => $form_data['frame1a'],
            'frame1b'  => $form_data['frame1b'],
            'frame1'   => $form_data['frame1'],
            'frame2a'  => $form_data['frame2a'],
            'frame2b'  => $form_data['frame2b'],
            'frame2'   => $form_data['frame2'],
            'frame3a'  => $form_data['frame3a'],
            'frame3b'  => $form_data['frame3b'],
            'frame3'   => $form_data['frame3'],
            'frame4a'  => $form_data['frame4a'],
            'frame4b'  => $form_data['frame4b'],
            'frame4'   => $form_data['frame4'],
            'frame5a'  => $form_data['frame5a'],
            'frame5b'  => $form_data['frame5b'],
            'frame5'   => $form_data['frame5'],
            'frame6a'  => $form_data['frame6a'],
            'frame6b'  => $form_data['frame6b'],
            'frame6'   => $form_data['frame6'],
            'frame7a'  => $form_data['frame7a'],
            'frame7b'  => $form_data['frame7b'],
            'frame7'   => $form_data['frame7'],
            'frame8a'  => $form_data['frame8a'],
            'frame8b'  => $form_data['frame8b'],
            'frame8'   => $form_data['frame8'],
            'frame9a'  => $form_data['frame9a'],
            'frame9b'  => $form_data['frame9b'],
            'frame9'   => $form_data['frame9'],
            'frame10a' => $form_data['frame10a'],
            'frame10b' => $form_data['frame10b'],
            'frame10c' => $form_data['frame10c'],
            'frame10'   => $form_data['frame10'],
        );
        $frames = json_encode($frames);
        return $frames;
    } else {
        $_SESSION['error'] = 'Full game frames not submitted';
    }
}


// Check if user is authorized to edit game
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


// Checkk if user is authorized to edit page
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

// Check if user is trying to edit their own profile
function check_authorized_profile($userID, $memberID) {
    $userID = strip_tags(mysqli_real_escape_string(db_connect(), $userID));
    $memberID = strip_tags(mysqli_real_escape_string(db_connect(), $memberID));

    $sql = "SELECT * FROM `user_data` WHERE `memberID` = '$userID'";
    $result = mysqli_query(db_connect(), $sql);
    $result_array = mysqli_fetch_array($result);

    if($result_array['memberID'] != $_SESSION['memberID']) {
        $_SESSION['error'] = "That's not your profile.";
        header("Location: " .DIRADMIN);
        exit();
    }
}


// Change user password
function change_password($memberID, $oldpass, $newpass) {
    $mysqli = db_connect();
    // Get user from members
    $memberID = strip_tags(mysqli_real_escape_string($mysqli, $memberID));
    $oldpass = strip_tags(mysqli_real_escape_string($mysqli, $oldpass));
    $nespass = strip_tags(mysqli_real_escape_string($mysqli, $newpass));

    $member_query = "SELECT * FROM members WHERE memberID = '$memberID'";
    $result = mysqli_query($mysqli, $member_query);
    $member = mysqli_fetch_object($result) or die("Error getting member from members table" . mysqli_error($mysqli));
    // $member = mysqli_fetch_object(mysqli_query(db_connect(), $member_query));

    $oldpass = md5($oldpass);
    $newpass = md5($newpass);
    if ($oldpass == $member->password) {
        $update_password_query = "UPDATE members SET password = '$newpass'";
        mysqli_query($mysqli, $update_password_query);
        $_SESSION['info'] = mysqli_error($mysqli);
    } else {
        $_SESSION['error'] = "Current password does not match.";
    }
}


function game_filter($filter_array) {
    $game_filter = array();

    if(isset($_POST['league']) && $_POST['league'] != '') {
        if($_POST['league'] == 1){
            $game_filter[] = "league_play = 'true'";
        } elseif($_POST['league'] == 0) {
            $game_filter[] = "league_play = 'false'";
        } else {
            $_SESSION['info'][] = $_POST['league'];
        }
    }

    if(isset($_POST['max-score']) && $_POST['max-score'] != '') {
        $max_score = mysqli_real_escape_string(db_connect(),$_POST['max-score']);
        $game_filter[] = "score < '$max_score'";
    }

    if(isset($_POST['min-score']) && $_POST['min-score'] != '') {
        $min_score = mysqli_real_escape_string(db_connect(),$_POST['min-score']);
        $game_filter[] = "score > '$min_score'";
    }

    if(isset($_POST['max-date']) && $_POST['max-date'] != '') {
        $max_date = mysqli_real_escape_string(db_connect(),$_POST['max-date']);
        $game_filter[] = "date <= '$max_date'";
    }

    if(isset($_POST['min-date']) && $_POST['min-date'] != '') {
        $min_date = mysqli_real_escape_string(db_connect(),$_POST['min-date']);
        $game_filter[] = "date >= '$min_date'";
    }

/*
    if(isset($_POST['username']) && $_POST['username'] != 'all' && $_POST['username'] != '') {
        $username = mysqli_real_escape_string(db_connect(),$_POST['username']);
        $game_filter[] = "username = '$username'";
    }
*/
    $game_filter = implode(' AND ', $game_filter);

    return($game_filter);
}

function random_string() {
    $chars = "abcdefghijklmnopqrsstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $i = 0;
    $random_string = '';
    while ($i < 64) {
        $random_string .= $chars[rand(0, count($chars))];
        $i++;
    }
    return $random_string;
}