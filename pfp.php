<?php
session_start(); 
require_once 'includes/functions.php';
/*
    1) secure_links function ensures https protocol is used
    2) check_access function requires the user is logged in either as admin or a staff member
*/
secure_links();
check_access($_SESSION['user'], 'login.php?intranet=login');
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
    <title>PHP - Problem Solving for Programming</title>
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
        <div class="main results__page">
            <div class="main__nav">
                    <?php
                        include 'includes/nav.php';
                    ?>
            </div>
            <div class="results__content">    
                <h2>Problem Solving for Programming – PfP Results</h2>
                <table>
                    <tr>
                    <th>Year</th>
                    <th>Students</th>
                    <th>Pass</th>
                    <th>Fail (no resit)</th>
                    <th>Resit</th>
                    <th>Withdrawn</th>
                    </tr>
                    <tr>
                    <td>2012/13</td>
                    <td>65</td>
                    <td>45</td>
                    <td>7</td>
                    <td>3</td>
                    <td>10</td>
                    </tr>
                    <tr>
                    <td>2013/14</td>
                    <td>55</td>
                    <td>35</td>
                    <td>5</td>
                    <td>15</td>
                    <td>0</td>
                    </tr>
                    <tr>
                    <td>2014/15</td>
                    <td>60</td>
                    <td>45</td>
                    <td>2</td>
                    <td>10</td>
                    <td>3</td>
                    </tr>
                    <tr>
                    <td>2015/16</td>
                    <td>38</td>
                    <td>30</td>
                    <td>8</td>
                    <td>3</td>
                    <td>7</td>
                    </tr>
                    <tr>
                    <td>2016/17</td>
                    <td>49</td>
                    <td>30</td>
                    <td>7</td>
                    <td>4</td>
                    <td>8</td>
                    </tr>
                    <tr>
                    <td>2017/18</td>
                    <td>55</td>
                    <td>33</td>
                    <td>8</td>
                    <td>7</td>
                    <td>7</td>
                    </tr>
                    <tr>
                    <td>2018/19</td>
                    <td>48</td>
                    <td>30</td>
                    <td>8</td>
                    <td>3</td>
                    <td>7</td>
                    </tr>
                </table>
            </div>    
        </div>
        <footer class="footer">
        <?php
            include_once 'includes/footer.php'; 
        ?>
        </footer>
    </div>  
</body>
</html>