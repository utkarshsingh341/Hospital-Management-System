<?php

include_once("scripts/global.php");

if(isset($_POST['username']))
{
    $username = $_POST['username'];
    $fullname = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = $_POST['role'];

    $query = mysqli_query($con,"INSERT INTO members (username, name, email, password, role, sign_up_date, about) VALUES ('$username', '$fullname', '$email', '$pass', '$role', now(), '0' ) ") or die("Could not insert data");
    
    $querr = mysqli_query($con,"SELECT id FROM members") or die ("Could not select latest user");
    $rows = mysqli_num_rows($querr);
    $member_id = $rows;
    
    
    if($role == 'admin')
    {

      $query1 = mysqli_query($con, "INSERT INTO admin (user_id) VALUES ('$member_id') ") or die("Could not enter in admin database");

    }else if($role == 'doctor'){

      $query2 = mysqli_query($con, "INSERT INTO doctor (user_id) VALUES ('$member_id') ") or die("Could not enter in admin database");

    }else if($role == 'patient'){

      $query3 = mysqli_query($con, "INSERT INTO patient (user_id) VALUES ('$member_id') ") or die("Could not enter in admin database");

    }
    header("Location: login.php");


}

?>
<html>
    <head>
        <title>Register</title>
        <!-- Bootstrap core CSS -->
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
        <link href="login.css" rel="stylesheet">
    </head>
    <body class="text-center">
    
    <main class="form-signin">
      <form action="register.php" method="post">
        <a href="index.php"><img class="mb-4" src="img\icon.png" alt="" width="72" height="72"></a>
        <h1 class="h3 mb-3 fw-normal">Register below!</h1>

        <input type="text" name="username" class="form-control" placeholder="Username" required />
        <input type="text" name="name" class="form-control" placeholder="Full Name" required />
        <input type="email" name="email" class="form-control" placeholder="Email Address" required />
        <input type="password" name="password" class="form-control" placeholder="Password" required />
        <select name="role" class="form-control form-select" required>
                <optgroup label="Select a type of user">
                <option value="patient">Patient</option>
                <option value="admin">Admin</option>
                <option value="doctor">Doctor</option>
        </select>

        <br>
        <input type="submit" class="w-100 btn btn-lg btn-primary"  value="Register!" />
      </form>
    </main>
    
      </body>
</html>