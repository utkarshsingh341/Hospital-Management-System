<?php

include_once("scripts/global.php");
if($logged==1)
{
    header("Location: home.php");
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Hospital Management System</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.42/css/uikit.min.css" />
    <link rel="stylesheet" href="main.css" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.42/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.42/js/uikit-icons.min.js"></script>
</head>
<body>
<div class="main">
            <div class="navbar">
                <table class="nav-table">
                    <tr>
                        <td class="left-nav">
                            <h2 class="nav-h2"><span style="color: #5252ec; letter-spacing: 3px;">// </span>DBD & SE Lab</h2>
                        </td>
                        <td class="right-nav uk-offcanvas-content">
                            <ul class="nav-ul">
                                <li><a href="">ABOUT</a></li>
                                <li><a href="">FAQs</a></li>
                                <li><a href="">FEATURES</a></li>
                                <li><a href="register.php">REGISTER AS A USER</a></li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="heading">
                <div class="uk-animation-slide-bottom-medium uk-animation-slow">
                    <h1 class="heading-h1">Hospital Management</h1>
                    <p class="heading-p">
						Computerizing the Front Office Management of Hospital into a software<br> which is user friendly, simple, fast, and cost-effective
                    </p>
                    <button class="uk-button uk-button-primary heading-button"><a href="login.php"><span>LOGIN NOW!</span></a></button>
                </div>
            </div>
        </div>
</body>
</html>