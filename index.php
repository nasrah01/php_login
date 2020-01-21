<?php
session_start(); 
require_once 'includes/logout.php';
require_once 'includes/functions.php';
/*
    1) secure_links() will ensure the page is displayed as https:// this function is included in every php file appart from the includes files and staffing.php
    2) includes/nav.php will only be displayed to a logged in user where a session has been started. 
 */
secure_links();
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
        if(parameters('status', 'loggedout')) {
            echo '<p class="login"> You have been Logged Out</p>';
        }
    ?>
    </div>
    </header>
    <main>
        <?php
        if(isset($_SESSION['user'])) {
            include 'includes/nav.php';
        }
        ?>
        <h2>Welcome to the Department of Computer Science</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione suscipit dolorem magnam eos sed accusamus? Amet nobis omnis dolores nam, voluptas odio non excepturi a ex aperiam! Iusto, voluptatum ab.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt labore quae, placeat saepe incidunt perspiciatis? Dicta pariatur exercitationem, nihil minus distinctio atque suscipit consectetur fuga placeat, sequi natus. Numquam, quaerat.
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempore odit delectus maiores obcaecati. Ad expedita, libero sint dolor doloremque pariatur laudantium reiciendis perspiciatis quidem accusamus distinctio excepturi voluptatibus? Numquam, repellendus!
        </p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione suscipit dolorem magnam eos sed accusamus? Amet nobis omnis dolores nam, voluptas odio non excepturi a ex aperiam! Iusto, voluptatum ab.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt labore quae, placeat saepe incidunt perspiciatis? Dicta pariatur exercitationem, nihil minus distinctio atque suscipit consectetur fuga placeat, sequi natus. Numquam, quaerat.
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempore odit delectus maiores obcaecati. Ad expedita, libero sint dolor doloremque pariatur laudantium reiciendis perspiciatis quidem accusamus distinctio excepturi voluptatibus? Numquam, repellendus!
        </p>
    </main>
</body>
</html>