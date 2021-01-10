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
    <a class="nav-link active" href="patient.php">Dashboard</a>
    <a class="nav-link"  style="cursor:pointer;" class="alert-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">Change Account Details</a>
    <a class="nav-link" href="patient_appointment.php">Appointments Section</a>
    <a class="nav-link" href="med_history_add.php">Medical History</a>
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


<div class="container" style="">
  <div class="row" style="width:100%">
  <div class="col-3 bg-light">
    
  <div class="card fs-6" style="">
    <div class="card-body">
      <h5 class="card-title">Patient Dashboard</h5>
      <p class="card-text">You have logged in on this Hospital Management System with the role of a <b>Patient</b>. You can Book Appointments, View your Appointment Reports, Add your Medical History for doctors to view.</p>
    </div>
    <div class="card-body">
      <a href="#" class="card-link">&#10149; View all features here</a>
    </div>
  </div>

  </div>
  <div class="col-sm-9 bg-light">
    


  <div class="card fs-6">
    <div class="card-header">
      Featured
    </div>
    <div class="card-body">
      <h5 class="card-title">Appointments Section</h5>
      <p class="card-text">Book appointments with Doctors & View its status &bull; View Reports of the appointments you've attended!</p>
      <a href="#" class="btn btn-primary btn-sm">Visit Appointments Page</a>
    </div>
  </div>

  <div class="card fs-6">
    <div class="card-body">
      <h5 class="card-title">Medical History Dashboard</h5>
      <p class="card-text">Add your Medical History for doctors to view before appointments &bull; View previously uploaded documents</p>
      <a href="#" class="btn btn-primary btn-sm">Go to dashboard</a>
    </div>
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
