<?php
session_start(); 
require_once 'includes/logout.php';
require_once 'includes/functions.php';

secure_links();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/favicon.png">
    <title>Home - Department of Computer Science</title>
</head>
<body>
    <div class="container">
        <header>
            <div class = "heading index__page--heading">
            <?php
                include_once 'includes/header.php'; 
                if(parameters('status', 'loggedout')) {
                    echo '<p class="login highlight"> You have been Logged Out</p>';
                }
            ?>
            </div>
        </header>
        <div class="main">
            <?php
            if(isset($_SESSION['user'])) {
                echo '<div class="main__nav">';
                include 'includes/nav.php';
                echo '</div>';
            }
            ?>
            <div class="main__intro">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione suscipit dolorem magnam eos sed accusamus? Amet nobis omnis dolores nam, voluptas odio non excepturi a ex aperiam! Iusto, voluptatum ab.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt labore quae, placeat saepe incidunt perspiciatis? Dicta pariatur exercitationem, nihil minus distinctio atque suscipit consectetur fuga placeat, sequi natus. Numquam, quaerat.
                Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>
            
            <div class="main__boxes">
                <div class="main__box main__box--1">
                <div class="main__head">
                        <svg class="icon">
                            <use xlink:href="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/sprite.svg#icon-graduation-cap"></use>
                        </svg>
                        <h3>Study</h3>
                    </div>
                    <div class="main__content">
                        <img src="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/birkbeck.jpg" alt="university building">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione suscipit dolorem magnam eos sed accusamus? Amet nobis omnis dolores nam, voluptas odio non excepturi a ex aperiam! Iusto, voluptatum ab.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt labore quae. 
                        </p>
                    </div>
                </div>
                <div class="main__box main__box--2">
                    <div class="main__head">
                        <svg class="icon">
                            <use xlink:href="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/sprite.svg#icon-bar-chart"></use>
                        </svg>
                        <h3>Reseach</h3>
                    </div>
                    <div class="main__content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione suscipit dolorem magnam eos sed accusamus? Amet nobis omnis dolores nam, voluptas odio non excepturi a ex aperiam! Iusto, voluptatum ab.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt labore quae, placeat saepe incidunt perspiciatis? Dicta pariatur exercitationem, 
                        </p>
                    </div>
                </div>
                <div class="main__box main__box--3">
                    <div class="main__head">
                        <svg class="icon">
                            <use xlink:href="https://titan.dcs.bbk.ac.uk/~nabrah01/intranet/assets/sprite.svg#icon-newspaper-o"></use>
                        </svg>
                        <h3>News & Events</h3>
                    </div>
                    <div class="main__content">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt labore quae, placeat saepe incidunt perspiciatis? 
                        Dicta pariatur exercitationem 
                        </p>
                        <p>nihil minus distinctio atque suscipit consectetur fuga placeat, sequi natus. Numquam, quaerat.
                        Lorem ipsum dolor
                        </p> 
                        <p>sit amet consectetur adipisicing elit. Tempore odit delectus maiores obcaecati. Ad expedita, libero sint dolor doloremque pariatur 
                        Numquam, repellendus!
                        </p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
    <script src="js/index.js"></script>
</body>
</html>