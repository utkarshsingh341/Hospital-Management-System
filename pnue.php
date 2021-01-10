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

<main class="container">
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">Pnuemonia Predictor</h6>
    <div class="d-flex text-muted pt-0">
    <?php
        require_once "vendor/autoload.php";
        $client 	= new MongoDB\Client;
        $dataBase 	= $client->selectDatabase('pnuemo');
        $collection = $dataBase->selectCollection('images');
        if(isset($_POST['create'])) {
            $data 		= [
            ];

            if($_FILES['file']) {
            if(move_uploaded_file($_FILES['file']['tmp_name'], 'pnuemonia/image.jpg')) {
                $data['fileName'] = $_FILES['file']['name'];
            } else {
                echo "Failed to upload file.";
            }
            }

            $result = $collection->insertOne($data);
                if($result->getInsertedCount()>0) {
                    header("Location:run_pne.php");
                } else {
                    echo "Failed to create Article";
                }

        }

        ?>

    <form style="width:90%; margin:10px auto;" method="post" action="" enctype="multipart/form-data">
        <div class="mb-3 mt-3">
          <label for="exampleInputEmail1" class="form-label fs-6">Upload the lung X-ray image:-</label>
          <input id="file" name="file"  class="form-control" type="file" id="formFile">
        </div>
        <button type="submit" id="create" name="create" class="btn btn-primary mt-3">Submit your entry!</button>
    </form>
    </div>
</div>
</main>

<?php

}

?>

</body>
</html>