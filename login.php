<?php
session_start(); 
require_once 'includes/functions.php';
require_once 'includes/logout.php';
secure_links(); 
/* 
    This first part of the login validation checks if any login field is left empty
    If a field is left empty an error message will be pushed into $user_error array
    The username and password string input is filtered and then pushed into $valid_input array
*/
$submitted_login = false;
$verified_user = false;
$incorrect_login = array();
$user_error = array();

if(isset($_POST['submit'])) {
    $submitted_login = true;
    $error_input = '*Please fill in this field';
    if(isset($_POST['username'])) {
        $user = trim($_POST['username']);
        if(!empty($user)) {
            $valid_input['username'] = $user;
        }  else {
            $user_error['username'] = $error_input;
        }
    }
    if(isset($_POST['password'])) {
        $pass = trim($_POST['password']);
        if(!empty($pass)) {
            $valid_input['password'] = $pass;
        } else {
            $user_error['password'] = $error_input;
        }
    }
/* 
    1) The first condition is checking if a $valid_input has been set for username and password
    2) The second conditional statement will check whether the username entered is equal to $admin_username
    if the username is admin, $admin_password will be checked against the users password input, if the password entered is incorrect 
    it will be pushed into $incorrect_login array
    3) $correct_user is the variable used to display the username entered if the password is incorrect and the form is redisplayed
    4) If the username entered by the user does not equal to 'admin' the else conditional statement will run, the username will then be checked 
    against all the usernames saved on $staff_file.
    5) If the username is found the password will be checked
    6) If the username is not found in $staff_file a message will be pushed into $incorrect_login array to display to the user
    7) strcasecmp() function is used to verify the username, it will check username input against saved usernames in a case insensitive manner
    strcasecmp() is not used for passwords, passwords are case sensitive the user must enter the password as it is on file
    8) If the username inputed does not equal to a username stored in $staffing.php the $incorrect_login['username'] error message will be displayed
*/
    if(isset($valid_input['username']) && isset($valid_input['password'] )) {
        $admin_username = 'admin';
        $admin_password = 'dcsadmin01';
        $wrong_pass = 'Incorrect password, password is case sensitive';
        if(strcasecmp($valid_input['username'], $admin_username) == 0) {
            if($admin_password === $valid_input['password']) {
                $verified_user = true;
            } else {
                $incorrect_login['password'] = $wrong_pass;
                $correct_user = $user;
            }
        } else {
            $staff_file = '../fma/staffing.php';
            if(is_file($staff_file)) {
                $current_users = get_users($staff_file);
            } else {
                system_error('message=error');
            }
            foreach($current_users as $curr) {
                $splt = explode(',' , $curr);
                $username = trim($splt[0]);
                $password = trim($splt[1]);
                if(strcasecmp($username, $valid_input['username']) == 0) {
                    if($password === $valid_input['password']) {
                        $verified_user = true;
                    } else {
                        $incorrect_login['password'] = $wrong_pass;
                        $correct_user = $user;
                    } 
                } else {
                    $incorrect_login['username'] = 'Invalid Login';
                }
            }
        }   
    }
}
/* 
    1) $verified_user boolean will equal to true when a username and password has matched to users details on file
    2) the validated username will be assigned to a $_SESSION varaible
    3) session_regenerate_id is set at this stage to avoid the risk of session fixation now the user is successfully logging in
    4) if the user logs in as 'admin' they will be directed to the admin page
    5) normal staff memebers will be directed to the intanet page
*/
if($submitted_login === true && $verified_user === true) {
    session_regenerate_id(true);
    $_SESSION['user'] = $valid_input['username'] ;
    if(strcasecmp($valid_input['username'], 'admin') == 0) {
        header('Location: register.php');
        exit();
    } else {
        header('Location: intranet.php');
        exit();
    } 
} else {
    // if the username is filled in and the password is left empty, the username entered is redisplayed
    if(isset($valid_input['username']) && !isset($valid_input['password'])) {
        $username_filled = outgoing($user);
    } else {
        $username_filled = '';
    }
    if($verified_user === false ) {
        // this sets the error messages if the username and or password fields are left empty
        if(isset($user_error['username'])) {
            $error_user_message = outgoing($user_error['username']);
        } else {
            $error_user_message = '';
        }
        if(isset($user_error['password'])) {
            $error_pass_message = outgoing($user_error['password']);
        } else {
            $error_pass_message = '';
        }
        // this sets the error found with the password where the username is verified, $username_correct will redisplay the verified username
        if(isset($incorrect_login['password'])) {
            $incorrect_pass = outgoing($incorrect_login['password']);
        } else {
            $incorrect_pass = '';
        }
        if(isset($correct_user)) {
            $username_correct = outgoing($user);
        } else {
            $username_correct = '';
        }
        // this sets the error message for user not found
        if(isset($incorrect_login['username']) && !isset($incorrect_login['password'])) {
            $incorrect_user = outgoing($incorrect_login['username']);
        } else {
            $incorrect_user = '';
        }
    }
/* 
    1) $login_form variable is set to empty string if a $_SESSION has started the login form will not be displayed on the screen
*/
    $login_form = '';
    if(!isset($_SESSION['user'])) {
        $self = outgoing($_SERVER['PHP_SELF']);
        $login_form =  '<form action=' .$self. ' method="POST">
        <fieldset>
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="' . $username_correct . '' . $username_filled . '">
                <span class="highlight">' . $error_user_message . '</span>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <span class="highlight">' . $error_pass_message . '</span>
                <span class="highlight">' . $incorrect_pass . '</span>
            </div>
            <div>
                <input type="submit" name="submit" value="login">
                <span class="highlight">' . $incorrect_user . '</span>
            </div>
        </fieldset>
    </form>';
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <header>
    <div class = "heading">
    <?php
        include_once 'includes/header.php';   
    ?>
    </div>
    </header>
    <?php
        if(isset($_SESSION['user'])) {
            include 'includes/nav.php';
        }
/*
    1) $login_form is displayed in html
    2) If there is an error opening $staff_file the error message is displayed here
    3) Closing the else statement where errors are found
*/
        echo $login_form;
        if(parameters('message', 'error')) {
            echo  '<p class= "highlight"> *System Error please try again later</p>';;
        }  
}
    ?>
</body>
</html>