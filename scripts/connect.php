<?php

$con = mysqli_connect("localhost","root","","membership") or die("Could not connect to server");
if(mysqli_connect_errno())
{
	echo "failed to connect".mysqli_connect_errno();
}

?>