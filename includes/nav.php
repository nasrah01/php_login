<?php
/*
    1) $nav_links is the array that allows the logged in user to navigate through the intranet pages, 
    the links will only be visible to logged in users
    2) $admin links will also be visible to all logged in users
    if the user logged in is admin they will have access to register.php otherwise logged in staff memebers
    who click on the link will be prompted to login with admin credentials 
*/
$nav_links= array(
    'Home' => 'index.php' ,
    'Intranet' => 'intranet.php'  ,
    'Web Programming using PHP' => 'p1.php',
    'Introduction to Database Technology' => 'dt.php',
    'Problem Solving for Programming' => 'pfp.php'
);

$admin_links = array(
    'Administrator' => 'register.php'
);

echo '<nav class="primary">' . create_list($nav_links) . '</nav>';

echo create_list($admin_links);
?>