<?php
session_start();
require_once 'includes/functions.php';
/*
    1) admin_access is the function that will verify if a user is admin this page will be visable 
    otherwise a logged out user or a logged in user that doesnt have admin privilege will be redirected to the login page or a message will display to prompt admin login
    2) secure_links ensures the page uses https protocol securing data transfers
*/
admin_access($_SESSION['user'], 'admin', '?restricted=login');
secure_links();
require_once 'includes/logout.php'; 
$self = outgoing($_SERVER['PHP_SELF']);
/* 
    1) Booleans and arrays for the first part of the validation delared
    2) This section will check if each field conforms to the criteria set if they do it will be pushed into $input_valid array
    3) At this stage of the validation if there are any errors $error_found will equal true and the error is pushed into $input_error array
 */
$submitted_form = false;
$error_found = false;
$input_valid = array();
$input_error = array();

if(isset($_POST['submit'])) {
    $submitted_form = true;
    if(isset($_POST['username'])) {
        $filter_user = trim($_POST['username']);
        if(valid_username($filter_user) === true) {
            $input_valid['username'] = $filter_user;
        } else {
            $error_found = true;
            $input_error['username'] = '*Username should be at least 6 characters, and only include letters and numbers';
        }
    }
    if(isset($_POST['password'])) {
        $filter_pass = trim($_POST['password']);
        if(valid_pass($filter_pass) === true) {
            $input_valid['password'] = $filter_pass;
        } else {
            $error_found = true;
            $input_error['password'] = '*Password must have at least 8 characters and can contain letters and numbers';
        }
    }
    if(isset($_POST['title'])) {
        $staff_title =  $_POST['title'];
        if(user_title($staff_title) === true) {
            $input_valid['title'] = $staff_title;
        } else {
            $error_found = true;
            $input_error['title'] = '*Please select a title';
        }
    }
    if(isset($_POST['fname'])) {
        $firstname = trim($_POST['fname']);
        if(names($firstname) === true) {
            $input_valid['firstname'] = $firstname;
        } else {
            $error_found = true;
            $input_error['firstname'] = '*Firstname must be at least 2 characters long';
        }
    }
    if(isset($_POST['sname'])) {
        $surname = trim($_POST['sname']);
        if(names($surname) === true) {
            $input_valid['surname'] = $surname;
        } else {
            $error_found = true;
            $input_error['surname'] = '*Surname must be at least 2 characters long';
        }
    }
    if(isset($_POST['email'])) {
        $filter_email = trim($_POST['email']);
        if(validate_email($filter_email) === true) {
            $input_valid['email'] = $filter_email;
        } else {
            $error_found = true;
            $input_error['email'] = '*Email is not valid';
        }
    }
    /* 
        1) The first part checks if firstname and surname combination have been registered, if so the conditional statement will evaluate $existing_user as true
        2) email is unique so if the email exists on file then the user is already registered 
        2) Username is checked because most systems do not allow the same user name to be taken by multiple users
        3)strcasecmp function is used to remove case sensitivity when comparing user input to existing users 
        4) staffing.php is saved in a varaible, if the filename needs to be changed it is only changed within this variable rather than looking for all occurances 
     */
    $existing_user = false;
    $user_error = array();
    $staff_file = '../fma/staffing.php';
    $error_messages = '';
   
    if(is_file($staff_file)) {
        $current_users = get_users($staff_file);
    } else {
        system_error('message=error');
    }
    foreach($current_users as $user) {
        $splt_line = explode(',' , $user);
        $fname = trim($splt_line[3]);
        $sname = trim($splt_line[4]);
        $usernames = trim($splt_line[0]);
        $check_email = trim($splt_line[5]);

        if(isset($input_valid['firstname'])) {
            if(strcasecmp($fname, $input_valid['firstname']) == 0 && strcasecmp($sname, $input_valid['surname']) == 0) {
                $existing_user = true;
                $user_error['fullname'] = '*' . $input_valid['firstname'] . ' ' . $input_valid['surname'] .  ' has already been registered';
            }
        }
        if(strcasecmp($input_valid['email'], $check_email) == 0) {
            $existing_user = true;
            $user_error['email'] = '*Email has already been registered';
        }
        if(isset($input_valid['username'])) {
            if(strcasecmp($usernames, $input_valid['username']) == 0) {
                $existing_user = true;
                $user_error['username'] = '*Username has already been registered';

            }
        }
    }
}
/* 
    If no errors are found in the $user_error() and $input_error() the two boolean checks will be false and validation complete
    If the validation is complete this section checks if staffing.php file exists and is writable if it is store_users function will write the data into file
    If either or both boolean checks are true the else part of this conditional statement will redisplay the form to include the error messages for any input fields with errors
    If an input field has no errors it is redisplayed with the users input
    system_error() function is used when there are any errors opening the file
    outgoing() is the function that escapes the data being redisplayed to the user and the errors being displayed

*/
if($submitted_form === true && $error_found === false && $existing_user === false) {
    if(is_file($staff_file) && is_writable($staff_file)) {
        store_users($staff_file, $input_valid, 'message=registered');
    } else {
        system_error('message=error');
    }

} else {
    // setting the error message if user information already exists
    if(isset($user_error['fullname'])) {
        $name_taken = outgoing($user_error['fullname']);
        $input_valid['firstname'] = '';
        $input_valid['surname'] = '';
    } else {
        $name_taken = '';
    }
    if(isset($user_error['username'])) {
        $username_taken = outgoing($user_error['username']);
        $input_valid['username'] = '';
    } else {
        $username_taken = '';
    }
    if(isset($user_error['email'])) {
        $email_taken = outgoing($user_error['email']);
        $input_valid['email'] = '';
    } else {
        $email_taken = '';
    }
    // If user input is validated as correct it is redisplayed on a form that has failed complete validation
    if(isset($input_valid['title'])) {
        $correct_ttl = outgoing($input_valid['title']);
    } else {
        $correct_ttl = '';
    }
    if(isset($input_valid['firstname'])) {
        $correct_fname = outgoing($input_valid['firstname']);
    } else {
        $correct_fname = '';
    }
    if(isset($input_valid['surname'])) {
        $correct_sname = outgoing($input_valid['surname']);
    } else {
        $correct_sname = '';
    }
    if(isset($input_valid['email'])) {
        $correct_email = outgoing($input_valid['email']);
    } else {
        $correct_email = '';
    }
    if(isset($input_valid['username'])) {
        $correct_uname = outgoing($input_valid['username']);
    } else {
        $correct_uname = '';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Staff Registration</title>
</head>
<body>
    <header>
    <div class = "heading">
    <?php
        include_once 'includes/header.php';
    ?>
    </div>
    </header>
    <main>
        <?php
            include 'includes/nav.php';
        ?>
        <h2>New Staff Registration</h2> 
        <!--
            These three spans will highlight to the user if there are any errors found
            If not error is found the form will reset and the user will be shown a message to confirm a new user has been registered
        -->
        <span class="highlight"><p><?php echo (!empty($input_error)) ? outgoing('*Please correct the hightlighted parts of the form') : ' ' ?></p></span>
        <span class="highlight"><p><?php echo (!empty($user_error)) ? outgoing('*The highlighted user information has already been registered') : ' ' ?></p></span>
        <span>
        <?php
            if(parameters('message', 'error')) {
                echo  '<p class= "highlight"> *System Error please try again later</p>';;
            } 
            if(parameters('message', 'registered')) {
                echo '<h4>Thank you! New staff member has been successfully registered.</h4>';
            } 
        ?>
        </span>
        <form action="<?php echo $self ?>" method="POST">
            <fieldset>
                <div>
                    <label for="title">Title</label>
                    <select name="title" id="title">
                        <option value="mr" <?php if($correct_ttl == 'mr') {echo ("selected");} ?>>Mr</option>
                        <option value="ms" <?php if($correct_ttl == 'ms') {echo ("selected");} ?>>Ms</option>
                        <option value="miss" <?php if($correct_ttl == 'miss') {echo ("selected");} ?>>Miss</option>
                        <option value="mrs" <?php if($correct_ttl == 'mrs') {echo ("selected"); }?>>Mrs</option>
                        <option value="dr" <?php if($correct_ttl == 'dr') {echo ("selected");} ?>>Dr</option>
                    </select>
                    <span class="highlight"><?php echo (isset($input_error['title'])) ? outgoing($input_error['title']) : ' ';?></span>
                </div>
                <div>
                    <label for="fname">Firstname</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $correct_fname ?>">
                    <span class="highlight"><?php echo (isset($input_error['firstname'])) ? outgoing($input_error['firstname']) : ' ';?></span>
                </div>
                <div>
                    <label for="sname">Surname</label>
                    <input type="text" name="sname" id="sname" value="<?php echo $correct_sname ?>">
                    <span class="highlight"><?php echo (isset($input_error['surname'])) ? outgoing($input_error['surname']) : ' ';?></span>
                    <span class="highlight"><?php echo $name_taken; ?></span>
                </div>
                <div>
                    <label for="email">E-mail</label>
                    <input type="text" name="email" id="email" value="<?php echo $correct_email ?>">
                    <span class="highlight"><?php echo (isset($input_error['email'])) ? outgoing($input_error['email']) : ' ';?></span>
                    <span class="highlight"><?php echo $email_taken; ?></span>
                </div>
                <div>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $correct_uname; ?>">
                    <span class="highlight"><?php echo (isset($input_error['username'])) ? outgoing($input_error['username']) : ' ';?></span>
                    <span class="highlight"><?php echo $username_taken; ?></span>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password">
                    <span class="highlight"><?php echo (isset($input_error['password'])) ? outgoing($input_error['password']) : ' ';?></span>
                </div>
                <div>
                   <input type="submit" name="submit" value="Create New User"> 
                </div>
            </fieldset>
        </form>

<?php
// closing else statement where errors are found
}
?>
    </main>
</body>
</html>