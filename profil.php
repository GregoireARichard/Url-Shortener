<?php 

    session_start();
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=URLmembers','root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_GET['id']) AND $_GET['id'] > 0){
        $getid = intval($_GET['id']);
        $stmt = $bdd->prepare('SELECT * FROM URLmembers WHERE id = ? ');
        $stmt->execute(array($getid));
        $userinfo = $stmt->fetch();
    }
    $baseUrl = "localhost/URL/";
    $msg = ' ';
    
    function shortenUrl($url){
        if (filter_var($url, FILTER_VALIDATE_URL)){
            $randStr = substr(str_shuffle(md5(rand())),0,6);
            $oldfile = file_get_contents('url_list.php') . "\n";
            $newfile = '$list[\''.$randStr.'\']=\''.$url.'\';';
            // file_put_contents('url_list.php', $oldfile.$newfile);
            return $randStr;
        } else{
            return false;
        }
    }
    if(isset($_POST['url'])) {
        $check = shortenUrl($_POST['url']);
        setcookie("UrlCookie", $_POST['url'], time() + (60),"/");
        $ID = $getid;
        $original = $_POST['url'];
        $shorten = $check . '.php';
        $linkID = rand(10000,999999) + rand(10,150) - rand(150,1000);
        $active = true;
        $views = 0;
        $date = date("Y-m-d");
        $stmm = $bdd->prepare("INSERT INTO urllinks (ID, Original, Shorten, LinkID, Active, Views, Date)VALUES(?,?,?,?,?,?,?)");
        $stmm->execute(array($ID, $original, $shorten, $linkID, $active, $views, $date));
        if ($check) {
            $msg = "<p class=\"success\">Url Created</p>
            <a href=\"{$check}.php\" target='_blank'>{$baseUrl}{$check}</a>";
            rename('temp.php', $check.'.php');
            createFile();
        } else {
            $msg = "<p class=\"error\">Invalid Url</p>";
        }
    }
    function createFile(){
        $temp = fopen('temp.php', 'w');
        $txt = '<?php 
                    $url = "https://google.com";
                    header("location: " . $_COOKIE["UrlCookie"]);
                    $fileName = basename($_SERVER["PHP_SELF"]);
                    unlink($fileName);
        ?> ';
        file_put_contents('temp.php', $txt);
    }
        // if (isset($_GET['url'])) {
    //     $urlCookieName = "UrlCookie";
    //     $urlCookieValue = $_POST['url'];
    //     setcookie($urlCookieName, $urlCookieValue, time() + (86400 * 30),"/");
    //     echo $_COOKIE[$urlCookieName];
    //     require_once('url_list.php');
    //     if (isset($list[$_GET['url']])) {
    //         $link = $list[$_GET['url']];
    //         header('location:'.$link);
    //     } else {
    //         header('location:'.$baseUrl);
    //     }
    //} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your profile</title>
    <link rel="stylesheet" href="styles/main.css"/>
</head>
<body>
    <h2 class="name">bonjour <?php echo $userinfo['username']; ?></h2>
         <a href="signout.php">Se déconnecter</a>
         <?php echo $msg;?>
    <form action="#" method="post">
        <input type="url" name="url" placeholder="Place Long Url eg:https://google.com">
        <input type="submit" name="submit" value="Short It">
    </form>
    <?php $resultLink = $bdd->query("SELECT Original FROM urllinks WHERE id = $getid");
    while($row = $resultLink->fetch(PDO::FETCH_ASSOC)){
        if(!empty($row['Original'])){
            echo "<div class='linkTable'>". $row['Original']. "<br /></div>"; //does not return empty links
        }
    }   
        ?>
</body>
</html>
