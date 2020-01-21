<?php
session_start(); 
require_once 'includes/functions.php';
require_once 'includes/logout.php';
secure_links(); 

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

    // checking if the user is admin or has valid staff login credentials
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

// if user exists redirect to intranet page
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
        echo $login_form;
        if(parameters('message', 'error')) {
            echo  '<p class= "highlight"> *System Error please try again later</p>';;
        }  
}
    ?>
</body>
</html>