<?php
require_once(ROOT_PATH . 'Controllers/UserController.php');
$users = new UserController();
$email = null;
$password = null;
// バリデーションチェック
$error = $users->validationUser();
if ($error === true) {
	$check = $users->check();
	$error = [];
	// メールアドレスチェック
	if (empty($check)) {
		$email = $_POST['email'];
		$password = $_POST['password'];;
		$error['email'] = 'メールアドレスが登録されていません。';
	} else {
		$params = $users->updatePassword();
		$comp_alert = "<script type='text/javascript'>
		alert('パスワード変更しました！');
		location.href = 'login.php';
		</script>";
		echo $comp_alert;
	}
} else {
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
	} else {
		$email = null;
	}
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
	} else {
		$password = null;
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
</head>

<body>
	<?php include("header.php"); ?>
	<div class="title">
		<h1>パスワード再設定</h1>
	</div>
	<div class="body">
		<form action="" method="post">
			<div class="input">
				<p>登録済みのメールアドレス</p>
				<input type="text" name="email" placeholder="sample@sample.com" value="<?php echo $email ?>">
			</div>
			<!-- エラーの際に表示 -->
			<?php if (isset($error['email'])) { ?>
				<div class="error">
					<p><?php echo $error['email']; ?></p>
				</div>
			<?php } ?>
			<!-- エラーの際に表示 -->
			<div class="input">
				<p>新しいパスワード</p>
				<input type="password" name="password" placeholder="New Password" value="<?php echo $password ?>">
			</div>
			<!-- エラーの際に表示 -->
			<?php if (isset($error['password'])) { ?>
				<div class="error">
					<p><?php echo $error['password']; ?></p>
				</div>
			<?php } ?>
			<!-- エラーの際に表示 -->
			<div class="sub">
				<input type="submit" name="login" value="変更" class="submit" id="login">
			</div>
		</form>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>