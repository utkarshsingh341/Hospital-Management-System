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
<?php


if(isset($_POST['app_doc']))
{

    $app_doc = $_POST['app_doc'];
    $app_date = $_POST['app_date'];
    $app_rem = $_POST['app_rem'];

    $app_query = mysqli_query($con, "INSERT INTO appointment (patient_id, doctor_id, approved, datetime, remarks) VALUES ('$session_id', '$app_doc', '0', '$app_date', '$app_rem')") or die("Could not book appointment");
    header("Location: patient_appointment.php");

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

<!-- Appointment Book Modal -->
<div class="modal fade" id="appointmentBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Medicine Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      <form action="patient_appointment.php" method="post">

        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Select your Doctor for the appointment</label>
          <select class="form-select" aria-label="Default select example" name="app_doc" required>
            <optgroup label="Please select the Doctor">

            <?php


$app_query = mysqli_query($con,"SELECT * FROM doctor ORDER BY id") or die("Could not select Doctor Table");

while($app_row = mysqli_fetch_array($app_query))
{

    $app_doc_id = $app_row['user_id'];
    $app_doc_spec = $app_row['specification'];


    $app_doc_query = mysqli_query($con,"SELECT * FROM members WHERE id='$app_doc_id' ") or die("Could not select admin");
    $app_doc_array = mysqli_fetch_array($app_doc_query);

    echo '
    
        <option value="'.$app_doc_id.'">'.$app_doc_array['name'].' ['.$app_doc_spec.']</option>

    ';


}

            ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Select the Date & Time for appointment</label>
          <input type="datetime-local" class="form-select" name="app_date" required>
        </div>

        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Any additional remarks you may want to leave</label>
          <textarea class="form-control" name="app_rem" required>Remarks...</textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Book Appointment!" />
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
    <a class="nav-link " href="patient.php">Dashboard</a>
    <a class="nav-link"  style="cursor:pointer;" class="alert-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">Change Account Details</a>
    <a class="nav-link active" href="patient_appointment.php">Appointments Section</a>
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



  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">Appointments</h6>
    <div class="d-flex text-muted pt-0">
      
    <table class="table table-striped m-3">
        <thead>
            <tr>
            <th scope="col">Appt. ID</th>
            <th scope="col">Doctor</th>
            <th scope="col">Status</th>
            <th scope="col">Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $apt_query = mysqli_query($con,"SELECT * FROM appointment WHERE patient_id='$session_id' ORDER BY id DESC") or die("Could not select Appointment Table");
                while($apt_row = mysqli_fetch_array($apt_query))
                {
                    $apt_id = $apt_row['id'];
                    $apt_doc_id = $apt_row['doctor_id'];
                    $apt_admin_id = $apt_row['admin_id'];
                    $apt_approved = $apt_row['approved'];
                    $apt_date = $apt_row['datetime'];

                    $apt_doc_query = mysqli_query($con,"SELECT * FROM members WHERE id='$apt_doc_id' ") or die("Could not select doctor - member");
                    $apt_doc_array = mysqli_fetch_array($apt_doc_query);

                    $apt_docspec_query = mysqli_query($con,"SELECT * FROM doctor WHERE user_id='$apt_doc_id' ") or die("Could not select doctor - spec ");
                    $apt_docspec_array = mysqli_fetch_array($apt_docspec_query);

                    echo '<tr>
                        <td scope="row">'.$apt_id.'</td>
                        <td>'.$apt_doc_array['name'].' ['.$apt_docspec_array['specification'].']</td>
                    
                    ';

                    if($apt_approved == '0')
                    {
                        echo '<td>Yet to be reviewed.</td>';
                    }

                    echo '
                    <td>'.$apt_date.'</td>
                    </tr>';

                }
            ?>
        </tbody>
        </table>

    </div>
    <small class="d-block text-end mt-3">
      <a style="cursor:pointer;" class="alert-link px-3"  data-bs-toggle="modal" data-bs-target="#appointmentBookModal"> + book a new appointment</a>
    </small>
  </div>

 
</main>

<?php

            }

        ?>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="offcanvas.js"></script>
  </body>
</html>
