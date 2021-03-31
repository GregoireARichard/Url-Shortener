<?php 
session_start();
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../img/favicon.png"/>
    <title>Sign out</title>
    <link rel="stylesheet" href="../styles/main.css"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'headerSignup.php';?>
    <style>
        body{
            overflow : hidden;
        }
    </style>
    <div class="signedOutMain">
        <div class="marginer marginerTop">
        <h2>You've been signed out</h2>
        <div class="comeBack">
            <h1 class="comeBackSoon">Come back S<strong class="orange">o</strong><strong class="red">o</strong>n !</h1>
        </div>

        </div>
    </div>
    <div class="randomFrame frame1"></div>
    <div class="randomFrame frame2"></div>
    <div class="randomFrame frame3"></div>
    <div class="randomFrame frame4"></div>
    <div class="randomFrame frame5"></div>
    <div class="randomFrame frame6"></div>
    <?php include 'footer.php';?>
</body>
</html>
