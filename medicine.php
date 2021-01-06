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
<?php


if(isset($_POST['med_name']))
{
    $med_name = $_POST['med_name'];
    $med_type = $_POST['med_type'];
    $med_quant = $_POST['med_quant'];
    $med_price = $_POST['med_price'];

    $update_query = mysqli_query($con,"INSERT INTO medicine (admin_id, med_name, type, quantity, price) VALUES ('$session_id','$med_name','$med_type','$med_quant','$med_price')") or die ("Error query medicine");
    header("Location: medicine.php");

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
  <!-- Medicine Modal -->
  <div class="modal fade" id="medicineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Medicine Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      <form action="medicine.php" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Name of the medicine</label>
          <input type="text" class="form-control" name="med_name" required>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Type of medicine</label>
          <select class="form-select" aria-label="Default select example" name="med_type">
            <optgroup label="Please select type of medicine">
            <option value="Tablets">Tablets</option>
            <option value="Capsule">Capsule</option>
            <option value="Syrups & Liquid">Syrups & Liquid</option>
            <option value="Creams & Ointments">Creams & Ointments</option>
            <option value="Injectors">Injectors</option>
            <option value="Drops">Drops (eg. ear-drop, eye-drops)</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Quantity of the medicine</label>
          <input type="text" class="form-control" name="med_quant" required>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Price of single quantity <small><i>(in Ruppees)</i></small></label>
          <input type="text" class="form-control" name="med_price" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add Entry to database!" />
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
    <a class="nav-link" style="cursor:pointer;" class="alert-link"  data-bs-toggle="modal" data-bs-target="#exampleModal">Change Account Details</a>
    <a class="nav-link active" href="medicine.php">Medicine Inventory</a>
    <a class="nav-link" href="admin_appointment.php">Appointment List</a>
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
    <h6 class="border-bottom pb-2 mb-0">Medicine Inventory</h6>
    <div class="d-flex text-muted pt-1">

    <table class="table table-striped m-3 fs-6 sortable">
      <thead>
        <tr>
          <th scope="col" style="cursor:pointer">#</th>
          <th scope="col" style="cursor:pointer">Medicine Name</th>
          <th scope="col" style="cursor:pointer">Type</th>
          <th scope="col" style="cursor:pointer">Quantity</th>
          <th scope="col" style="cursor:pointer">Price <small><i>(Per quantity)</i></small></th>
          <th scope="col" style="cursor:pointer">Added by</th>
          <th scope="col" style="cursor:pointer">Change</th>
        </tr>
      </thead>
      <tbody>


<?php

$med_query = mysqli_query($con,"SELECT * FROM medicine ORDER BY id") or die("Could not select Medicine Table");

while($med_row = mysqli_fetch_array($med_query))
{

$meds_id = $med_row['id'];
$meds_admin_id = $med_row['admin_id'];
$meds_name = $med_row['med_name'];
$meds_type = $med_row['type'];
$meds_quant = $med_row['quantity'];
$meds_price = $med_row['price'];

$med_admin_query = mysqli_query($con,"SELECT * FROM members WHERE id='$meds_admin_id' ") or die("Could not select admin");
$meds_admin = mysqli_fetch_array($med_admin_query);

$meds_edit_modal= "edit_".''.$meds_id;
$meds_delete_modal= "delete_".''.$meds_id;

echo '<tr> 
                  <td>'.$meds_id.'</td> 
                  <td>'.$meds_name.'</td> 
                  <td>'.$meds_type.'</td> 
                  <td>'.$meds_quant.'</td> 
                  <td>Rs. '.$meds_price.'</td> 
                  <td>@'.$meds_admin['username'].'</td>
                  <td> <a style="cursor:pointer;" class=""  data-bs-toggle="modal" data-bs-target="#'.$meds_edit_modal.'">Edit</a> / <a style="cursor:pointer;" class=""  data-bs-toggle="modal" data-bs-target="#'.$meds_delete_modal.'">Remove</a></td>
              </tr>


              <!-- Medicine Edit Modal -->
              <div class="modal fade" id="'.$meds_edit_modal.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Medicine Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    
                  <form action="medicine_edit.php" method="post">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Name of the medicine</label>
                      <input type="text" class="form-control" name="med_name" value="'.$meds_name.'" required>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Type of medicine</label>
                      <select class="form-select" aria-label="Default select example" name="med_type">
                        <optgroup label="Please select type of medicine">
                        <option value="Tablets">Tablets</option>
                        <option value="Capsule">Capsule</option>
                        <option value="Syrups & Liquid">Syrups & Liquid</option>
                        <option value="Creams & Ointments">Creams & Ointments</option>
                        <option value="Injectors">Injectors</option>
                        <option value="Drops">Drops (eg. ear-drop, eye-drops)</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Quantity of the medicine</label>
                      <input type="text" class="form-control" name="med_quant" value="'.$meds_quant.'" required>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Price of single quantity <small><i>(in Ruppees)</i></small></label>
                      <input type="text" class="form-control" name="med_price" value="'.$meds_price.'" required>
                    </div>
                    
                    <input type="hidden" name="med_id" value="'.$meds_id.'">                    

            
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Make Changes!" />
                  </div>
                    </form>
                </div>
              </div>
            </div>
            <!-- Medicine Delete Modal -->
            <div class="modal fade" id="'.$meds_delete_modal.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this medicine entry? The medicine will be removed from the inventory.
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Dont Remove</button>
                    

                    <form action="medicine_delete.php" method="post">
                      <input type="hidden" name="med_id" value="'.$meds_id.'">
                      <input type="submit" class="btn btn-primary" value="Confirm!" />
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
    
    <small class="d-block text-end mt-3">
      <a style="cursor:pointer;" class="alert-link px-3"  data-bs-toggle="modal" data-bs-target="#medicineModal"> + new medicine entry</a>
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
