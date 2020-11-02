<?php
$nav_links= array(
    'Home' => 'index.php' ,
    'Intranet' => 'intranet.php'  ,
    'PHP' => 'p1.php',
    'Database Technology' => 'dt.php',
    'Problem Solving' => 'pfp.php'
);

$hamburger = '<div class="menu__btn">
            <div class="navigation__line navigation__one"></div>
            <div class="navigation__line navigation__two"></div>
            <div class="navigation__line navigation__three"></div>
        </div>';

$admin_links = array(
    'Administrator' => 'register.php'
);

$self = outgoing($_SERVER['PHP_SELF']);
$logout_button = '<div class="logout__btn">
        <form action=' .$self. ' method="POST">
        <input type="submit" name="logout" value="Log Out">
        </form></div>';

echo $hamburger;

echo create_list($nav_links, "class='navigate nav'");

echo create_list($nav_links, "class='navigate__mobile nav'");

echo create_list($admin_links, "class='admin__btn nav'");

echo $logout_button;
?>