<?php
session_start();
require_once 'includes/functions.php';
/*
    1) check_access function restricts this page to be viewed only by logged in users, both staff memebers and admin login
    2) secure_links ensures https protocol is set
*/
check_access($_SESSION['user'], 'login.php?intranet=login');
secure_links();
require_once 'includes/logout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Department of Computer Science</title>
</head>
<body>
    <header>
    <div class = "heading">
    <?php
        include_once 'includes/header.php';
    ?>
    </div>
    </header>
    <main>
        <?php
            include 'includes/nav.php';
        ?>
        <h2>Department of Computer Science Intranet</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et minus unde sit, libero suscipit magnam corporis expedita! Facere nisi quam unde dicta ducimus asperiores porro ex provident, ea voluptatum id!</p>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas, at rerum dolorum est quod asperiores eligendi explicabo eum quibusdam, numquam nobis eius accusantium perspiciatis! Esse placeat provident dolorem fuga ducimus.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ipsum recusandae distinctio accusamus inventore voluptatibus deleniti omnis porro fugiat dolore atque cupiditate molestiae veniam temporibus placeat illo excepturi, itaque odio!</p>
    </main>
</body>
</html