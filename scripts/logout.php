<?php 

session_start();

session_destroy();
if(isset($_COOKIE['id_cookie'])){
    setcookie("id_cookie", "", time()-50000, "/");
    setcookie("pass_cookie", "", time()-50000, "/");
}

if(isset($_COOKIE['username'])){
    echo("We could not log you out. Please try agian");
    exit();
}else{
    header("Location:index.php");
}

?>