<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "file");
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$area = 0 ;
if(isset($_REQUEST['area'])){
    $area = $_REQUEST['area'];
}
$total_price = 0 ;
if(isset($_REQUEST['total_price'])){
    $total_price = $_REQUEST['total_price'];
}


 
if(isset($_REQUEST['type'])){
    // Prepare a select statement
    $sql = "SELECT * FROM buy WHERE type LIKE ? and shared='on' and area >= $area  and total_price >= $total_price ORDER BY  id DESC";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST['type'] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "

                    <div class=\"case my-4 \" id=\"b".$row['id'] . "\">

                                            
                    <div class=\"row buyf". $row["id"] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >نوع :" . $row["type"] . 
                                                "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >متراژ :" .$row["area"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >قیمت کل :" .$row["total_price"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >سن : " . $row["hold"]. "</div>
                                            </div>
                                            <div class=\"row buyf" . $row['id'] ."\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تعداد طبقات : " .$row["floors"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >طبقه : ".$row["floor"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تعداد واحد در طبقه :" . $row["upf"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >واحد :" .$row["unit"] . "</div>
                                            </div> 

                                            <div class=\"row buyf". $row['id'] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >گرمایش-سرمایش :" . $row["cold_heat"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >پارکینگ : "  . $row["parking"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >آسانسور:" . $row["elevator"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تراس : " . $row["terrace"] . "</div>
                                            </div>
                                            <div class=\"row buyf". $row['id'] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >نما، پوشش:" . $row["facades"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >کابینت :" . $row["kitchen"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >سرویس: " . $row["service"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >شماره تماس :" .  $row["phone"] . "</div>                                                
                                            </div>
                                            <div class=\"row buyf" . $row['id'] . "\" style=\"text-align: right;\">
                                                <div class=\"col-12 col-md-12 col-lg-12 col-sm-12 case-info\">آدرس :" . $row["address"] . "</div>
                                                
                                            </div>
                                            <div class=\"row buyf". $row['id']. "\" style=\"text-align: right;\">
                                                <div class=\"col-12\">توضیحات: " . $row["discription"] . "</div>
                                            </div>
                                            </div>";


                }
            } else{
                echo "<p>موردی یافت نشد</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>