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
<?php
if(isset($_POST['appt']))
{
    $appt_id = $_POST['appt'];
    $a_remarks = $_POST['a_remark'];
    $a_medicine = $_POST['a_med'];
    $a_visit = $_POST['a_visit'];


    $report_query = mysqli_query($con, "INSERT INTO report (appt_id, remarks, medicine, visit) VALUES ('$appt_id','$a_remarks','$a_medicine','$a_visit') ") or die("Could not enter report details!");
    $appointment_query = mysqli_query($con,"UPDATE appointment SET completed='1' WHERE id='$appt_id'") or die("Could not update appointment details");
    header("Location: doctor_appointment.php");

}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Appointment Dashboard</title>
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
  <?php

if($owner == true)
{
?>



<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-3 bg-dark border-bottom shadow-sm" style="color:white;">
  <p class="fs-6 my-0 me-md-auto fw-normal" style="font-weight:600;">Hospital Management System</p>
  <nav class="my-2 my-md-0 me-md-3 navs">
  </nav>
  <a class="btn btn-outline-primary btn-sm" href="doctor.php">Back to Home</a>
</header>

<div class="my-3 p-3 bg-white rounded shadow-sm" style="width: 80%; margin: 10px auto;">
    <h3 class="border-bottom pb-3 pt-2" style="margin:10px;">Appointment Dashboard</h3>
    <div class="d-flex text-muted pt-3">


    <div class="d-flex align-items-start">

      
      <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style=" width:200px;">
        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Select Appointment</a>
        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Deep Learning Tools</a>
        <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Appointment Report</a>
      </div>
      <form action="appointment.php" method="post" style="">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">


            <h6 class="border-bottom p-2" style="margin:10px;">Select appointment to begin</h6>
            <div class="report-form">
            <?php
                $apt_query = mysqli_query($con,"SELECT * FROM appointment WHERE approved='1' AND completed='0' ORDER BY id") or die("Could not select Appointment Table");
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

                    
                    $apt_adm_query = mysqli_query($con,"SELECT * FROM members WHERE id='$apt_admin_id' ") or die("Could not select admin");
                    $apt_adm_array = mysqli_fetch_array($apt_adm_query);

                    echo '
                    
                    <div class="label-radio">
                    <input type="radio" id="'.$apt_id.'" name="appt" value="'.$apt_id.'">
                    <label for="'.$apt_id.'">
                        Appointment with <a href="profile.php?id='.$apt_pat_id.'" target="_blank"> '.$apt_pat_array['name'].'</a>	&#8226; Date & Time -  '.$apt_date.' <br>
                        <small><b>Remarks:</b><i> '.$apt_rem.' </i></small><br>


                    </label>
                    </div>
                    
                                          
                        ';

                }
            ?>
            </div>

        </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">Deep Learning Pnuemonia Tool</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="card-link">Card link</a>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
          
                    <h6 class="border-bottom p-2" style="margin:10px;">Fill Appointment Report</h6>
                    <div class="report-form">
                    <label class="form-label">Give Remarks</label>
                    <textarea name="a_remark" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    <br>
                    <label class="form-label">Select Medicine</label>
                    <select class="form-select" name="a_med">

                        <?php
                        $med_query = mysqli_query($con,"SELECT * FROM medicine ORDER BY id") or die("Could not select Medicine Table");
                        while($med_row = mysqli_fetch_array($med_query))
                        {


                            $med_name = $med_row['med_name'];
                            $med_type = $med_row['type'];

                            echo '
                            
                                <option value="'.$med_name.'">'.$med_name.' ['.$med_type.']</option>

                            ';

                        }

                        ?>
                    </select><br>
                    <label class="form-label">Recommend for a future visit?</label> &nbsp;
                    <input type="radio" id="yes" name="a_visit" value="Yes">
                    <label for="yes">Yes</label>
                    <input type="radio" id="no" name="a_visit" value="No">
                    <label for="no">No</label><br><br>

                    <input type="submit" value="Submit & Finish Appointment!"  class="btn btn-primary"/>
             </div>
        </div>
      </div>
    </form>
    </div>

</div>

<?php

}

?>

</body>
</html>