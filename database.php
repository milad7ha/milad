<?php

$users = Array(
    'username' => 'varchar(255) ',
    'password' => 'varchar(255)',
    'mobile' => 'varchar(255)',
    'address' => 'varchar(255)'
);

$rental = Array(
    'user_id' => 'int(11)',
    'type' => 'varchar(255)',
    'area' => 'int(100)',
    'mortgage' => 'varchar(100)',
    'rent' => 'varchar(100)',
    'address' => 'varchar(100)',
    'floors' => 'varchar(100)',
    'floor' => 'varchar(100)',
    'upf' => 'varchar(100)',
    'unit' => 'varchar(100)',
    'terrace' => 'varchar(100)',
    'service' => 'varchar(100)',
    'kitchen' => 'varchar(100)',
    'hold' => 'varchar(100)',
    'elevator' => 'varchar(100)',
    'parking' => 'varchar(100)',
    'facades' => 'varchar(100)',
    'owner' => 'varchar(100)',
    'evacuation_date' => 'date',
    'shared' => 'varchar(16)',
    'discription' => 'text',
    'cold_heat' => 'varchar(255)',
    'phone' => 'text'

);


$buy = Array(
    'user_id' => 'int(11)',
    'type' => 'varchar(255)',
    'area' => 'int(100)',
    'total_price' => 'varchar(100)',
    'address' => 'varchar(100)',
    'floors' => 'varchar(100)',
    'floor' => 'varchar(100)',
    'upf' => 'varchar(100)',
    'unit' => 'varchar(100)',
    'terrace' => 'varchar(100)',
    'service' => 'varchar(100)',
    'kitchen' => 'varchar(100)',
    'hold' => 'varchar(100)',
    'elevator' => 'varchar(100)',
    'parking' => 'varchar(100)',
    'facades' => 'varchar(100)',
    'owner' => 'varchar(100)',
    'evacuation_date' => 'date',
    'shared' => 'varchar(16)',
    'discription' => 'text',
    'cold_heat' => 'varchar(255)',
    'phone' => 'text'

);
function createTable ($name, $data) {
    global $db;
    //$q = "CREATE TABLE $name (id INT(9) UNSIGNED PRIMARY KEY NOT NULL";
    $db->rawQuery("DROP TABLE IF EXISTS $name");
    $q = "CREATE TABLE `$name` (id INT(15) UNSIGNED PRIMARY KEY AUTO_INCREMENT";
    foreach ($data as $k => $v) {
        $q .= ", `$k` $v";
    }
    $q .= ");";
    // echo $q;
    // echo "<br>";
    $db->rawQuery($q);
}

?>