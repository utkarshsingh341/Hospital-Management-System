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
    $about = $row['about'];

    if($session_id == $profile_id){
        $owner = true;
       }else{
        $owner = false;
       }
       
}
?>
<?php


if(isset($_POST['gender']))
{
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];

    $update_query = mysqli_query($con,"UPDATE patient SET gender='$gender', age='$age', contact='$contact' WHERE user_id='$session_id'") or die ("Error query 1");
    $update_query2 = mysqli_query($con,"UPDATE members SET about='1' WHERE id='$session_id'") or die ("Error query 2");

    

}

?>
<!doctype html>
<html lang="en">
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
  
  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Complete Registration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      <form action="patient.php" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Gender</label>
          <select class="form-select" aria-label="Default select example" name="gender">
            <optgroup label="Please select your gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Age</label>
          <input type="text" class="form-control" name="age" required>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Contact number</label>
          <input type="text" class="form-control" name="contact" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Save Changes!" />
      </div>
        </form>
    </div>
  </div>
</div>
  <?php

if($owner == true)
{
?>



<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-3 bg-dark border-bottom shadow-sm" style="color:white;">
  <p class="fs-6 my-0 me-md-auto fw-normal" style="font-weight:600;">Hospital Management System</p>
  <nav class="my-2 my-md-0 me-md-3 navs">
  </nav>
  <a class="btn btn-outline-primary btn-sm" href="logout.php">Logout</a>
</header>

<div class="nav-scroller bg-white shadow-sm">
  <nav class="nav nav-underline nav2" aria-label="Secondary navigation">
    <a class="nav-link" href="patient.php">Dashboard</a>
    <a class="nav-link"  style="cursor:pointer;" class="alert-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">Change Account Details</a>
    <a class="nav-link" href="patient_appointment.php">Appointments Section</a>
    <a class="nav-link active" href="med_history_add.php">Medical History</a>
  </nav>
</div>

<main class="container">
  <div class="d-flex align-items-center p-3 my-3 text-white bg-red rounded shadow-sm">
    <img class="me-3" src="img\icons8-patient-oxygen-mask-100.png" alt="" width="38" height="38">
    <div class="lh-1">
      <h1 class="h6 mb-0 text-white lh-1">Patients Dashboard</h1>
      <small style="font-size:13px;"><?php print("$name"); ?> &middot; @<?php print("$username"); ?></small>
    </div>
  </div>
  
<?php

if($about=='0')
{

?>


<div class="alert alert-warning fs-6" role="alert">
Please fill your account details to complete your registration. <a style="cursor:pointer;" class="alert-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">Click here to complete it.</a>
</div>



<?php


}


?>

<?php
  require_once "vendor/autoload.php";
  $client 	= new MongoDB\Client;
  $dataBase 	= $client->selectDatabase('medical');
  $collection = $dataBase->selectCollection('articles');
  if(isset($_POST['create'])) {
    $data 		= [
      'title' 		=> $_POST['title'],
      'description' 	=> $_POST['description'],
      'author' 		=> $_POST['author'],
      'patient_id' => $_POST['patient_id'],
      'createdOn' 	=> new MongoDB\BSON\UTCDateTime
    ];

    if($_FILES['file']) {
      if(move_uploaded_file($_FILES['file']['tmp_name'], 'upload/'.$_FILES['file']['name'])) {
        $data['fileName'] = $_FILES['file']['name'];
      } else {
        echo "Failed to upload file.";
      }
    }

    $result = $collection->insertOne($data);
		if($result->getInsertedCount()>0) {
			echo "<div class='alert alert-success' role='alert'>
      Medical History Successfully Uploaded!
    </div>";
		} else {
			echo "Failed to create Article";
		}

  }

?>
<div class="accordion shadow-sm" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Add your Medical History
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">

      <form style="width:90%; margin:10px auto;" method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label fs-6">Title of the Entry</label>
          <input id="title" name="title" type="text" class="form-control" required>
          <div id="emailHelp" class="form-text">Give a title to your medical history entry.</div>
        </div>
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label fs-6">Description</label>
          <textarea id="description" name="description" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label fs-6">Duration of this condition</label>
          <input id="author" name="author"  type="text" class="form-control">
          <div id="emailHelp" class="form-text">Give the time duration you were affected by this condition.</div>
        </div>
        <div class="mb-3 mt-3">
          <label for="exampleInputEmail1" class="form-label fs-6">Upload Proof/Relating Documents</label>
          <input id="file" name="file"  class="form-control" type="file" id="formFile">
        </div>
        <input name="patient_id" value="<?php print("$session_id"); ?>"  class="form-control" type="hidden">
        <button type="submit" id="create" name="create" class="btn btn-primary mt-3">Submit your entry!</button>
      </form>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        View your Medical History
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <?php


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

            if(($article['patient_id'])==$session_id)
            {
              echo '
            

              <div class="card" style="width: 90%; margin:10px auto">
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
  </div>
</div>

</main>

<?php

            }

        ?>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="offcanvas.js"></script>
  </body>
</html>
