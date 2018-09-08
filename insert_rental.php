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
$address = mysqli_real_escape_string($link, $_REQUEST['address']);
$discription = mysqli_real_escape_string($link, $_REQUEST['discription']);
$shared = mysqli_real_escape_string($link, $_REQUEST['shared']);
$owner = mysqli_real_escape_string($link, $_REQUEST['owner']);
$userId = $_REQUEST['user_id'];
// attempt insert query execution
$sql = "INSERT INTO rental (user_id,type, area, mortgage, rent,hold,floors,floor,upf,unit,cold_heat,parking,elevator,terrace,facades,kitchen,service,phone,address,discription,shared, owner) VALUES ('$userId', '$type', '$area', '$mortgage', '$rent' , '$hold' ,'$floors' , '$floor','$upf' , '$unit','$cold_heat','$parking','$elevator','$terrace','$facades','$kitchen','$service','$phone', '$address','$discription', '$shared', '$owner')";
if(mysqli_query($link, $sql)){
    // echo "Records added successfully.";
    header('Location: http://localhost://file/index.php');
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// close connection
mysqli_close($link);
?>