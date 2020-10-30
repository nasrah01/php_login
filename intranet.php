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
    <link rel="icon" type="image/png" href="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/favicon.png">
    <title>Intranet - Department of Computer Science</title>
</head>
<body>
    <div class="container">
        <header>
        <div class = "heading">
        <?php
            include_once 'includes/header.php';
        ?>
        </div>
        </header>
        <div class="main intranet__page">
            <div class="main__nav">
                <?php
                    include 'includes/nav.php';
                ?>
            </div>
           
            <div class="intranet__content">
                <div class="main__intranet--list">
                    <p>DCSIS Home</p>
                    <ul>
                        <li><a href="#">Systems Support</a></li>
                        <li><a href="#">Student Support</a></li>
                        <li><a href="#">Teaching</a></li>
                        <li><a href="#">Assessment</a></li>
                        <li><a href="#">Student Projects</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Health and Safety</a></li>
                    </ul>
                </div>
                <div class="main__intranet--text">
                    <div class="text">
                    <p><span>Lorem, ipsum dolor sit amet</span> consectetur adipisicing elit. Et minus unde sit, libero suscipit magnam corporis expedita! Facere nisi quam unde dicta ducimus asperiores porro ex provident, ea voluptatum id!</p>
                    </div>
                    <div>
                    <p><span>Lorem, ipsum dolor sit amet</span> consectetur adipisicing elit. Et minus unde sit, libero suscipit magnam corporis expedita! Facere nisi quam unde dicta ducimus asperiores porro ex provident, ea voluptatum id!</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. <span>Voluptas, at rerum dolorum</span> est quod asperiores eligendi explicabo eum quibusdam, numquam nobis eius accusantium perspiciatis! Esse placeat provident dolorem fuga ducimus.</p>
                    <p>Lorem ipsum dolor sit amet, <span>consectetur adipisicing</span> elit. Sunt ipsum recusandae distinctio accusamus inventore voluptatibus deleniti omnis porro fugiat dolore atque cupiditate molestiae veniam temporibus placeat illo excepturi, itaque odio!</p>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
        <?php
            include_once 'includes/footer.php'; 
        ?>
        </footer>
    </div>
</body>
</html