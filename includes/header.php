<?php
/*
    1) $site_title is the header set on every page
    2) $logout_button will be visible on every page when a $_SESSION has began, when a user logs out the button will no longer be visible
    3) if a session has began the users username will be displayed, line 27
    4) otherwise when no $_session is established $staff_links is visible which is the sign in header, line 29
    5) SIGN IN link is set up in an array to allow for future additions to header links
*/
$site_title = '<div class="title"><a href="index.php">
<h1>Birkbeck</h1>
<h4>UNIVERISTY OF LONDON</h4>
</a></div>';
echo $site_title;

$self = outgoing($_SERVER['PHP_SELF']);
$logout_button = '<form action=' .$self. ' method="POST">
    <div>
        <input type="submit" name="logout" value="Log Out">
    </div>
</form>';

$staff_links = array(
    'SIGN IN' => 'login.php'
);

if(isset($_SESSION['user'])) {
    echo '<div class="login"><h2>' . strtolower($_SESSION['user']) . '</h2>' . $logout_button . '</div>';
}  else {
    echo '<nav class="login">' . create_list($staff_links) . '</nav>';
}
/*
    1) When a logged out user or a logged in user without admin privileges tries to access a restricted page these two error messages are triggered
    2) The first redirect a logged out user, when attempting to access intranet pages, to the login page with the message to login
    3) The second will display the message either on the current page the logged in user is on, or the logged out user will be redirected to the login page
*/
if(parameters('intranet', 'login')) {
    echo '<p class="highlight login">Please login to access the Department of Computer Science Intranet</p>';
} 
if(parameters('restricted', 'login')) {
    echo '<p class="highlight login">Please login as an administrator for access</p>';
}
?>