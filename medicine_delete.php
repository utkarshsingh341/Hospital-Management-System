<?php


include_once("scripts/global.php");

if(isset($_POST['med_id']))
{
    $med_id = $_POST['med_id'];


    $update_query = mysqli_query($con,"DELETE FROM medicine WHERE id='$med_id'") or die ("Error query medicine delete");
    header("Location: medicine.php");

}

?>