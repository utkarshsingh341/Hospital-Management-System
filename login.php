<?php

include_once("scripts/global.php");
$message ="";
if(isset($_POST['email']))
{
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $remember = $_POST['remember'];


    $query = mysqli_query($con, "SELECT * FROM members WHERE email='$email' AND password='$pass' LIMIT 1") or die("Could not check member");
    $count_query = mysqli_num_rows($query);

    if($count_query == 0){
        $message = 'The information entered was incorrect!';
    }else{
        //start the sessions
        $_SESSION['pass'] = $pass;
        while($row = mysqli_fetch_array($query))
        {
            $username = $row['username'];
            $id = $row['id'];
            $role = $row['role'];
        }
        
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;

        if($remember == "yes")
        {
            //create the cookies
            setcookie("id_cookie",$id,time()+60*60*24*100,"/");
            setcookie("pass_cookie",$pass,time()+60*60*24*100,"/");
        }
        
                   
        if($role=='admin')
            {
                header("Location: admin.php?id=$id");
            }else if($role=='doctor'){
                header("Location: doctor.php?id=$id");
            }else if($role=='patient'){
                header("Location: patient.php?id=$id");
            }
        
        
    }

}
?>
<html>
    <head>
        <title>Login</title>
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
      <form action="login.php" method="post">
        <a href="index.php"><img class="mb-4" src="img\icon.png" alt="" width="72" height="72"></a>
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <p style="color:red;"><?php echo(" $message "); ?></p>
        <label for="inputEmail" class="visually-hidden">Email address</label>
        <input  type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="visually-hidden">Password</label>
        <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" name="remember" value="yes" checked="checked"> Remember me
          </label>
        </div>
        <input type="submit" class="w-100 btn btn-lg btn-primary"  value="Login!" />
        <p class="mt-5 mb-3 text-muted">&copy; 2020-21</p>
      </form>
    </main>
    
    
        
      </body>
</html>