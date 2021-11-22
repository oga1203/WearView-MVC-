<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
	require_once(ROOT_PATH . 'Controllers/UserController.php');
	$users = new UserController();
	$params = $users->insert();
	//ログインページへ画面遷移
	header('Location: login_form.php');
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
			<h1>新規会員登録</h1>
		</div>
		<form action="" method="post">
			<div class="downbody">
				<h2>メールアドレス</h2>
				<input type="text" name="email" required>
				<h2>パスワード</h2>
				<input type="password" name="password" required>
				<div class="">
					<input type="submit" value="新規登録" class="submit">
				</div>
			</div>
		</form>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>