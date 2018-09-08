<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>عضویت مدیریت آنلاین فایل املاک</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="header">
		<h2>ثبت نام</h2>
	</div>

	<form method="post" class="content-form" action="register.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>نام کاربری</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>شماره موبایل</label>
			<input type="text" name="mobile" value="<?php echo $mobile; ?>">
		</div>
		<div class="input-group">
			<label>رمز عبور</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>تکرار رمز عبور</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<label>آدرس</label>
			<input type="text" name="address">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_user">ثبت نام</button>
		</div>
		<p>
			حساب کاربری دارید ؟  <a href="login.php">ورود</a>
		</p>
	</form>
</body>
</html>
