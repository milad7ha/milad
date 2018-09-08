<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$database_file = file_get_contents("database.json");
$database_info = json_decode($database_file);

$username = $database_info->username;
$servername = $database_info->servername;
$password = $database_info->password;
$database_name = "file";

// // Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    // header("Location: ./initial.php");
    echo "Error creating database: " . $conn->connect_error;
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . $database_name . " CHARACTER SET utf8 COLLATE utf8_bin;";
if ($conn->query($sql) === TRUE) {
    // echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

include("./imports/MysqliDb.php");

// database init
$db =  new MysqliDb ($servername, $username, $password, $database_name);

// adding functinos
include("database.php");
if(! $db->tableExists('buy'))
{
	createTable("users" , $users);
	createTable("rental" , $rental);
	createTable("buy" , $buy);
	
}
?>