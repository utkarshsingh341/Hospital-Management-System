<?php

session_start();
include_once("connect.php");

//checking if session is set
if(isset($_SESSION['username'])){
    $session_username = $_SESSION['username'];
    $session_pass = $_SESSION['pass'];
    $session_id = $_SESSION['id'];

    //check if member exists
    $query = mysqli_query($con, "SELECT * FROM members WHERE id='$session_id' AND password='$session_pass' LIMIT 1 ") or die("Could not check member");
    $count_count = mysqli_num_rows($query);
    if($count_count > 0)
    {
        //logged in stuff here
        $logged = 1;

    }else{
        header("Location: logout.php");
        exit();
    }
}else if(isset($_COOKIE['id_cookie'])){
    $session_id = $_COOKIE['id_cookie'];
    $session_pass = $_COOKIE['pass_cookie'];

    //check if member exists
    $query = mysqli_query($con, "SELECT * FROM members WHERE id='$session_id' AND password='$session_pass' LIMIT 1 ") or die("Could not check member");
    $count_count = mysqli_num_rows($query);
    if($count_count > 0)
    {
        while($row = mysqli_fetch_array($query)){
            $session_username = $row['username'];
        }
        //create session
        $_SESSION['username'] = $session_username;
        $_SESSION['id'] = $session_id;
        $_SESSION['pass'] = $session_pass;

        //logged in stuff here
        $logged = 1;

    }else{
        header("Location: logout.php");
        exit();
    }
}else{
    $logged =0;
    
}

?>