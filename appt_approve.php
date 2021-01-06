<?php


include_once("scripts/global.php");

if(isset($_POST['appt_id']))
{
    $apt_id = $_POST['appt_id'];
    $apt_admin_id = $_POST['appt_admin_id'];


    $update_query = mysqli_query($con,"UPDATE appointment SET admin_id='$apt_admin_id', approved='1'  WHERE id='$apt_id'") or die ("Error query appt decline");
    header("Location: admin_appointment.php");

}

?>