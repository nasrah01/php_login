<?php
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
if(parameters('intranet', 'login')) {
    echo '<p class="highlight login">Please login to access the Department of Computer Science Intranet</p>';
} 
if(parameters('restricted', 'login')) {
    echo '<p class="highlight login">Please login as an administrator for access</p>';
}
?>