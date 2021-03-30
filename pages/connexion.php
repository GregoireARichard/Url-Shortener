<?php 
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=URLmembers','root', '');
if(isset($_POST['submit'])) {
    $mail = htmlspecialchars($_POST['mail']);
    $pass = sha1($_POST['pass']);
    if(!empty($mail) AND !empty($pass)) {
       $stmt = $bdd->prepare("SELECT * FROM URLmembers WHERE mail = ? AND password = ?");
       $stmt->execute(array($mail, $pass));
       $userexist = $stmt->rowCount();
       if($userexist == 1) {
          $userinfo = $stmt->fetch();
          $_SESSION['ID'] = $userinfo['ID'];
          $_SESSION['username'] = $userinfo['username'];
          $_SESSION['mail'] = $userinfo['mail'];
          header("Location: profil.php?id=".$_SESSION['ID']);
          echo $_SESSION['mail'] . ' ' . $_SESSION['ID'] . ' ' . $_SESSION['username'];

        
       } else {
          $erreur = "Wrong mail or password";
       }
    } else {
       $erreur = "All field must be filled !";
    }
 }
 include 'headerSignin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../styles/main.css"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="../img/favicon.png"/>
</head>
<style>
   body{
      overflow:hidden;
   } 
</style>
<body>
   <div class="signinForm">
      <div class="marginer">
         <h1 class="signinTitle">Wooo ! Welcome back to <strong class="orange">Mini</strong><strong class="red">Link</strong></h1>
         <div class="wrapper"><p class="toSignUp">Don't have an account? Sign up <a href="signup.php" class="toSignUpLink">here</a> to unlock cool functionalities ! </p></div>
         <form method="POST" action="">
            <label class="labelsSignIn" for="mail">Email adress</label> <br>
            <input type="mail" name="mail" placeholder=" "> <br>
            <label class="labelsSignIn" for="password">Password</label> <br>
            <input type="password" name="pass" placeholder=" "> <br>
            <input type="submit" name="submit" value="Sign me in, Baby !">
         </form>
      </div>
    </div>
    <div class="randomFrame frame1"></div>
    <div class="randomFrame frame2"></div>
    <div class="randomFrame frame3"></div>
    <div class="randomFrame frame4"></div>
    <div class="randomFrame frame5"></div>
    <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
   <?php include 'footer.php';?>
</body>
</html>