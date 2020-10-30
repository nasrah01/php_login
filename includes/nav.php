<?php
$nav_links= array(
    'Home' => 'index.php' ,
    'Intranet' => 'intranet.php'  ,
    'PHP' => 'p1.php',
    'Database Technology' => 'dt.php',
    'Problem Solving' => 'pfp.php'
);

$admin_links = array(
    'Administrator' => 'register.php'
);

$self = outgoing($_SERVER['PHP_SELF']);
$logout_button = '<div class="logout__btn">
        <form action=' .$self. ' method="POST">
        <input type="submit" name="logout" value="Log Out">
        </form></div>';

echo create_list($nav_links, "class='navigate nav'") ;

echo create_list($admin_links, "class='admin__btn nav'");

echo $logout_button;
?>