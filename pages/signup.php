<?php 
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=URLmembers','root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['submit'])) {
        $name = htmlspecialchars($_POST['name']);
        $mail = htmlspecialchars($_POST['mail']);
        $mdp = sha1($_POST['pass']);
        $mdp2 = sha1($_POST['pass2']);
        $ID = rand(10000,999999) + rand(10,150) - rand(150,1000); // randomisation of the ID to prevent from hijacking
        if(!empty($_POST['name']) AND !empty($_POST['mail']) AND !empty($_POST['pass']) AND !empty($_POST['pass2'])) {
           $pseudolength = strlen($name);
           if($pseudolength <= 255) {
                 if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $stmt = $bdd->prepare("SELECT * FROM URLmembers WHERE mail = ?");
                    $stmt->execute(array($mail));
                    $mailexist = $stmt->rowCount();
                    if($mailexist == 0) {
                       if($mdp == $mdp2) {
                          $insertmbr = $bdd->prepare("INSERT INTO URLmembers (username, mail, password, ID) VALUES(?, ?, ?, ?)");
                          $insertmbr->execute(array($name, $mail, $mdp, $ID));
                          //$insertlnk = $bdd->prepare("INSERT INTO urllinks (ID) VALUES (?)"); //insert into the link table to get the same ID
                          //$insertlnk->$bdd->execute(array($ID));
                          $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                          header('location: connexion.php');
                       } else {
                          $erreur = "Vos mots de passes ne correspondent pas !";
                       }
                    } else {
                       $erreur = "Adresse mail déjà utilisée !";
                    }
                 } else {
                    $erreur = "Votre adresse mail n'est pas valide !";
                 }
              } else {
                 $erreur = "Vos adresses mail ne correspondent pas !";
              }
           } else {
              $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
           }
        } else {
           $erreur = "Tous les champs doivent être complétés !";
        }
   //   $conn = new mysqli($servername, $username, $password);
   //   if ($conn->connect_error) {
   //       die("Connection failed: " . $conn->connect_error);
   //   } 
     
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>URL Shortener</title>
        <link rel="stylesheet" href="../styles/main.css"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
       <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
       <link rel="shortcut icon" type="image/png" href="../img/favicon.png"/>
    </head>
    <body>
       <style>
          body{
             overflow:hidden;
          }
       </style>
       <?php include 'headerSignup.php'; ?>
        <div class="signupForm">
           <div class="marginer">
            <h1 class="mainTitle">Welcome to <strong class="orange">Mini</strong><strong class="red">Link</strong> we're glad to have you !</h1>
                  <form method="POST" action="">
                     <label for="name">Username</label> <br>
                     <input type="text" placeholder=" " id="name" name="name" value="<?php if(isset($mail)) { echo $name; } ?>" /> <br>
                     <label for="mail">Email adress</label> <br>
                     <input type="mail" placeholder=" " id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" /><br>
                     <label for="mdp">Password</label> <br>
                     <input type="password" placeholder=" " id="pass" name="pass" /> <br>
                     <label for="mdp2">Password confirmation</label> <br>
                     <input type="password" placeholder=" " id="pass2" name="pass2" /> <br>

                     <input type="submit" value="Let's go !" class="submitSignin" name="submit" class="registerbtn">
                  <?php     
                  if(isset($erreur)) {
                        echo '<font color="red">'.$erreur."</font>";
                     }
                     ?>
               </form>
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
