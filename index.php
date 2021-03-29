<?php 
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
    // include 'pages/headerIndex.php';
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
   </head>
   <?php include 'pages/headerIndex.php'; ?>
   <body>
      <div class="mainIndex">
         <form action="#" method="post">
               <input type="url" name="url" placeholder="Place Long Url eg:https://google.com">
               <input type="submit" name="submit" value="Short It">
               <?php echo $msg;?>
         </form>
   </body>
</html>