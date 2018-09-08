<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "file");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$type = mysqli_real_escape_string($link, $_REQUEST['type']);
$area = mysqli_real_escape_string($link, $_REQUEST['area']);
$mortgage = mysqli_real_escape_string($link, $_REQUEST['mortgage']);
$rent = mysqli_real_escape_string($link, $_REQUEST['rent']);
$hold = mysqli_real_escape_string($link, $_REQUEST['hold']);
$floors = mysqli_real_escape_string($link, $_REQUEST['floors']);
$floor = mysqli_real_escape_string($link, $_REQUEST['floor']);
$upf = mysqli_real_escape_string($link, $_REQUEST['upf']);
$unit = mysqli_real_escape_string($link, $_REQUEST['unit']);
$cold_heat = mysqli_real_escape_string($link, $_REQUEST['cold_heat']);
$parking = mysqli_real_escape_string($link, $_REQUEST['parking']);
$elevator = mysqli_real_escape_string($link, $_REQUEST['elevator']);
$terrace = mysqli_real_escape_string($link, $_REQUEST['terrace']);
$facades = mysqli_real_escape_string($link, $_REQUEST['facades']);
$kitchen = mysqli_real_escape_string($link, $_REQUEST['kitchen']);
$service = mysqli_real_escape_string($link, $_REQUEST['service']);
$phone = mysqli_real_escape_string($link, $_REQUEST['phone']);
$owner = mysqli_real_escape_string($link, $_REQUEST['owner']);
$address = mysqli_real_escape_string($link, $_REQUEST['address']);
$discription = mysqli_real_escape_string($link, $_REQUEST['discription']);
$caseId = $_REQUEST['case_id'];
// attempt insert que<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

// attempt insert query execution
$sql = "UPDATE buy set type = '$type', area = '$area', total_price = '$total_price',hold = '$hold',floors = '$floors',floor = '$floor',upf = '$upf',unit = '$unit',cold_heat = '$cold_heat',parking = '$parking',elevator = '$elevator',terrace = '$terrace',facades='$facades',kitchen='$kitchen',service='$service',phone='$phone',address='$address',discription='$discription', owner='$owner' WHERE id = '$caseId' ";
if(mysqli_query($link, $sql)){
    // echo "Records added successfully.";
    header('Location: http://localhost://file/index.php');
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// close connection
mysqli_close($link);
?>