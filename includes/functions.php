<?php

function user_title($ttl) {
    $valid_titles = array('mr', 'ms', 'miss', 'mrs', 'dr', 'prof');
    if(in_array($ttl, $valid_titles)) {
        return true;
    }
    return false;
}

function names($name) {
    if(strlen($name) >= 2 && strlen($name) <= 20 && ctype_alpha($name)) {
        return true;
    }
    return false;
}
 
function validate_email($mail) {
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function valid_username($uname) {
    if(strlen($uname) >= 6 && strlen($uname) <= 20 && ctype_alnum($uname)) {
        return true;
    }
    return false;
}

function valid_pass($password) {
    if(strlen($password) >= 8 && strlen($password) <= 20 && ctype_alnum($password)) {
        return true;
    } 
    return false;
}

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

function system_error($err) {
    $current = htmlentities($_SERVER['HTTP_REFERER']);
    header('Location: '. $current . '?' . $err);
    exit();
}

function check_access($login_status, $message) {
    if(!isset($login_status)) {
        header('Location: ' . $message);
        exit();
    }
}
 
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

function parameters($status, $output) {
    if(isset($_GET[$status]) && $_GET[$status] === $output) {
        return true;
    }
    return false;
}

function secure_links() {
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved to a new URL');
        header('Location: ' . $redirect);
        exit();
    }
}

function create_list($list_arr, $class) {
    $intranet_nav = '<ul '. $class . '>' . PHP_EOL;
    foreach ($list_arr as $name => $link) {
        $intranet_nav .= '<li><a href="' . $link . '">' . $name . '</a></li>' . PHP_EOL;
    }
    $intranet_nav .= '</ul>' . PHP_EOL;

    return $intranet_nav;
}

function outgoing($data) {
    $clean_data = htmlentities($data, ENT_QUOTES, 'UTF-8');
    return $clean_data;
}

?>