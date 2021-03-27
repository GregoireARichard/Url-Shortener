<?php
    $mail = $_POST['mailList'];
    $rand = rand(111,999);
    $date = date("mdh");
    $id = "0015";
    $token = $rand . $date . $id;
    echo $token;
    if(isset($_POST['submit'])){
        $header="MIME-Version: 1.0\r\n";
        $header.='From: Votre token IDEAS'."\n";
        $header.='Content-Type:text/html; charset="uft-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';
        $message=' <html>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
         <body>
            <div align="center">
               <h1 style="font-family: "Open Sans", sans-serif;"> Mdr bonjour je suis un mail automatique </h1> <br>
               <p style="font-family: "Open Sans", sans-serif;> Voici ton Token : '. $token .' </p> <br>
               <p style="font-family: "Open Sans", sans-serif;> Bon histoire que ce mail serve pas tout à fait à rien, voici comment je préconise de faire les tokens</p><br>
               <p style="font-family: "Open Sans", sans-serif;>Les trois premiers chiffres sont des randoms de 111 à 999, les 6 suivants sont le mois, le jour et heure, les quatre derniers représente notre ID</p>
               

            </div>
         </body>
      </html>
      ';
      mail($mail, "Sujet du message", $message, $header);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mail sender</title>
    </head>
    <body>
        <form method="POST" action="">
        <label for="mail">Email</label>
        <input type="text" placeholder="votre mail" id="mail" name="mailList" value="" />
        <input type="submit" value="submit" name="submit" class="registerbtn">
        </form>
    </body>
    <?php 
        if(isset($_POST['mailList'])){
            echo $_POST['mailList'];
        }
    ?>
</html>