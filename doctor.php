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


if(isset($_POST['designation']))
{
    $desig = $_POST['designation'];
    $contact = $_POST['contact'];

    $update_query = mysqli_query($con,"UPDATE doctor SET specification='$desig', contact='$contact' WHERE user_id='$session_id'") or die ("Error query 1");
    $update_query2 = mysqli_query($con,"UPDATE members SET about='1' WHERE id='$session_id'") or die ("Error query 2");

    

}

?>
<!doctype html>
<html lang="en">
  <head>
    <title>[DOCTOR] <?php print("$name"); ?></title>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
  
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
        
      <form action="doctor.php" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Specification</label>
          <input type="text" class="form-control" name="designation" required>
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
    <a class="nav-link active" href="#">Dashboard</a>
    <a class="nav-link"  style="cursor:pointer;" class="alert-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">Change Account Details</a>
    <a class="nav-link" href="doctor_appointment.php">View Appointments</a>
    <a class="nav-link" href="appointment.php">Start an Appointment</a>
  </nav>
</div>

<main class="container">
  <div class="d-flex align-items-center p-3 my-3 text-white bg-green rounded shadow-sm">
    <img class="me-3" src="img\icons8-doctor-female-64.png" alt="" width="38" height="38">
    <div class="lh-1">
      <h1 class="h6 mb-0 text-white lh-1">Doctor's Dashboard</h1>
      <small style="font-size:13px;">Dr. <?php print("$name"); ?> &middot; @<?php print("$username"); ?></small>
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
      <h5 class="card-title">Doctor Dashboard</h5>
      <p class="card-text">You have logged in on this Hospital Management System with the role of a <b>Doctor</b>. You can View Appointments, write Reports, View Medical History of your patients.</p>
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
      <p class="card-text">View the assigned appointments to you. &bull; Start these and explore the appointment dashboard!</p>
      <a href="#" class="btn btn-primary btn-sm">Visit Appointments Page</a>
    </div>
  </div>

  <div class="card fs-6">
    <div class="card-body">
      <h5 class="card-title">Pnuemonia Prediction Tool made with Deep Learning</h5>
      <p class="card-text">Deep Learning Tool to predict pnuemonia disease in patients based on observed patterns in lung X-rays!</p>
      <a href="#" class="btn btn-primary btn-sm">Use this tool!</a>
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
