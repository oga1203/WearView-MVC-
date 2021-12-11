<?php
$errors = [];
if (isset($_POST)) {
	// メールアドレスのチェック
	if (empty($_POST['email'])) {
		$errors['email'] = "メールアドレスは必須入力です。<br>正しくご入力ください。";
	} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "メールアドレスは正しくご入力ください。";
	}
	// パスワードのチェック
	if (empty($_POST['password'])) {
		$errors['password'] = "パスワードは必須入力です。<br>正しくご入力ください。";
	} elseif (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
		$errors['password'] = "パスワードは半角英数字のみでご入力ください。";
	}
	// エラーが空かどうかのチェック
	if (empty($errors)) {
		require_once(ROOT_PATH . 'Controllers/UserController.php');
		$users = new UserController();
		$params = $users->check();
		$user = $params['user'];
		// パスワードが合っているかどうかのチェック
		if (password_verify($_POST['password'], $user['password'])) {
			session_start();
			$_SESSION = $user;
			//ログイン後、メイン画面へ遷移
			header('Location: main.php');
		} else {
			$error_alert = "<script type='text/javascript'>
			alert('パスワードが違います！');
			location.href = 'login.php';
			</script>";
			echo $error_alert;
		}
	}
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>Wear View</title>
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="/js/base.js"></script>
</head>

<body>
	<?php include("header.php"); ?>
	<div class="title">
		<h1>ログイン</h1>
	</div>
	<div class="body">
		<form action="" method="post">
			<div class="input">
				<p>メールアドレス</p>
				<input type="text" name="email" placeholder="sample@sample.com">
			</div>
			<!-- エラーの際に表示 -->
			<div class="error">
				<p>
					<?php
					if (isset($_POST['email'])) {
						echo $errors['email'];
					}
					?>
				</p>
			</div>
			<div class="input">
				<p>パスワード</p>
				<input type="password" name="password" placeholder="Password">
			</div>
			<!-- エラーの際に表示 -->
			<div class="error">
				<p>
					<?php
					if (isset($_POST['password'])) {
						echo $errors['password'];
					}
					?>
				</p>
			</div>
			<div class="login_sub">
				<input type="submit" name="login" value="ログイン" class="submit" id="login">
			</div>
		</form>
		<div class="reset">
			<p><a href="signup.php">新規会員登録</a></p>
			<p><a href="password.php">パスワードを忘れた方はこちら</a></p>
		</div>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>