<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Classes File
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/

class User {
    private $username;
    private $password;
    private $id;

    public function __construct($id, $username, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function login($username, $password) {
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

    public function logout() {
        unset($_SESSION['authorized']);
        unset($_SESSION['memberID']);
        header('Location: '.DIRADMIN.'login.php');
        exit();
    }
}

class UserData() {
    private $user_id;
    private $data_id;
    private $admin;
    private $first_name;
    private $last_name;
    private $email;
    private $birthday;
    private $join_date;
    private $avatar;
    private $location;
    private $quote;
    private $about_me;

    public function __contruct($user_id, $data_id, $admin, $first_name, $last_name, $email, $birthday, $join_date, $avatar, $location, $quote, $about_me) {
        
        $this->user_id = $user_id;
        $this->data_id = $data_id;
        $this->admin = $admin;
        $this->first_name = $first_name;
        $this->lasst_name = $last_name;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->join_date = $join_date;
        $this->avatar = $avatar;
        $this->location = $location;
        $this->quote = $quote;
        $this->about_me = $about_me;
    }
}