<?php
$site_title = '<a href="index.php" class="heading__title">
<img src="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/bbklogo.jpg" alt="birkbeck logo" />
</a>
<h1 class="heading__name"><span>Department of</span> <br> Computer Science and Information Systems</h1>
';

echo $site_title;

if(isset($_SESSION['user'])) {
    echo '<div class="heading__login"><h2 class="login__name">' . ucfirst(strtolower($_SESSION['user'])) . '</h2></div>';
}  else {
    echo '<div class="heading__login"><a href="login.php"><li class="login__name">Log In</li>
    <svg class="login__icon">
    <use xlink:href="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/sprite.svg#icon-log-in"></use>
    </svg></a></div>';
}
if(parameters('intranet', 'login')) {
    echo '<p class="highlight login">Please login to access DCSIS Intranet</p>';
} 
if(parameters('restricted', 'login')) {
    echo '<p class="highlight login">Please login with administrator credentials</p>';
}
?>