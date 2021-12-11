<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
	require_once(ROOT_PATH . 'Controllers/UserController.php');
	$users = new UserController();
	$params = $users->insert();
	$comp_alert = "<script type='text/javascript'>
	alert('登録完了しました！');
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
	<?php include("header.php"); ?>
	<div class="title">
		<h1>新規会員登録</h1>
	</div>
	<div class="body">
		<form action="" method="post">
			<div class="input">
				<p>メールアドレス</p>
				<input type="text" name="email" placeholder="sample@sample.com">
			</div>
			<div class="input">
				<p>パスワード</p>
				<input type="password" name="password" placeholder="Password">
			</div>
			<div class="sub">
				<input type="submit" value="新規登録" class="submit">
			</div>
		</form>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>