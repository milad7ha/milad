<?php 
	session_start();

	// variable declaration
	$username = "";
	$mobile    = "";
	$errors = array(); 
	$_SESSION['success'] = "";
	$_SESSION['userId'] ="";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'file');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$mobile = mysqli_real_escape_string($db, $_POST['mobile']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$address = mysqli_real_escape_string($db, $_POST['address']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "نام کاربری الزامی است"); }
		if (empty($mobile)) { array_push($errors, "موبایل الزامی است"); }
		if (empty($password_1)) { array_push($errors, "رمز عبور را وارد کنید"); }
		if (empty($address)) { array_push($errors, "برای نمایش فایل های به که به اشتراک می گذارید آدرس را صحیح وارد کنید");}
		if ($password_1 != $password_2) {
			array_push($errors, "عدم تطابق رمز های عبور وارد شده");
		}

		$query = "SELECT * FROM users WHERE username='$username'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) == 1) {
				array_push($errors, "این نام کاربری قبلا ثبت شده است");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {

			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, mobile, password, address) 
					  VALUES('$username', '$mobile', '$password', '$address')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "وارد شدید";
			header('location: index.php');
		}

	}

	// ... 

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "نام کاربری را وارد کنید");
		}
		if (empty($password)) {
			array_push($errors, "رمز عبور وارد نشده است");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$id_request = "SELECT id FROM users WHERE username = '$username'";
				$rec = mysqli_query($db, $id_request);
				$row = mysqli_fetch_assoc($rec);
				$_SESSION['username'] = $username;
				$_SESSION['userId'] = $row["id"] ;
				$_SESSION['success'] = "وارد شدید";
				header('location: index.php');
			}else {
				array_push($errors, "نام کاربری یا رمز عبور اشتباه است");
			}
		}
	}

?>