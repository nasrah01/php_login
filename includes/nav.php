<?php
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