<?php 
require_once ('./imports/MysqliDb.php');

	$db = new MysqliDb (Array (
                'host' => 'localhost',
                'username' => 'root', 
                'password' => '',
                'db'=> 'file',
                'port' => 3306,
                'charset' => 'utf8_persian_ci'));
	
$delid = $_POST['delId'];
echo $delid;
// Delete record
$db->where("id" , $delid);
$db->delete("buy");
?>