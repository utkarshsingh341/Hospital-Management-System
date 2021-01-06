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
    <a class="nav-link" href="#">Dashboard</a>
    <a class="nav-link"  style="cursor:pointer;" class="alert-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">Change Account Details</a>
    <a class="nav-link" href="#">View Appointments</a>
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


  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>

      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
      </p>
    </div>
    <small class="d-block text-end mt-3">
      <a href="#">All updates</a>
    </small>
  </div>

  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">Suggestions</h6>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>

      <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
        <div class="d-flex justify-content-between">
          <strong class="text-gray-dark">Full Name</strong>
          <a href="#">Follow</a>
        </div>
        <span class="d-block">@username</span>
      </div>
    </div>
    <small class="d-block text-end mt-3">
      <a href="#">All suggestions</a>
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
