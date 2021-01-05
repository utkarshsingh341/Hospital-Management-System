<?php


include_once("scripts/global.php");

if(isset($_POST['med_name']))
{
    $med_name = $_POST['med_name'];
    $med_type = $_POST['med_type'];
    $med_quant = $_POST['med_quant'];
    $med_price = $_POST['med_price'];
    $med_id = $_POST['med_id'];


    $update_query = mysqli_query($con,"UPDATE medicine SET med_name='$med_name', type='$med_type', quantity='$med_quant', price='$med_price' WHERE id='$med_id'") or die ("Error query medicine update");
    header("Location: medicine.php");

}

?>