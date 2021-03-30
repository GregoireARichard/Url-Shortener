<?php 
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=URLmembers','root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $baseUrl = "localhost/URL/";
    $msg = ' ';
    
    function shortenUrl($url){
        if (filter_var($url, FILTER_VALIDATE_URL)){
            $randStr = substr(str_shuffle(md5(rand())),0,6);
            $oldfile = file_get_contents('pages/url_list.php') . "\n";
            $newfile = '$list[\''.$randStr.'\']=\''.$url.'\';';
            // file_put_contents('url_list.php', $oldfile.$newfile);
            return $randStr;
        } else{
            return false;
        }
    }
    if(isset($_POST['url'])) {
        $check = shortenUrl($_POST['url']);
        $ID = 0;
        $original = $_POST['url'];
        $shorten = $check . '.php';
        $linkID = rand(10000,999999) + rand(10,150) - rand(150,1000);
        $active = true;
        $views = 0;
        $date = date("Y-m-d");
        $stmm = $bdd->prepare("INSERT INTO urllinks (ID, Original, Shorten, LinkID, Active, Views, Date)VALUES(?,?,?,?,?,?,?)");
        $stmm->execute(array($ID, $original, $shorten, $linkID, $active, $views, $date));
        setcookie("UrlCookie", $_POST['url'], time() + (60),"/");
        if ($check) {
            $msg = "<p class=\"success\">Url Created</p>
            <a href=\"pages/{$check}.php\" target='_blank'>{$baseUrl}{$check}</a>";
            rename('pages/temp.php','pages/' .$check.'.php');
            createFile();
        } else {
            $msg = "<p class=\"error\">Invalid Url</p>";
        }
        //cleaner function part
    }
    function createFile(){
        $temp = fopen('pages/temp.php', 'w');
        $txt = '<?php 
                    $url = "https://google.com";
                    header("location: " . $_COOKIE["UrlCookie"]);
                    $fileName = basename($_SERVER["PHP_SELF"]);
                    unlink($fileName);
        ?> ';
        file_put_contents('pages/temp.php', $txt);
    }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Minilink</title>
      <link rel="stylesheet" href="styles/main.css"/>
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
      <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
   </head>
   <?php include 'pages/headerIndex.php'; ?>
   <style>
       body{
           overflow:hidden;
       }
   </style>
   <body>
      <div class="mainIndex">
         <div class="marginerTop">
            <form action="#" method="post">
                <label class="contextLink" for="contextLink">Enter your loo<strong class="orange">o</strong>oooo<strong class="red">o</strong>ng link here !</label> <br>
                <input type="url" name="url" placeholder=" "> <br>
                <input type="submit" name="submit" value="Make it Mini !">
                <?php echo $msg;?>
            </form>
         </div>
      </div>
      <div class="randomFrame frame1"></div>
      <div class="randomFrame frame2"></div>
      <div class="randomFrame frame3"></div>
      <div class="randomFrame frame4"></div>
      <div class="randomFrame frame5"></div>
      <div class="randomFrame frame6"></div>
      <?php include 'pages/footer.php'; ?>
   </body>
</html>