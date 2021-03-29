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
        //cleaner function part
        $clean = $bdd->prepare("DELETE FROM urllinks WHERE Shorten = '.php'"); //deletes all empty $_POST sent
        $clean->execute();
    }
    function createFile(){
        $temp = fopen('temp.php', 'w');
        $txt = '<?php 
                    header("location: " . $_COOKIE["UrlCookie"]);
                    $fileName = basename($_SERVER["PHP_SELF"]);
                    unlink($fileName);
        ?> ';
        file_put_contents('temp.php', $txt);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your profile</title>
    <link rel="stylesheet" href="../styles/main.css"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'headerProfil.php'; ?>
    <div class="main">
        <h2 class="name">Nice to see you again, <?php echo $userinfo['username']; ?></h2>
            <?php echo $msg;?>
        <form action="#" method="post">
            <input type="url" name="url" placeholder="Place Long Url eg:https://google.com">
            <input type="submit" name="submit" value="Short It">
        </form>
        <h2 class="linkHistory">Your Mini Link history</h2>
        <?php $resultLink = $bdd->query("SELECT Shorten, Active, Views, linkID FROM urllinks WHERE id = $getid");
        while($row = $resultLink->fetch(PDO::FETCH_ASSOC)){
            if($row['Shorten']!= ".php"){//does not return empty links
                //oh boi do im proud of this code
                    $linkID = $row['linkID'];
                    if(isset($_POST[$linkID .'on'])){
                        $resultActive = $bdd->prepare("UPDATE urllinks SET Active = 1 WHERE LinkID = $linkID" );
                        $resultActive->execute();
                    }
                    elseif(isset($_POST[$linkID .'off'])){
                        $resultActive = $bdd->prepare("UPDATE urllinks SET Active = 0 WHERE LinkID = $linkID" ); 
                        $resultActive->execute();
                    }
                    $isLinkOn =  "<div class=active__false><p class='off'>Link off</p></div>";
                    $form = "<form action ='#' method ='post' class='form_on'>
                                <input type='submit' name='".$linkID."on' value='Turn On'>
                            </form>";
                    $form1 = "<form action ='#' method ='post' class='form_off'>
                                <input type='submit' name='".$linkID."off' value='Turn Off'>
                            </form>";
                echo "<div class='table'>
                        <div class='linkTable'><a href='". $row['Shorten']. "' target='_blank' class='links'>". $row['Shorten']. "<a/><br /></div>"; 
                echo "<div class='views'> <p class='viewsText'>". $row['Views'] ."</p></div> ";
                echo "<div class='forms'>".$form . $form1 . "</div>" ;   
            }
            
            echo "</div>";
            
        } 
            ?>
    </div>
    
    <?php include 'footer.php';?>
    <script src="../scripts/script.js"></script>
</body>
</html>

