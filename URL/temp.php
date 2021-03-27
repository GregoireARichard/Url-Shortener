<?php 
                    $url = "https://google.com";
                    header("location: " . $_COOKIE["UrlCookie"]);
                    $fileName = basename($_SERVER["PHP_SELF"]);
                    unlink($fileName);
        ?> 