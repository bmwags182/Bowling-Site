<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Classes File
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/
require('../includes/config.php');

class User {
    private $username;
    private $password;
    private $email;
    private $id;
    private $data[];

    public function __construct($id, $username, $email, $password, $data) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->data = [
                        'admin'         => '0',
                        'first_name'    => '',
                        'last_name'     => '',
                        'birthday'      => '',
                        'join_date'     => date(m, d, Y),
                        'avatar'        => '',
                        'location'      => '',
                        'quote'         => '',
                        'about_me'      => '']
    }

    public function login($username, $password) {
        $mysqli = db_connect();
        //strip all tags from varible
        $username = strip_tags(mysqli_real_escape_string($mysqli,$username));
        $password = strip_tags(mysqli_real_escape_string($mysqli,$password));

        $password = md5($password);

        // check if the user id and password combination exist in database
        $sql = "SELECT * FROM members WHERE username = '$username' AND password = '$password'";
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

    public function logout() {
        unset($_SESSION['authorized']);
        unset($_SESSION['memberID']);
        header('Location: '.DIRADMIN.'login.php');
        exit();
    }

    public function create_user($username, $email, $password) {

    }
}

