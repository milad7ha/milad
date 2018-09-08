<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>مدیریت آنلاین فایل املاک</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
	<script src="vendor/jquery/jquery.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="header">
		<h2>ورود</h2>
	</div>

	<form method="post" class="content-form" action="login.php" >

		<?php include('errors.php'); ?>
		<div style="direction: rtl;">
		<div class="input-group">
			<label>نام کاربری</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group">
			<label>رمز عبور</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_user">ورود</button>
		</div>
		<p>
			عضو نشده اید؟ <a href="register.php">عضویت</a>
		</p>
		</div>
	</form>


</body>
</html>
