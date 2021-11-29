<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
	require_once(ROOT_PATH . 'Controllers/UserController.php');
	$users = new UserController();
	$params = $users->updatePassword();
	$comp_alert = "<script type='text/javascript'>
	alert('パスワード変更しました！');
	location.href = 'login.php';
	</script>";
	echo $comp_alert;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>Wear View</title>
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body>
	<?php include("header_log.php"); ?>
	<div class="body">
		<div class="upbody">
			<h1>パスワード再設定</h1>
		</div>
		<div class="downbody">
			<form action="" method="post">
				<h2>メールアドレス</h2>
				<input type="text" name="email" placeholder="sample@sample.com">
				<h2>パスワード</h2>
				<input type="password" name="password" placeholder="new password">
				<div class="signup_comp_button">
					<input type="submit" name="login" value="変更" class="submit" id="login">
				</div>
		</div>
		</form>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>