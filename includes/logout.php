<?php
/* REFERENCE: this code was taken from session 8 slides on Sessions slide 18 'destroying a session' 
   When the user logs out the user will be redirected to index.php with a message confirming they have been logged out
*/
if(isset($_POST['logout'])) {
    $_SESSION = array();
    if(ini_get("session.use_cookies")) {
        $yesterday = time() - (24 * 60 * 60);
        $params = session_get_cookie_params();
        setcookie(session_name(), '', $yesterday,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header('Location: index.php?status=loggedout');
}
?>