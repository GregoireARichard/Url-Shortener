<?php 
    $baseUrl = "Url-Shortener";
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=URLmembers','root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $resultUrl = $bdd->query("SELECT Shorten, Active, Views, Original, LinkID FROM urllinks");
    while($row = $resultUrl->fetch(PDO::FETCH_ASSOC)){
        $queryUrl = "/" . $baseUrl ."/". "pages/". $row['Shorten'];
        if($_SERVER['REQUEST_URI'] == $queryUrl && $row['Active']){
            $Shorten = $row['LinkID'];
            $resultViews = $bdd->prepare("UPDATE urllinks SET Views = Views + 1 WHERE LinkID = $Shorten" );
            $resultViews->execute();
            $row['Views']++;
            header("location: ". $row['Original']);
        }
        elseif($_SERVER['REQUEST_URI'] == $queryUrl && $row['Active'] == false){
            echo "Hey ! Seems like this URL is Switched off :/";
        }

    }
    
?>