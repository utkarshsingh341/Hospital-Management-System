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

    $update_query = mysqli_query($con,"UPDATE admin SET designation='$desig', contact='$contact' WHERE user_id='$session_id'") or die ("Error query 1");
    $update_query2 = mysqli_query($con,"UPDATE members SET about='1' WHERE id='$session_id'") or die ("Error query 2");

    

}

?>
<!doctype html>
<html lang="en">
  <head>
    <title>[ADMIN] <?php print("$name"); ?></title>
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
    <script src="sortable.js"></script>
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
        
      <form action="admin.php" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Designation</label>
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
    <a class="nav-link" href="admin.php">Dashboard</a>
    <a class="nav-link"  style="cursor:pointer;" class="alert-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">Change Account Details</a>
    <a class="nav-link" href="medicine.php">Medicine Inventory</a>
    <a class="nav-link active" href="#">Appointment List</a>
  </nav>
</div>

<main class="container">
  <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
    <img class="me-3" src="img\icons8-admin-settings-male-64.png" alt="" width="38" height="38">
    <div class="lh-1">
      <h1 class="h6 mb-0 text-white lh-1">Administrator's Dashboard</h1>
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
    <div class="d-flex text-muted pt-3">
        
    <table class="table table-striped m-3 fs-6 sortable">
        <thead>
            <tr>
            <th scope="col" style="cursor:pointer">Appt. ID</th>
            <th scope="col" style="cursor:pointer">Doctor</th>
            <th scope="col" style="cursor:pointer">Patient</th>
            <th scope="col" style="cursor:pointer">Date & Time</th>
            <th scope="col" style="cursor:pointer">Remarks</th>
            <th scope="col" style="cursor:pointer">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $apt_query = mysqli_query($con,"SELECT * FROM appointment WHERE approved='0' ORDER BY id") or die("Could not select Appointment Table");
                while($apt_row = mysqli_fetch_array($apt_query))
                {
                    $apt_id = $apt_row['id'];
                    $apt_doc_id = $apt_row['doctor_id'];
                    $apt_pat_id = $apt_row['patient_id'];
                    $apt_admin_id = $apt_row['admin_id'];
                    $apt_approved = $apt_row['approved'];
                    $apt_date = $apt_row['datetime'];
                    $apt_rem = $apt_row['remarks'];

                    $apt_doc_query = mysqli_query($con,"SELECT * FROM members WHERE id='$apt_doc_id' ") or die("Could not select doctor - member");
                    $apt_doc_array = mysqli_fetch_array($apt_doc_query);

                    $apt_pat_query = mysqli_query($con,"SELECT * FROM members WHERE id='$apt_pat_id' ") or die("Could not select doctor - member");
                    $apt_pat_array = mysqli_fetch_array($apt_pat_query);

                    $apt_approve_modal= "approve_".''.$apt_id;
                    $apt_decline_modal= "decline_".''.$apt_id;


                    echo '<tr>
                        <td scope="row">'.$apt_id.'</td>
                        <td>'.$apt_doc_array['name'].'</td>
                        <td>'.$apt_pat_array['name'].'</td>
                        <td>'.$apt_date.'</td>
                        <td>'.$apt_rem.'</td>
                        <td><a style="cursor:pointer;" class=""  data-bs-toggle="modal" data-bs-target="#'.$apt_approve_modal.'">Approve</a> / <a style="cursor:pointer;" class=""  data-bs-toggle="modal" data-bs-target="#'.$apt_decline_modal.'">Decline</a></td>
                        </tr>
                        
                        
                        <!-- Approve Modal -->
                        <div class="modal fade" id="'.$apt_approve_modal.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Approve appointment?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to <b>APPROVE</b> this appointment?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form action="appt_approve.php" method="post">
                                    <input type="hidden" name="appt_id" value="'.$apt_id.'" />
                                    <input type="hidden" name="appt_admin_id" value="'.$session_id.'" />
                                    <input type="submit" class="btn btn-primary" value="Yes, Approve!" />
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>

                        <!-- Decline Modal -->
                        <div class="modal fade" id="'.$apt_decline_modal.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Decline Approintment Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to <b>DECLINE</b> the appointment request made? Your decision will be final and cannot be edited later.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form action="appt_decline.php" method="post">
                                    <input type="hidden" name="appt_id" value="'.$apt_id.'" />
                                    <input type="hidden" name="appt_admin_id" value="'.$session_id.'" />
                                    <input type="submit" class="btn btn-primary" value="Go ahead, Decline!" />
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>
                        
                        
                        
                        
                        ';

                }
            ?>
        </tbody>
        </table>
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
