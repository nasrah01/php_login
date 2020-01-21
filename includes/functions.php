<?php
/* 
    This is a fixed value validation, if the form is submitted and the title sent to register.php does not match one of the values in 
    $valid_titles() the form will not validate
*/ 
function user_title($ttl) {
    $valid_titles = array('mr', 'ms', 'miss', 'mrs', 'dr', 'prof');
    if(in_array($ttl, $valid_titles)) {
        return true;
    }
    return false;
}
/* 
    This function when called will validate the string based on three criteria
    1) the string input must be equal to or more than two characters long
    2) it cannot exceed 20 characters 
    3) it must be alphabetic characters, so it cannot include numbers, special characters, or empty spaces between the letters
*/ 
function names($name) {
    if(strlen($name) >= 2 && strlen($name) <= 20 && ctype_alpha($name)) {
        return true;
    }
    return false;
}
/* 
    This function checks emails using a pre-defined filter FILTER_VALIDATE_EMAIL
*/ 
function validate_email($mail) {
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}
/* 
    This function when called will check the string based on three criteria all three must evaluate as true for the function to return true
    1) the username must be equal to or more than 6 characters long
    2) it cannot exceed 20 characters 
    3) it must be alphanumeric characters, if the string is made up of letters and numbers with no whitespace or spacial characters 
    included in the string
*/ 
function valid_username($uname) {
    if(strlen($uname) >= 6 && strlen($uname) <= 20 && ctype_alnum($uname)) {
        return true;
    }
    return false;
}
/* 
    valid password is similar to the above function with the difference being the password must be equal to or greater than 8 characters and 
    equal to or less than 20 characters 
*/ 
function valid_pass($password) {
    if(strlen($password) >= 8 && strlen($password) <= 20 && ctype_alnum($password)) {
        return true;
    } 
    return false;
}
/* 
    This function is reusable as long as data is stored in the same format
    1) This function requires one parameter to execute
    2) $check_users is the variable that will read each line of the file opened
    3) the if statement will ignore any lines that have comment symbols, because of the format staffing.php we want to ignore the first line
    and the last line of the file.
    4) each line that is read will then be pushed into the array $current_users, this array will be returned to the script that calls it
    this function.
*/
function get_users($file) {
    $current_users = array(); 
    $open_file = fopen($file, 'r');
    while(!feof($open_file)) {
        $check_users = fgets($open_file);
        if(strpos($check_users, '/*') === false && strpos($check_users, '*/') === false) {
            $current_users[] = $check_users;
        }
    }
    fclose($open_file);
    return $current_users;
}
/* 
    1) This function will write users data into a php file that has used comment symbols to hide user information
    2) The function requires three parameters to execute, the $filename to be opened, an array of user information lastly a confirmation
    message once the user has been successfully registered
    3) once the file is opened fseek is used to delete the last line of the file which is the closing php tag and closing comment symbol
    fseek will -5 spaces back to write into file, this will only work if the .php files last line is written in the same format
    4) the user array is then imploded into the string sections being separated by the comma symbol
    5) using the $create_user variable the user is written into the last line of the file
    6) $last_line variable is then used to reinsert the closing php tag and closing comment symbol
    7)if $create_user and $last_line is successfully written into the file the page is redisplayed with a confirmation message 
*/ 
function store_users($file_name, $user_arr, $confirmation) {
    $open_file = fopen($file_name, 'r+');
    fseek($open_file, -5, SEEK_END);
    $new_user =  implode(', ', $user_arr) . PHP_EOL;
    $create_user  = fwrite($open_file, $new_user);
    $last_line = fwrite($open_file,'*/ ?>');
    if($create_user === false && $last_line === false) {
        echo '<p> data not written</p>';
    } else {
        $current = htmlentities($_SERVER ['HTTP_REFERER']);
       header('Location:' . $current . '?' . $confirmation);
       exit();
    }
fclose($open_file); 
}
/* 
    This function is run to display any error messages when a file fails to open for reading or writing into file 
*/ 
function system_error($err) {
    $current = htmlentities($_SERVER['HTTP_REFERER']);
    header('Location: '. $current . '?' . $err);
    exit();
}
/* 
    This function takes two arguments
    1) $login_status checks if a session has not started and $_SESSION[name] is not present 
    2) if there is no session then $message redirect the page and not give access to the restricted page where this function is running
*/ 
function check_access($login_status, $message) {
    if(!isset($login_status)) {
        header('Location: ' . $message);
        exit();
    }
}
/* 
    This function will restict access to any users that are not logged in with admin credentials 
    1) the first argument $status checks a session has been started if the logged in user is not equal to $admin_user the user will not gain access to the restricted page
    2)strcasecmp() function is used to check the user $status against $admin user without it being case sensitive so if the user has typed in admin in uppercase
    therefore the $_SESSION['ADMIN'] will be compared to $admin_user 'admin' and return equal
    3) $current variable will redirect the logged in user back to the same page with an error message prompting a login with admin credentials
    4) if a logged in user attempted to gain access to a admin restricted page by typing into the url the destination they will be redirected to the login page
    prompting them to login as admin
    5) if the user is not logged in they will be redirected to the login page with the $message prompting an admin login
*/ 
function admin_access($status, $admin_user, $message) {
    if(isset($status) && strcasecmp($status, $admin_user) == 0) {
    } elseif(isset($status) && strcasecmp($status, $admin_user) != 0) {
        if(!isset($_SERVER['HTTP_REFERER'])) {
            header('Location: login.php' . $message);
            exit();
        } else {
            $current = htmlentities($_SERVER['HTTP_REFERER']);
            header('Location: '. $current .= $message);
            exit();
        }
    } else {
        header('Location: login.php' . $message);
        exit();
    }
}
/* 
    This reusable function is used to display a message when a user is redirected to a given location
    this code is repeated throughout the program
*/ 
function parameters($status, $output) {
    if(isset($_GET[$status]) && $_GET[$status] === $output) {
        return true;
    }
    return false;
}
/*
    1) REFERENCE: code is from stack overflow: https://stackoverflow.com/questions/44830037/how-to-redirect-index-php-to-https-only
    this is not my a code I have written
    2) This function is included in .php pages that are not includes or staffing.php 
    3)this ensures all pages run on https protocol rather than http as this is more secure when transfering data to and from the server
*/
function secure_links() {
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved to a new URL');
        header('Location: ' . $redirect);
        exit();
    }
}

/*
    REFERENCE: this code is from the solution pack for session 7 p1-catchup_pack in includes/menu.php
    this function will take one argumnet $list_arr from the array the function will create an unordered list 
*/
function create_list($list_arr) {
    $intranet_nav = '<ul>' . PHP_EOL;
    foreach ($list_arr as $name => $link) {
        $intranet_nav .= '<li><a href="' . $link . '">' . $name . '</a></li>' . PHP_EOL;
    }
    $intranet_nav .= '</ul>' . PHP_EOL;

    return $intranet_nav;
}

/* 
    This function is used to escape outgoing data, this is done throughout the program 
    utf-8 is the default value for php 5.6 and later, explictly coding it corrects any configurations made in html
*/
function outgoing($data) {
    $clean_data = htmlentities($data, ENT_QUOTES, 'UTF-8');
    return $clean_data;
}

?>