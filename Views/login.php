<?php
require_once(ROOT_PATH . 'Controllers/UserController.php');
$users = new UserController();
// バリデーションチェック
$error = $users->validationUser();
if ($error === true) {
	$params = $users->check();
	$error = [];
	// パスワードチェック
	if ($params === false) {
		$error['password'] = 'パスワードが違います。';
	} else {
		if ($params == null) {
			$error['email'] = 'メールアドレスが登録されていません。';
		} else {
			session_start();
			$user = $params['user'];
			$_SESSION = $user;
			//ログイン後、メイン画面へ遷移
			header('Location: main.php');
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
				<?php if (isset($_POST['email'])) : ?>
					<input type="text" name="email" placeholder="sample@sample.com" value="<?= $_POST['email']; ?>">
				<?php else : ?>
					<input type="text" name="email" placeholder="sample@sample.com" value="">
				<?php endif; ?>
			</div>
			<!-- エラーの際に表示 -->
			<?php if (isset($error['email'])) : ?>
				<div class="error">
					<p><?php echo $error['email']; ?></p>
				</div>
			<?php endif; ?>
			<!-- エラーの際に表示 -->
			<div class="input">
				<p>パスワード</p>
				<?php if (isset($_POST['password'])) : ?>
					<input type="password" name="password" placeholder="Password" value="<?= $_POST['password']; ?>">
				<?php else : ?>
					<input type="password" name="password" placeholder="Password" value="">
				<?php endif; ?>
			</div>
			<!-- エラーの際に表示 -->
			<?php if (isset($error['password'])) : ?>
				<div class="error">
					<p><?php echo $error['password']; ?></p>
				</div>
			<?php endif; ?>
			<!-- エラーの際に表示 -->
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