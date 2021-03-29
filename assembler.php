<?php 
    $baseUrl = "Url-Shortener";
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=URLmembers','root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $resultUrl = $bdd->query("SELECT Shorten, Active, Views, Original FROM urllinks");
    while($row = $resultUrl->fetch(PDO::FETCH_ASSOC)){
        $queryUrl = "/" . $baseUrl . "/". $row['Shorten'];
        if($_SERVER['REQUEST_URI'] == $queryUrl && $row['Active']){
            setcookie("queryUrlCookie", $row['Shorten'], time() + (60),"/");
            $row['Views']++;
            header("location: ". $row['Original']);
        }
        elseif($_SERVER['REQUEST_URI'] == $queryUrl && $row['Active'] == false){
            echo "Hey ! Seems like this URL is Switched off :/";
        }

    }

    
    // echo $_SERVER['REQUEST_URI']; 
    // echo "<br>";

    
?>