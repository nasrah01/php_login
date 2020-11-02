<?php
session_start();
require_once 'includes/functions.php';
admin_access($_SESSION['user'], 'admin', '?restricted=login');
secure_links();
require_once 'includes/logout.php'; 

$self = outgoing($_SERVER['PHP_SELF']);
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
            $input_error['username'] = '*At least 6 characters, and only include letters and numbers';
        }
    }
    if(isset($_POST['password'])) {
        $filter_pass = trim($_POST['password']);
        if(valid_pass($filter_pass) === true) {
            $input_valid['password'] = $filter_pass;
        } else {
            $error_found = true;
            $input_error['password'] = '*At least 8 characters and can contain letters and numbers';
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

    $existing_user = false;
    $user_error = array();
    $staff_file = '../fma/staffing.php';
    $error_messages = '';
   
    if(is_file($staff_file)) {
        $current_users = get_users($staff_file);
    } else {
        system_error('message=error');
    }
  /*   foreach($current_users as $user) {
        $splt_line = explode(',' , $user);
        $usernames = trim($splt_line[0]);
        $check_email = trim($splt_line[5]);

        
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
    } */
}

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
    <link rel="icon" type="image/png" href="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/favicon.png">
    <title>Admin - Staff Registration</title>
</head>
<body>
    <div class="container">
        <header>
        <div class = "heading">
        <?php
            include_once 'includes/header.php';
        ?>
        </div>
        </header>
        <div class="main register__page">
            <?php
            if(isset($_SESSION['user'])) {
                echo '<div class="main__nav register__nav">';
                include 'includes/nav.php';
                echo '</div>';
            }
            ?>
            <div class="register__content">
                <div class="register__form">
                    <h2>New Staff Registration</h2> 
                    <form action="<?php echo $self ?>" method="POST">
                        <fieldset>
                            <div class="error__field">
                                <span class="form__error"><p><?php echo (!empty($input_error)) ? outgoing('*Please correct the hightlighted parts of the form') : ' ' ?></p></span>
                                <span class="form__error"><p><?php echo (!empty($user_error)) ? outgoing('*The highlighted user information has already been registered') : ' ' ?></p></span>
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
                            </div>
                            <div class="box">
                                <label for="title" class="left">Title</label>
                                <select name="title" id="title">
                                    <option value="mr" <?php if($correct_ttl == 'mr') {echo ("selected");} ?>>Mr</option>
                                    <option value="ms" <?php if($correct_ttl == 'ms') {echo ("selected");} ?>>Ms</option>
                                    <option value="miss" <?php if($correct_ttl == 'miss') {echo ("selected");} ?>>Miss</option>
                                    <option value="mrs" <?php if($correct_ttl == 'mrs') {echo ("selected"); }?>>Mrs</option>
                                    <option value="dr" <?php if($correct_ttl == 'dr') {echo ("selected");} ?>>Dr</option>
                                </select>
                                <br/>
                                <span class="form__error"><?php echo (isset($input_error['title'])) ? outgoing($input_error['title']) : ' ';?></span>
                            </div>
                            <div class="box">
                                <label for="fname" class="left">Firstname</label>
                                <input type="text" name="fname" id="fname" value="<?php echo $correct_fname ?>">
                                <br/>
                                <span class="form__error"><?php echo (isset($input_error['firstname'])) ? outgoing($input_error['firstname']) : ' ';?></span>
                            </div>
                            <div class="box">
                                <label for="sname" class="left">Surname</label>
                                <input type="text" name="sname" id="sname" value="<?php echo $correct_sname ?>">
                                <br/>
                                <span class="form__error"><?php echo (isset($input_error['surname'])) ? outgoing($input_error['surname']) : ' ';?></span>
                                <span class="form__error"><?php echo $name_taken; ?></span>
                            </div>
                            <div class="box">
                                <label for="email" class="left">E-mail</label>
                                <input type="text" name="email" id="email" value="<?php echo $correct_email ?>">
                                <br/>
                                <span class="form__error"><?php echo (isset($input_error['email'])) ? outgoing($input_error['email']) : ' ';?></span>
                                <span class="form__error"><?php echo $email_taken; ?></span>
                            </div>
                            <div class="box">
                                <label for="username" class="left">Username</label>
                                <input type="text" name="username" id="username" value="<?php echo $correct_uname; ?>">
                                <br/>
                                <span class="form__error"><?php echo (isset($input_error['username'])) ? outgoing($input_error['username']) : ' ';?></span>
                                <span class="form__error"><?php echo $username_taken; ?></span>
                            </div>
                            <div class="box">
                                <label for="password" class="left">Password</label>
                                <input type="text" name="password" id="password">
                                <br/>
                                <span class="form__error"><?php echo (isset($input_error['password'])) ? outgoing($input_error['password']) : ' ';?></span>
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
                </div>
                <div class="register__instruct">
                    <ol>
                        <li>All fields are mandatory when creating an account for a new faculty member</li>
                        <li> The first and surname have to be at least two alphebetical characters long</li>
                        <li>The username created will have to be at least 6 alphanumerical characters long, the username will be case sensitive </li>
                        <li>The password will need to be at least 8 characters long and can include alphanumerical and special characters </li>
                    </ol>
                </div>
            </div>
        </div>
        <footer class="footer">
        <?php
            include_once 'includes/footer.php'; 
        ?>
        </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="js/index.js"></script>
</body>
</html>