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
$pat_query = mysqli_query($con, "SELECT * FROM patient WHERE user_id='$profile_id' LIMIT 1") or die ("Could not check patient information");
    while($pat_row = mysqli_fetch_array($pat_query)){
        $age = $pat_row['age'];
        $gender = $pat_row['gender'];
        $phone = $pat_row['contact'];

        
    }

?>
<!DOCTYPE html>
<html>
    <head>
    <title>[PATIENT] <?php print("$name"); ?></title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body class="bg-light">
    
  <header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-3 bg-dark border-bottom shadow-sm" style="color:white;">
    <p class="fs-6 my-0 me-md-auto fw-normal" style="font-weight:600;">Hospital Management System</p>
    <nav class="my-2 my-md-0 me-md-3 navs">
    </nav>
    <a class="btn btn-outline-primary btn-sm" href="home.php">Back to Home</a>
  </header>

<?php 

      if($role=="patient")
      {

?>

<div class="my-3 p-3 bg-white rounded shadow-sm" style="width: 70%; margin: 10px auto;">
    <h6 class="border-bottom pb-2 mb-0">Patient Information</h6>
    <div class="d-flex text-muted pt-3">
      <p class="pb-3 mb-0 small lh-sm border-bottom">
      <ul class="list-group" style="width: 100%;">
        <li class="list-group-item"><b>Name of the Patient: </b><?php print("$name"); ?></li>
        <li class="list-group-item"><b>Hospital System Username: </b><?php print("$username"); ?></li>
        <li class="list-group-item"><b>Patient's Age: </b><?php print("$age"); ?></li>
        <li class="list-group-item"><b>Patient's Gender: </b><?php print("$gender"); ?></li>
        <li class="list-group-item"><b>Email Address: </b><?php print("$email"); ?></li>
        <li class="list-group-item"><b>Phone Number / Contact Information: </b><?php print("$phone"); ?></li>
      </ul>
      </p>
    </div>
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm" style="width: 70%; margin: 10px auto;">
    <h6 class="border-bottom pb-2 mb-0">Medical History</h6>
    <div class="pt-3">
    <?php
require_once "vendor/autoload.php";
$client 	= new MongoDB\Client;
$dataBase 	= $client->selectDatabase('medical');
$collection = $dataBase->selectCollection('articles');

          $articles = $collection->find();
          foreach ($articles as $key => $article) {
            $UTCDateTime 	= new MongoDB\BSON\UTCDateTime((string)$article['createdOn']);
            $DateTime 		= $UTCDateTime->toDateTime();

            $data = json_encode( [
            'id' 			=> (string) $article['_id'],
            'title' 		=> $article['title'],
            'description' 	=> $article['description'],
            'author' 		=> $article['author'],
            'patient_id' 		=> $article['patient_id'],
            'fileName' 		=> $article['fileName']
          ], true);

            if(($article['patient_id'])==$profile_id)
            {
              echo '
            

              <div class="card" style="width: 100%; margin:10px auto">
            <div class="card-body">
              <h5 class="card-title">'.$article['title'].'</h5>
              <h6 class="card-subtitle mb-2 text-muted">Uploaded on '.$DateTime->format('d/m/Y H:i:s').'</h6>
              <p class="card-text">
              '.$article['description'].'<br><br>
                <b>Duration: </b>'.$article['author'].'
              </p>
              <a href="upload/'.$article['fileName'].'" target="_blank" class="card-link">&#10149; Open Proof/Relating Document uploaded</a>
            </div>
          </div>
              ';
            }

           
          }
        ?>
        
    </div>
  </div>
<?php

      }

?>

        
    </body>
</html>