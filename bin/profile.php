<?php

include_once("scripts/global.php");
if($logged==0)
{
    header("Location: index.php");
    exit();
}

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$id = preg_replace("#[^0-9]#", "", $id);
 }else{
    $id = $_SESSION['id'];
 }

//collect the member information
$query = mysqli_query($con, "SELECT * FROM members WHERE id='$id' LIMIT 1") or die ("Could not check user information");
$count_mem = mysqli_num_rows($query);
if($count_mem == 0){
   echo ("The user does not exists");  
   exit();
}
while($row = mysqli_fetch_array($query)){
    $username = $row['username'];
    $name = $row['name'];
    $email = $row['email'];
    $role = $row['role'];
    $profile_id = $row['id'];

    if($session_id == $profile_id){
        $owner = true;
       }else{
        $owner = false;
       }
       
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php print("$name"); ?></title>
    </head>
    <body>
    <a href="index.php">Home</a> | <a href="logout.php">Logout</a>
        <br><br>

        <h1>[<?php print("$role"); ?>] Logged In Display</h1>
        
    </body>
</html>