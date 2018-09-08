<?php 
    require_once ('./imports/MysqliDb.php');

    $db = new MysqliDb (Array (
                'host' => 'localhost',
                'username' => 'root', 
                'password' => '',
                'db'=> 'file',
                'port' => 3306,
                'charset' => 'utf8_general_ci'));



$area = 0 ;
if(isset($_REQUEST['area'])){
    $area = $_REQUEST['area'];
}

$rent = 0 ;
if(isset($_REQUEST['rent'])){
    $rent = $_REQUEST['rent'];
}
$mortgage = 0 ;
if(isset($_REQUEST['mortgage'])){
    $mortgage = $_REQUEST['mortgage'];
}

$db->orderBy("id","Desc");
$db->join("users u", "u.id=r.user_id", "LEFT");
$db->where("r.shared", "on");
// $db->where("r.area >= ? or r.rent >= ? or r.mortgage >= ?", Array($area,$rent, $mortgage));
$cols = Array ("r.id","type", "area" , "mortgage", "rent" ,"floors", "floor" , "upf", "unit", "terrace", "service", "kitchen", "hold", "elevator" , "facades", "cold_heat", "mobile", "u.address" , "discription", "parking", "shared", "owner");
$rentals_shared = $db->get ("rental r", null, $cols);
if($db->count == 0){
                                            echo "<div class=\"text-center mt-4\"> در حال حاضر فایلی ندارید </div>";
                                        }else{
                                            foreach ($rentals_shared as $key => $row) {
                                                echo "<div class=\"case my-4 \" id=\"rent".$row['id'] . "\">
                    <div class=\"row\">
                                            <div class=\"col-6 col-sm-12\">
                                                کد :" . $row["id"]. " 
                                            </div>
                                        </div>
                                            
                    <div class=\"row rent". $row["id"] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >نوع :" . $row["type"] . 
                                                "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >متراژ :" .$row["area"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >رهن :" .$row["mortgage"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >اجاره : " . $row["rent"]. "</div>
                                            </div>
                                            <div class=\"row rent" . $row['id'] ."\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تعداد طبقات : " .$row["floors"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >طبقه : ".$row["floor"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تعداد واحد در طبقه :" . $row["upf"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >واحد :" .$row["unit"] . "</div>
                                            </div> 

                                            <div class=\"row rent". $row['id'] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >گرمایش-سرمایش :" . $row["cold_heat"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >پارکینگ : "  . $row["parking"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >آسانسور:" . $row["elevator"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تراس : " . $row["terrace"] . "</div>
                                            </div>
                                            <div class=\"row rent". $row['id'] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >نما، پوشش:" . $row["facades"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >کابینت :" . $row["kitchen"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >سرویس: " . $row["service"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >سن :" .  $row["hold"] . "</div>
                                                
                                            </div>
                                            <div class=\"row rent" . $row['id'] . "\" style=\"text-align: right;\">
                                                <div class=\"col-6 col-md-6 col-lg-6 col-sm-12 case-info\">آدرس :" . $row["address"] . "</div>
                                                <div class=\"col-6 col-md-6 col-lg-6 col-sm-12 case-info\">شماره تماس :" . $row["mobile"] . "</div>
                                            </div>
                                            <div class=\"row rent". $row['id']. "\" style=\"text-align: right;\">
                                                <div class=\"col-12\">توضیحات: " . $row["discription"] . "</div>
                                            </div>
                                            </div>";
                                            }

                                        }
?>


<!-- <?php
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
$rent = 0 ;
if(isset($_REQUEST['rent'])){
    $rent = $_REQUEST['rent'];
}
$mortgage = 0 ;
if(isset($_REQUEST['mortgage'])){
    $mortgage = $_REQUEST['mortgage'];
}
 // SELECT * FROM rental  WHERE type LIKE ? and shared = 'on' and area >= $area and rent >= $rent and mortgage >= $mortgage   ORDER BY  id DESC

if(isset($_REQUEST['type'])){
    // Prepare a select statement
    // SELECT r.id, a.name,b.id FROM tutorials_inf a,tutorials_bks b WHERE a.id = b.id
    $sql = "SELECT r.id, u.address, FROM 'users' AS u LEFT JOIN 'rental' AS r ON u.id = r.user_id";

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
                    echo 
                   "
                    <div class=\"case my-4 \" id=\"rent".$row['id'] . "\">
                    <div class=\"row\">
                                            <div class=\"col-6 col-sm-12\">
                                                کد :" . $row["id"]. " 
                                            </div>
                                        </div>
                                            
                    <div class=\"row rent". $row["id"] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >نوع :" . $row["type"] . 
                                                "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >متراژ :" .$row["area"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >رهن :" .$row["mortgage"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >اجاره : " . $row["rent"]. "</div>
                                            </div>
                                            <div class=\"row rent" . $row['id'] ."\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تعداد طبقات : " .$row["floors"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >طبقه : ".$row["floor"]. "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تعداد واحد در طبقه :" . $row["upf"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >واحد :" .$row["unit"] . "</div>
                                            </div> 

                                            <div class=\"row rent". $row['id'] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >گرمایش-سرمایش :" . $row["cold_heat"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >پارکینگ : "  . $row["parking"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >آسانسور:" . $row["elevator"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >تراس : " . $row["terrace"] . "</div>
                                            </div>
                                            <div class=\"row rent". $row['id'] . "\">
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >نما، پوشش:" . $row["facades"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >کابینت :" . $row["kitchen"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >سرویس: " . $row["service"] . "</div>
                                                <div class=\"col-6 col-md-3 col-lg-3 col-sm-12  case-info\" >سن :" .  $row["hold"] . "</div>
                                                
                                            </div>
                                            <div class=\"row rent" . $row['id'] . "\" style=\"text-align: right;\">
                                                <div class=\"col-6 col-md-6 col-lg-6 col-sm-12 case-info\">آدرس :" . $row["address"] . "</div>
                                                <div class=\"col-6 col-md-6 col-lg-6 col-sm-12 case-info\">شماره تماس :" . $row["phone"] . "</div>
                                            </div>
                                            <div class=\"row rent". $row['id']. "\" style=\"text-align: right;\">
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
?> -->