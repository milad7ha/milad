	<?php
		session_start();

		if (!isset($_SESSION['username'])) {
			$_SESSION['msg'] = "You must log in first";
			header('location: login.php');
		}

		if (isset($_GET['logout'])) {
			session_destroy();
			unset($_SESSION['username']);
			header("location: login.php");
		}

	?>

	<?php 
	require_once ('./imports/MysqliDb.php');

	$db = new MysqliDb (Array (
                'host' => 'localhost',
                'username' => 'root', 
                'password' => '',
                'db'=> 'file',
                'port' => 3306,
                'charset' => 'utf8_general_ci'));
?>

	<!DOCTYPE html>
	<html>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta charset="UTF-8">

	<head>
		<title>Home</title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/uikit.min.css">
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<!-- <script src="vendor/jquery/jquery.slim.min.js"></script> -->
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/js/uikit.min.js"></script>
		<script src="vendor/js/uikit-icons.min.js"></script>
		<script src="vendor/jquery/jquery.min.js"></script>

		<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
			<script type="text/javascript">
$(document).ready(function(){
    $('.search-button').click(function(){
        /* Get input value on change */
        var inputType = $("#rInType").val();
        var inputArea = $("#rInArea").val();
        var inputMortgage = $("#rInMortgage").val();
        var inputRent = $("#rInRent").val();
        var identifier = "<?php print $_SESSION['userId']; ?>" ;
        if(inputMortgage == ""){
       		inputMortgage = 0;
        }
        if(inputArea == ""){
       		inputArea = 0;
        }
        if(inputRent == ""){
       		inputRent = 0;
        }
        var resultDropdown = $(".result");
        if(inputType.length){
            $.get("backend-search.php", {id : identifier, type: inputType, area :inputArea, mortgage :inputMortgage, rent: inputRent}).done(function(data){
                // Display the returned data in browser
                var a = data;
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
});
$(document).ready(function(){
    $('.mySell-search-button').click(function(){
        /* Get input value on change */
        var inputType = $("#sInType").val();
        var inputArea = $("#sInArea").val();
        var inputTotalPrice = $("#sInTotalPrice").val();
        var identifier = "<?php print $_SESSION['userId']; ?>" ;
        if(inputArea == ""){
       		inputArea = 0;
        }
        if(inputTotalPrice == ""){
       		inputTotalPrice = 0;
        }
        var resultDropdown = $(".mySell-result");
        if(inputType.length){
            $.get("backend-search-mySell.php", {id : identifier,type: inputType, area :inputArea, total_price :inputTotalPrice}).done(function(data){
                // Display the returned data in browser
                var a = data;
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
});
</script>
	</head>
	<body>
		<div class="container mt-5">
				<!-- logged in user information -->
			<?php  if (isset($_SESSION['username'])) : ?>
				<p class="">  <a href="index.php?logout='1'" style="color: red;">خروج</a> <strong><?php echo $_SESSION['username']; echo $_SESSION['userId'];?></strong>
				</p> 
			<?php endif ?>


		</div>
		<div class="container" style="direction: rtl;">
				<div class=" col-12 col-sm-12 col-md-12">
						<!-- first bar	 -->
						<ul class="uk-subnav uk-subnav-pill" uk-switcher="connect: .switcher-container " >
	    					<li><a href="#">فایل من</a></li>
	    					<li><a href="#">فایل اشتراکی</a></li>
	    					<li><a href="#">فایل جدید +</a></li>	
						</ul>
						<!-- second bar -->
						<ul class="uk-switcher switcher-container uk-margin"> 
		    				<li id="some"> <!-- first element of second -->
		    					<ul class="uk-subnav uk-subnav-pill" id="we" uk-switcher="connect: .switcher-container1">
		    						<li><a id="rent1" href="#">رهن و اجاره</a></li>
		    						<li><a id="sell1" href="#">فروش</a></li>
								</ul>
								<ul class="uk-switcher switcher-container1  uk-margin" id="">
									<!-- my rent and mortage -->
		    						<li>
		    							<div class="row search-box">
									        <select class="form-control col-md-2 col-md-2 col-lg-2 col-sm-12" id="rInType" name="type" >
		      										<option>مسکونی</option>
		        									<option>اداری</option>
		        									<option>کلنگی</option>
		        									<option>زمین</option>
		     									</select> 
		     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="rInArea" type="number" name="area" placeholder="حداقل متراژ" autocomplete="off">
		     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="rInMortgage" type="number" name="mortgage" placeholder="حداقل رهن"  min="0" autocomplete="off">
		     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="rInRent" type="number" name="rent" min="0" placeholder="حداقل اجاره" autocomplete="off">
		     									<button class="uk-button col-md-2 btn-info search-button">جست و جو</button>
		     									<div class="row"> </div>
									    </div>
									        	
		    								<div class="result "></div>
		    							<?php 
		    								$db->orderBy("id","Desc");
		    								$db->where('user_id' , $_SESSION['userId']);
		    								$cols = Array ("id","type", "area" , "mortgage", "rent" ,"floors", "floor" , "upf", "unit", "terrace", "service", "kitchen", "hold", "elevator" , "facades", "cold_heat", "phone", "address" , "discription", "parking", "shared", "owner");
		    								$result = $db->get('rental' , null, $cols);
		    								if($db->count == 0){
		    									echo "<div class=\"text-center mt-4\"> در حال حاضر فایلی ندارید </div>";
		    								}
		    								foreach ($result as $key=>$rental_result) {?>
			    							<div class="case my-4 " id="rent<?php echo $rental_result['id']; ?>">
			    								<div class="row mb-2 rent-fade" style="direction: ltr;">

			    									<button type="button" class="btn  btn-danger delete_rent_case" id=<?php echo $rental_result['id']; ?> > <span uk-icon="icon: trash; ratio: 0.9"></span></button>
			    									<button type="button" class="btn btn-info rent_edit_enable mx-2" id=<?php echo $rental_result['id']; ?> > <span uk-icon="icon: pencil; ratio: 0.9"></span></button>
			    									<?php if($rental_result["shared"] == "") {?>
			    									  		<button type="button" class="btn  btn-success share-item" id=<?php echo $rental_result['id']; ?> > <span uk-icon="icon: social; ratio: 0.9"></span></button>
			    									<?php }else{?>
			    											<button type="button" class="btn  btn-success unshare-item" id=<?php echo $rental_result['id']; ?> > عدم اشتراک</button>
			    									<?php } ?>
			    								</div>

			    								<!-- </form> -->
			    								<!-- <div class="row">
			    									<div class="mb-2 rent-fade col-md-2"><button type="button" class="btn  btn-success share-item" id=<?php echo $rental_result['id']; ?> > <span uk-icon="icon: social; ratio: 0.9"></span></button> </div>

			    									
			    								</div> -->
			    								
			    								<form action="update_rental.php?case_id=<?php echo $rental_result['id']?>"  method="post" class="edit_input<?php echo $rental_result['id']; ?>" style="display: none;">

		    									<div class="row">
										        <!-- <div class="form-group"> -->
										            <input name="type" class="form-control col-6 col-md-3 col-lg-3 col-sm-12 " placeholder="نوع : <?php echo $rental_result['type']; ?>" value="<?php echo $rental_result['type']; ?>" type="text">
										        
										            <input name="area" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="مساحت :<?php echo $rental_result['area']; ?> " value="<?php echo $rental_result['area']; ?>" type="text">
										         
										          
										            <input name="mortgage" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="رهن :<?php echo $rental_result['mortgage']; ?>" value="<?php echo $rental_result['mortgage']; ?>" type="text">
										         
										          
										            <input name="rent" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="اجاره : <?php echo $rental_result['rent']; ?>" value="<?php echo $rental_result['rent']; ?>" type="text">
										         
										          
										      </div>
										      <div class="row">
										            
										            <input name="floors" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="تعداد طبقات : <?php echo $rental_result['floors']; ?>" value="<?php echo $rental_result['floors']; ?>" type="text">
										            <input name="floor" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="طبقه : <?php echo $rental_result['floor']; ?>" value="<?php echo $rental_result['floor']; ?>" type="text">
										            <input name="upf" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="واحد در طبقه : <?php echo $rental_result['upf']; ?>" value="<?php echo $rental_result['upf']; ?>" type="text">
										            <input name="unit" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="واحد :<?php echo $rental_result['unit']; ?>" value="<?php echo $rental_result['unit']; ?>" type="text">
										      </div>
										      <div class="row">
										            
										            <input name="cold_heat" class="form-control  col-6 col-md-3 col-lg-3 col-sm-12" placeholder="گرمایش-سرمایش :<?php echo $rental_result['cold_heat']; ?>" value="<?php echo $rental_result['cold_heat']; ?>" type="text">
										            <input name="parking" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="پارکینگ : <?php echo $rental_result['parking']; ?>" value="<?php echo $rental_result['parking']; ?>" type="text">
										            <input name="elevator" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="آسانسور : <?php echo $rental_result['elevator']; ?>" value="<?php echo $rental_result['elevator']; ?>" type="text">
										            <input name="terrace" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="تراس : <?php echo $rental_result['terrace']; ?>" value="<?php echo $rental_result['terrace']; ?>" type="text">
										      </div>
										      <div class="row">
										            
										            <input name="facades" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="نما و پوشش : <?php echo $rental_result['facades']; ?>" value="<?php echo $rental_result['facades']; ?>" type="text">
										            <input name="kitchen" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="کابینت : <?php echo $rental_result['kitchen']; ?>" value="<?php echo $rental_result['kitchen']; ?>" type="text">
										            <input name="service" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="سرویس :<?php echo $rental_result['service']; ?>" value="<?php echo $rental_result['service']; ?>" type="text">
										            <input name="hold" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="سن : <?php echo $rental_result['hold']; ?>" value="<?php echo $rental_result['hold']; ?>" type="text">
										      </div>
										      <div class="row">
										            <input name="address" class="form-control col-6 col-md-6 col-lg-6 col-sm-12" placeholder="آدرس :<?php echo $rental_result['address']; ?>" value="<?php echo $rental_result['address']; ?>" type="text">
										            <input name="phone" class="form-control col-3 col-md-3 col-lg-3 col-sm-12" placeholder="شماره :<?php echo $rental_result['phone']; ?>" value="<?php echo $rental_result['phone']; ?>" type="text">
										            <input name="owner" class="form-control col-3 col-md-3 col-lg-3 col-sm-12" placeholder="مالک :<?php echo $rental_result['owner']; ?>" value="<?php echo $rental_result['owner']; ?>" type="text">
										      </div>
										         <div class="row">
										            <input name="discription" class="form-control col-12" placeholder="توضیحات <?php echo $rental_result['discription']; ?>" value="<?php echo $rental_result['discription']; ?>" type="text">
										        	</div>							    
										    	<input class="uk-button btn-success text-center" type="submit" value="ویرایش">
											 </form>
											 	<div class="row rent<?php echo $rental_result['id']; ?>   rent-fade">
		    									<div class="col-6 col-sm-12">
		    										کد : <?php echo $rental_result["id"]; ?>
		    									</div>
		    								</div>
				    							<div class="row rent<?php echo $rental_result['id']; ?>   rent-fade">
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >نوع :<?php echo $rental_result["type"] ?>
				    								</div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >متراژ : <?php echo $rental_result["area"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >رهن :<?php echo $rental_result["mortgage"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >اجاره : <?php echo $rental_result["rent"] ?></div>
				    							</div>
				    							<div class="row rent<?php echo $rental_result['id']; ?>  rent-fade">
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تعداد طبقات : <?php echo $rental_result["floors"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >طبقه : <?php echo $rental_result["floor"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تعداد واحد در طبقه :<?php echo $rental_result["upf"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >واحد : <?php echo $rental_result["unit"] ?></div>
				    								

				    							</div>
				    							<div class="row rent<?php echo $rental_result['id']; ?>  rent-fade">
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >گرمایش-سرمایش : <?php echo $rental_result["cold_heat"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >پارکینگ : <?php echo $rental_result["parking"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >آسانسور: <?php echo $rental_result["elevator"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تراس : <?php echo $rental_result["terrace"] ?></div>
				    							</div>
				    							<div class="row rent<?php echo $rental_result['id']; ?>  rent-fade">
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >نما، پوشش: <?php echo $rental_result["facades"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >کابینت : <?php echo $rental_result["kitchen"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >سرویس: <?php echo $rental_result["service"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >سن : <?php echo $rental_result["hold"] ?></div>
				    								
				    							</div>
				    							<div class="row rent<?php echo $rental_result['id']; ?>  rent-fade" style="text-align: right;">
				    								<div class="col-6 col-md-6 col-lg-6 col-sm-12 case-info">آدرس :<?php echo $rental_result["address"] ?></div>
				    								<div class="col-3 col-md-3 col-lg-3 col-sm-12 case-info">شماره تماس :<?php echo $rental_result["phone"] ?></div>
				    								<div class="col-3 col-md-3 col-lg-3 col-sm-12 case-info">مالک :<?php echo $rental_result["owner"] ?></div>
				    							</div>
				    							<div class="row rent<?php echo $rental_result['id']; ?>  rent-fade" style="text-align: right;">
				    								<div class="col-12" style="max-width: 900px;">توضیحات: <?php echo $rental_result["discription"] ?></div>
				    							</div>
			    							</div>
		    									<?php
		    									 }
		    									?>
		    						</li>
		    						<!-- my rent and mortage -->
		    						<li>
		    							<!-- my sell -->
		    							<div class="row mySell-search-box">
									        <select class="form-control col-md-2 col-md-2 col-lg-2 col-sm-12" id="sInType" name="type" >
		      										<option>مسکونی</option>
		        									<option>اداری</option>
		        									<option>کلنگی</option>
		        									<option>زمین</option>
		     									</select> 
		     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="sInArea" type="number" name="area" placeholder="حداقل متراژ" autocomplete="off">
		     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="sInTotalPrice" type="number" name="total_price" placeholder="حداقل قیمت کل"  min="0" autocomplete="off">
		     									<button class="uk-button col-md-2 btn-info mySell-search-button">جست و جو</button>
									    </div>
									    <div class="mySell-result"></div>
		    							<?php 
		    								$db->orderBy("id","Desc");
		    								$db->where('user_id' , $_SESSION['userId']);
		    								$cols = Array ("id","type", "area" , "total_price","floors", "floor" , "upf", "unit", "terrace", "service", "kitchen", "hold", "elevator" , "facades", "cold_heat", "phone", "address" , "discription", "parking" , "shared", "owner");
		    								$buyresults = $db->get('buy' , null, $cols);
		    								if($db->count == 0){
		    									echo "<div class=\"text-center mt-4\"> در حال حاضر فایلی ندارید </div>";
		    								}
		    								foreach ($buyresults as $key=>$buy_result) {?>
		    									
		    									<div class="case my-4 all-my-buy" id="buy<?php echo $buy_result['id']?>" >
		    											<div class="row mb-2" style="direction: ltr;">
			    									<button type="button" class="btn  btn-danger delete_buy_case" id=<?php echo $buy_result['id']; ?> > <span uk-icon="icon: trash; ratio: 0.9"></span></button>
			    									<button type="button" class="btn mx-2 btn-info edit_buy_enable" id=<?php echo $buy_result['id']; ?> style="margin-left: 10px"> <span uk-icon="icon: pencil; ratio: 0.9"></span></button>
			    									<?php if($buy_result["shared"] == "") {?>
			    									  		<button type="button" class="btn  btn-success share-sitem" id=<?php echo $buy_result['id']; ?> > <span uk-icon="icon: social; ratio: 0.9"></span></button>
			    									<?php }else{?>
			    											<button type="button" class="btn  btn-success unshare-sitem" id=<?php echo $buy_result['id']; ?> > عدم اشتراک</button>
			    									<?php } ?>
			    									  
			    								</div>
			    								<form action="update_buy.php?case_id=<?php echo $buy_result['id']?>"  method="post" class="edit_buy_input<?php echo $buy_result['id']; ?>" style="display: none;">

		    									<div class="row">
										        <!-- <div class="form-group"> -->
										            <input name="type" class="form-control col-6 col-md-3 col-lg-3 col-sm-12 " placeholder="نوع : <?php echo $buy_result['type']; ?>" value="<?php echo $buy_result['type']; ?>" type="text">
										        
										            <input name="area" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="مساحت :<?php echo $buy_result['area']; ?> " value="<?php echo $buy_result['area']; ?>" type="text">
										         
										          
										          
										            <input name="total_price" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="قیمت کل : <?php echo $buy_result['total_price']; ?>" value="<?php echo $buy_result['total_price']; ?>" type="text">
										         
										          <input name="hold" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="سن : <?php echo $buy_result['hold']; ?>" value="<?php echo $buy_result['hold']; ?>" type="text">
										      </div>
										      <div class="row">
										            
										            <input name="floors" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="تعداد طبقات : <?php echo $buy_result['floors']; ?>" value="<?php echo $buy_result['floors']; ?>" type="text">
										            <input name="floor" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="طبقه : <?php echo $buy_result['floor']; ?>" value="<?php echo $buy_result['floor']; ?>" type="text">
										            <input name="upf" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="واحد در طبقه : <?php echo $buy_result['upf']; ?>" value="<?php echo $buy_result['upf']; ?>" type="text">
										            <input name="unit" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="واحد :<?php echo $buy_result['unit']; ?>" value="<?php echo $buy_result['unit']; ?>" type="text">
										      </div>
										      <div class="row">
										            
										            <input name="cold_heat" class="form-control  col-6 col-md-3 col-lg-3 col-sm-12" placeholder="گرمایش-سرمایش :<?php echo $buy_result['cold_heat']; ?>" value="<?php echo $buy_result['cold_heat']; ?>" type="text">
										            <input name="parking" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="پارکینگ : <?php echo $buy_result['parking']; ?>" value="<?php echo $buy_result['parking']; ?>" type="text">
										            <input name="elevator" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="آسانسور : <?php echo $buy_result['elevator']; ?>" value="<?php echo $buy_result['elevator']; ?>" type="text">
										            <input name="terrace" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="تراس : <?php echo $buy_result['terrace']; ?>" value="<?php echo $buy_result['terrace']; ?>" type="text">
										      </div>
										      <div class="row">
										            
										            <input name="facades" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="نما و پوشش : <?php echo $buy_result['facades']; ?>" value="<?php echo $buy_result['facades']; ?>" type="text">
										            <input name="kitchen" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="کابینت : <?php echo $buy_result['kitchen']; ?>" value="<?php echo $buy_result['kitchen']; ?>" type="text">
										            <input name="service" class="form-control col-6 col-md-3 col-lg-3 col-sm-12" placeholder="سرویس :<?php echo $buy_result['service']; ?>" value="<?php echo $buy_result['service']; ?>" type="text">
										            <input name="phone" class="form-control col-3 col-md-3 col-lg-3 col-sm-12" placeholder="شماره <?php echo $buy_result['phone']; ?>" value="<?php echo $buy_result['phone']; ?>" type="text">
										            
										      </div>
										      <div class="row">
										            <input name="address" class="form-control col-8 col-md-8 col-lg-8 col-sm-12" placeholder="آدرس :<?php echo $buy_result['address']; ?>" value="<?php echo $buy_result['address']; ?>" type="text">
										            <input name="owner" class="form-control col-4 col-md-4 col-lg-4 col-sm-12" placeholder="مالک :<?php echo $buy_result['owner']; ?>" value="<?php echo $buy_result['owner']; ?>" type="text">
										            
										      </div>
										         <div class="row">
										            <input name="discription" class="form-control col-12" placeholder="توضیحات <?php echo $buy_result['discription']; ?>" value="<?php echo $buy_result['discription']; ?>" type="text">
										        	</div>							    
										    	<input class="uk-button btn-success text-center" type="submit" value="ویرایش">
											 </form>
											 	<div class="row buyf<?php echo $buy_result['id']?> all-my-buy">
		    									<div class="col-6 col-sm-12">
		    										کد : <?php echo $buy_result["id"]; ?>
		    									</div>
		    								</div>
				    							<div class="row buyf<?php echo $buy_result['id']?> all-my-buy">
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">نوع <?php echo $buy_result["type"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">متراژ : <?php echo $buy_result["area"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">قیمت کل : <?php echo $buy_result["total_price"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">سن<?php echo $buy_result["hold"] ?></div>
				    							</div>
				    							<div class="row buyf<?php echo $buy_result['id']?> all-my-buy">
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">تعداد طبقات : <?php echo $buy_result["floors"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">طبقه : <?php echo $buy_result["floor"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">تعداد واحد در طبقه :<?php echo $buy_result["upf"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">واحد : <?php echo $buy_result["unit"] ?></div>
				    							</div>
				    							<div class="row buyf<?php echo $buy_result['id']?> all-my-buy">
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">گرمایش-سرمایش : <?php echo $buy_result["cold_heat"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">پارکینگ : <?php echo $buy_result["parking"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">آسانسور: <?php echo $buy_result["elevator"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">تراس : <?php echo $buy_result["terrace"] ?></div>
				    							</div>
				    							<div class="row buyf<?php echo $buy_result['id']?> all-my-buy">
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">نما، پوشش: <?php echo $buy_result["facades"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">کابینت : <?php echo $buy_result["kitchen"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">سرویس: <?php echo $buy_result["service"] ?></div>
				    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">شماره تماس :<?php echo $buy_result["phone"] ?></div>
				    							</div>
				    							<div class="row buyf<?php echo $buy_result['id']?> all-my-buy" style="text-align: right;">
				    								<div class="col-9 col-md-9 col-lg-9 col-sm-12">آدرس :<?php echo $buy_result["address"] ?></div>
				    								<div class="col-3 col-md-3 col-lg-3 col-sm-12 ">مالک :<?php echo $buy_result["owner"] ?></div>
				    							</div>
				    							<div class="row buyf<?php echo $buy_result['id']?> all-my-buy" style="text-align: right;">
				    								<div class="col-12 mx-2">توضیحات: <?php echo $buy_result["discription"] ?></div>
				    							</div>
			    							</div>
		    									<?php
		    									 }
		    									?>
		    									<!-- my sell -->
		    						</li>
								</ul>  <!-- second bar first for first of first bar -->
							</li> <!--first of second bar -->
	    				<li> <!-- second of second bar -->
	    					<ul class="uk-subnav uk-subnav-pill" uk-switcher="connect: .switcher-container2">
	    						<li><a href="#">رهن و اجاره</a></li>
	    						<li><a href="#">فروش</a></li>
							</ul>


							<ul class="uk-switcher switcher-container2  uk-margin">
	    						<li>
	    							<div class="row ">
								        <select class="form-control col-md-2 col-md-2 col-lg-2 col-sm-12" id="rSInType" name="type" >
	      										<option>مسکونی</option>
	        									<option>اداری</option>
	        									<option>کلنگی</option>
	        									<option>زمین</option>
	     									</select> 
	     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="rSInArea" type="number" name="area" placeholder="حداقل متراژ" autocomplete="off">
	     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="rSInMortgage" type="number" name="mortgage" placeholder="حداقل رهن"  min="0" autocomplete="off">
	     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="rSInRent" type="number" name="rent" min="0" placeholder="حداقل اجاره" autocomplete="off">
	     									<button class="uk-button col-md-2 btn-info search-shared-rental">جست و جو</button>
	     									<div class="row"> </div>
								    </div>

								    <div class="case my-4 shared-rental-result">
								    </div>
	    						<?php
	    							$db->orderBy("id","Desc");
	    							$db->join("users u", "u.id=r.user_id", "LEFT");
	    							$db->where("r.shared", "on");
	    							$cols = Array ("r.id","type", "area" , "mortgage", "rent" ,"floors", "floor" , "upf", "unit", "terrace", "service", "kitchen", "hold", "elevator" , "facades", "cold_heat", "mobile", "u.address" , "discription", "parking", "shared", "owner");
	    							$rentals_shared = $db->get ("rental r", null, $cols);

	    								if($db->count == 0){
	    									echo "<div class=\"text-center mt-4\"> در حال حاضر فایلی ندارید </div>";
	    								}else{
	    									foreach ($rentals_shared as $key => $rental_shared) {
	    							?>
	    							<div class="case my-4 rental-shared-div">
	    								<div class="row">
	    									<div class="col-6 col-sm-12">
	    										کد : <?php echo $rental_shared["id"]; ?>
	    									</div>
	    								</div>
	    								<div class="row">
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >نوع :<?php echo $rental_shared["type"] ?>
			    								</div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >متراژ : <?php echo $rental_shared["area"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >رهن :<?php echo $rental_shared["mortgage"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >اجاره : <?php echo $rental_shared["rent"] ?></div>
			    							</div>
			    							<div class="row">
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تعداد طبقات : <?php echo $rental_shared["floors"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >طبقه : <?php echo $rental_shared["floor"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تعداد واحد در طبقه :<?php echo $rental_shared["upf"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >واحد : <?php echo $rental_shared["unit"] ?></div>
			    								

			    							</div>
			    							<div class="row">
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >گرمایش-سرمایش : <?php echo $rental_shared["cold_heat"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >پارکینگ : <?php echo $rental_shared["parking"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >آسانسور: <?php echo $rental_shared["elevator"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تراس : <?php echo $rental_shared["terrace"] ?></div>
			    							</div>
			    							<div class="row">
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >نما، پوشش: <?php echo $rental_shared["facades"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >کابینت : <?php echo $rental_shared["kitchen"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >سرویس: <?php echo $rental_shared["service"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >سن : <?php echo $rental_shared["hold"] ?></div>
			    								
			    							</div>
			    							<div class="row" style="text-align: right;">
			    								<div class="col-6 col-md-6 col-lg-6 col-sm-12 case-info">آدرس :<?php echo  $rental_shared["address"] ?></div>
			    								<div class="col-6 col-md-6 col-lg-6 col-sm-12 case-info">شماره تماس :<?php echo $rental_shared["mobile"] ?></div>
			    							</div>
			    							<div class="row" style="text-align: right;">
			    								<div class="col-12">توضیحات: <?php echo $rental_shared["discription"] ?></div>
			    							</div>
		    							</div>
			    							<?php } }?>
	    						</li>
	    						<li>
	    							<div class="row sell-shared-search-box">
								        <select class="form-control col-md-2 col-md-2 col-lg-2 col-sm-12" id="sSInType" name="type" >
	      										<option>مسکونی</option>
	        									<option>اداری</option>
	        									<option>کلنگی</option>
	        									<option>زمین</option>
	     									</select> 
	     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="sSInArea" type="number" name="area" placeholder="حداقل متراژ" autocomplete="off">
	     									<input class="col-md-2 col-md-2 col-lg-2 col-sm-12" id="sSInTotalPrice" type="number" name="total_price" placeholder="حداقل قیمت کل"  min="0" autocomplete="off">
	     									<button class="uk-button col-md-2 btn-info sell-shared-search">جست و جو</button>
								    </div>

								    <div class="case my-4 sell-shared-result"> </div>
	    							<?php
	    								$db->orderBy("id","Desc");
		    							$db->join("users u", "u.id=b.user_id", "LEFT");
		    							$db->where("b.shared", "on");
		    							$cols = Array ("b.id","type", "area" , "total_price" ,"floors", "floor" , "upf", "unit", "terrace", "service", "kitchen", "hold", "elevator" , "facades", "cold_heat", "mobile", "u.address" , "discription", "parking", "shared", "owner");
	    							$buys_shared = $db->get ("buy b", null, $cols);
	    								if($db->count == 0){
	    									echo "<div class=\"text-center mt-4\"> در حال حاضر فایلی ندارید </div>";
	    								}
	    							foreach ($buys_shared as $key=>$buy_shared) {
	    								?> 
	    							<div class="case my-4 shared-sell">
	    								<div class="row">
	    									<div class="col-6 col-sm-12">
	    										کد : <?php echo $buy_shared["id"]; ?>
	    									</div>
	    								</div>
	    								<div class="row">
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >نوع :<?php echo $buy_shared["type"] ?>
			    								</div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >متراژ : <?php echo $buy_shared["area"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >رهن :<?php echo $buy_shared["total_price"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >سن	 : <?php echo $buy_shared["hold"] ?></div>
			    							</div>
			    							<div class="row">
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تعداد طبقات : <?php echo $buy_shared["floors"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >طبقه : <?php echo $buy_shared["floor"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تعداد واحد در طبقه :<?php echo $buy_shared["upf"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >واحد : <?php echo $buy_shared["unit"] ?></div>
			    								

			    							</div>
			    							<div class="row">
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >گرمایش-سرمایش : <?php echo $buy_shared["cold_heat"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >پارکینگ : <?php echo $buy_shared["parking"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >آسانسور: <?php echo $buy_shared["elevator"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >تراس : <?php echo $buy_shared["terrace"] ?></div>
			    							</div>
			    							<div class="row">
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >نما، پوشش: <?php echo $buy_shared["facades"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >کابینت : <?php echo $buy_shared["kitchen"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12  case-info" >سرویس: <?php echo $buy_shared["service"] ?></div>
			    								<div class="col-6 col-md-3 col-lg-3 col-sm-12 case-info">شماره تماس :<?php echo $buy_shared["mobile"] ?></div>
			    								
			    							</div>
			    							<div class="row" style="text-align: right;">
			    								<div class="col-8 col-md-8 col-lg-8 col-sm-12 case-info">آدرس :<?php echo  $buy_shared["address"] ?></div>
			    								
			    							</div>
			    							<div class="row" style="text-align: right;">
			    								<div class="col-12">توضیحات: <?php echo $buy_shared["discription"] ?></div>
			    							</div>
		    							</div>
			    							<?php }?>
	    						</li>
							</ul>
	    				</li>
	    				<li>
	    					<ul class="uk-subnav uk-subnav-pill" uk-switcher="connect: .switcher-container3">
	    						<li><a href="#">رهن و اجاره</a></li>
	    						<li><a href="#">فروش</a></li>
							</ul>


							<ul class="uk-switcher switcher-container3  uk-margin">
	    							<li>
	    								<div class="container">
	    									<form action="insert_rental.php?user_id=<?php echo $_SESSION['userId'] ?>" method="post" >
	    										<div class="row">
	    											<select class="form-control col-md-3 col-md-3 col-lg-3 col-sm-12" name="type" >
			      										<option>مسکونی</option>
			        									<option>اداری</option>
			        									<option>کلنگی</option>
			        									<option>زمین</option>
			     									</select>
			     									<input name="area" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="مساحت" type="number">
			     									<input name="mortgage" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="رهن" type="text">
			     									<input name="rent" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="اجاره" type="text">
									            </div>
									            <div class="row">
									            	<input name="floors" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="تعداد طبقات" type="text">
									            	<input name="floor" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="طبقه" type="text">
									            	 <input name="upf" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="واحد در طبقه" type="text">
									            	 <input name="unit" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="واحد" type="text">
									            </div>
									            <div class="row">
									            	<input name="cold_heat" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="گرمایش-سرمایش" type="text">
									            	<input name="parking" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="پارکینگ" type="text">
									            	<input name="elevator" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="آسانسور" type="text">
									            	 <input name="terrace" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="تراس" type="text">
									            </div>
									            <div class="row">
									            	 <input name="facades" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="نما و پوشش" type="text">
									            	 <input name="kitchen" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="کابینت" type="text">
									            	 <input name="service" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="سرویس" type="text">
									            	 <input name="hold" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="سن" type="text">
									            	 
									            </div>
									            <div class="row">
									            	 <input name="address" class="form-control col-md-6 col-6 col-lg-6 col-sm-12" placeholder="آدرس" type="text">
									            	  <input name="phone" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="شماره" type="text">
									            	 <input name="owner" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="مالک" type="text">
									            </div>
									          
									          <div class="row">
									          	<input name="discription" class="form-control" placeholder="توضیحات" type="text">
									          </div>
									            <div class="row">
									             <input name="shared" class="form-control col-1 col-lg-1 col-md-1" placeholder="" type="checkbox">اشتراک گذاری برای نمایش به دیگران 
									    <input class="uk-button mx-4 btn-success col-3 col-md-3 col-sm-3 col-lg-3" type="submit"  value="فایل کن">
									            </div>									          
									</form>
								</div>
	    						</li>
	    						<li>
	    							<div class="container">
	    									<form action="insert_buy.php/?user_id=<?php echo $_SESSION['userId'] ?>" method="post" >
	    										<div class="row">
	    											<select class="form-control col-md-3 col-md-3 col-lg-3 col-sm-12" name="type" >
			      										<option>مسکونی</option>
			        									<option>اداری</option>
			        									<option>کلنگی</option>
			        									<option>زمین</option>
			     									</select>
			     									<input name="area" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="مساحت" type="number">
			     									<input name="total_price" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="قیمت کل" type="text">
			     									<input name="hold" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="سن" type="text">
									            </div>
									            <div class="row">
									            	<input name="floors" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="تعداد طبقات" type="text">
									            	<input name="floor" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="طبقه" type="text">
									            	 <input name="upf" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="واحد در طبقه" type="text">
									            	 <input name="unit" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="واحد" type="text">
									            </div>
									            <div class="row">
									            	<input name="cold_heat" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="گرمایش-سرمایش" type="text">
									            	<input name="parking" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="پارکینگ" type="text">
									            	<input name="elevator" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="آسانسور" type="text">
									            	 <input name="terrace" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="تراس" type="text">
									            </div>
									            <div class="row">
									            	 <input name="facades" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="نما و پوشش" type="text">
									            	 <input name="kitchen" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="کابینت" type="text">
									            	 <input name="service" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="سرویس" type="text">
									            	 <input name="phone" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="شماره" type="text">
									            	 
									            </div>
									            <div class="row">
									            	 <input name="address" class="form-control col-md-9 col-9 col-lg-9 col-sm-12" placeholder="آدرس" type="text">
									            	  
									            	 <input name="owner" class="form-control col-md-3 col-3 col-lg-3 col-sm-12" placeholder="مالک" type="text">
									            </div>
									          
									          <div class="row">
									          	<input name="discription" class="form-control" placeholder="توضیحات" type="text">
									          </div>
									            <div class="row">
									             <input name="shared" class="form-control col-1 col-lg-1 col-md-1" placeholder="" type="checkbox">اشتراک گذاری برای نمایش به دیگران 
									    <input class="uk-button mx-4 btn-success col-3 col-md-3 col-sm-3 col-lg-3" type="submit"  value="فایل کن">
									            </div>	
									</form>
								</div>
	    						</li>
							</ul>
	    					</li>
						</ul>
				</div>
		</div> 
			
        <!-- <script src="css/bootstrap-datepicker.min.js"></script> -->
        <!-- <script src="css/bootstrap-datepicker.fa.min.js"></script> -->
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->


        <script>

        	$(".insert").click(function(){
        		// alert("here");
        		// alert(status-share);
        	});
        function delete_rent_case_s(clicked_id){
        			var i = clicked_id;
			    	$("#rent"+i).remove();
			        $.post("removerentalcase.php",
			        {
			          delId: i
			         
			        },
			        function(data,status){
			             $('#rent'+i).fadeOut();
			        });
        		}

        function edit_rent_case_s(clicked_id){
    		var i = clicked_id;
			$(".rent"+i).remove();
			$(".edit_input"+i).show();
			$(".rent_edit_enable").fadeOut();
        }

        function edit_buy_case_s(clicked_id){
    		var i = clicked_id;
			$(".buyf"+i).remove();
			$(".edit_buy_input"+i).show();
			$(".edit_buy_enable").fadeOut();
			$(".buyf"+i).fadeOut();
        }

        function delete_buy_case_s(clicked_id){
        	var i = clicked_id;
	    	$("#buyf"+i).remove();
	        $.post("removebuycase.php",
	        {
	          delId: i
	         
	        },
	        function(data,status){
	             $('#buyf'+i).fadeOut();
	        });
        }    
        $(".unshare-item").click(function(){
        	var i = this.id;
        	// alert(i);
        	$.post("disable-share.php",
        	{
        		id : i
        	},
        	function(data,status){
        		$(this.id).html("rwer");
        	});
        });
        $(".share-item").click(function(){
        	var i = this.id;
        	// alert(i);
        	$.post("enable-share.php",
        	{
        		id : i
        	},
        	function(data,status){
        		$(this.id).html("ew");
        	});
        });
        $(".share-sitem").click(function(){
        	var i = this.id;
        	// alert(i);
        	$.post("share-sitem.php",
        	{
        		id : i
        	},
        	function(data,status){
        		// alert(data);
        	});
        });

         $(".unshare-sitem").click(function(){
        	var i = this.id;
        	// alert(i);
        	$.post("unshare-sitem.php",
        	{
        		id : i
        	},
        	function(data,status){
        		// alert(data);
        	});
        });
        	var myZone="";
        	$("#sell1").click(function(){
        		myZone = "sell1"
        	});

        	$("#rent1").click(function(){
        		myZone = "rent1"
        	});

        	if(myZone== "rent1"){
        		$("#rent1").trigger('click');
        	}
        	if(myZone== "sell1"){
        		$("#sell1").trigger('click');
        	}

        		$(".search-button").click(function(){
        			$(".rent-fade").fadeOut();
        		});

        		$(".mySell-search-button").click(function(){
        			$(".all-my-buy").fadeOut();
        		});
        		
        		$(".edit_buy_enable").click(function(){
        			var i = this.id;
        			$(".buyf"+i).remove();
        			$(".edit_buy_input"+i).show();
        			$(".edit_buy_enable").fadeOut();
        			$(".buyf"+i).fadeOut();
        		});
        	// $(document).ready(function(){
        		
        		$(".rent_edit_enable").click(function(){
        			var i = this.id;
        			$(".rent"+i).remove();
        			$(".edit_input"+i).show();
        			$(".rent_edit_enable").fadeOut();
        		});
        	// });


        		// $(document).ready(function(){
    $(".delete_rent_case").click(function(){
    	var i = this.id;
    	// $(this.id).remove();
        $.post("removerentalcase.php",
        {
          delId: i
         
        },
        function(data,status){
             $('#rent'+i).fadeOut();
        });
    });

$(".sell-shared-search").click(function(){
	$(".shared-sell").fadeOut();
 var inputType = $("#sSInType").val();
        var inputArea = $("#sSInArea").val();
        var inputTotalPrice = $("#sSInTotalPrice").val();
      
        if(inputArea == ""){
       		inputArea = 0;
        }
        if(inputTotalPrice == ""){
       		inputTotalPrice = 0;
        }
        var resultDropdown = $(".sell-shared-result");
        if(inputType.length){
            $.get("sell-shared-search.php", {type: inputType, area :inputArea, total_price :inputTotalPrice}).done(function(data){
                // Display the returned data in browser
                // alert(data);
                var a = data;
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }

});

	

    $(".search-shared-rental").click(function(){
    	$(".rental-shared-div").fadeOut();
    	var inputType = $("#rSInType").val();
        var inputArea = $("#rSInArea").val();
        var inputMortgage = $("#rSInMortgage").val();
        var inputRent = $("#rSInRent").val();
        if(inputMortgage == ""){
       		inputMortgage = 0;
        }
        if(inputArea == ""){
       		inputArea = 0;
        }
        if(inputRent == ""){
       		inputRent = 0;
        }
        var resultDropdown = $(".shared-rental-result");
        if(inputType.length){
            $.get("search-shared-rental.php", { type: inputType, area :inputArea, mortgage :inputMortgage, rent: inputRent}).done(function(data){
                // Display the returned data in browser
                var a = data;
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
   
   
// });
        		// $(document).ready(function(){
    $(".delete_buy_case").click(function(){
    	var i = this.id;
    	
    	// $(this.id).remove();
        $.post("removebuycase.php",
        {
          delId: i
         
        },
        function(data,status){
             $('#buy'+i).fadeOut();
        });
    });
        </script>

        
        	</body>
	</html>
