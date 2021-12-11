<?php
session_start();
//idが空の場合、リダイレクト
if (empty($_SESSION['user_id'])) {
	header("Location: ./login.php");
	exit;
}
require_once(ROOT_PATH . 'Controllers/UserController.php');
$users = new UserController();
$params = $users->viewUser();
$user = $params['user'];
$sex = $user['sex'];

//追加
if (isset($_POST['user_id'])) {
	//バリデーション機能がないので追加予定
	$update = $users->updateUser();
	//ページのリフレッシュ
	header("Location: mypage.php?user_id={$user['user_id']}");
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>Wear View</title>
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="/js/base.js"></script>
</head>

<body>
	<?php include("header.php"); ?>
	<div class="title">
		<h1>アカウント情報編集</h1>
	</div>
	<div class="body">
		<form action="" method="post" onSubmit="return update()">
			<input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">
			<div class="input">
				<p>ユーザー名</p>
				<input type="text" name="user_name" value="<?= $user['user_name']; ?>">
			</div>
			<div class="input">
				<p>メールアドレス</p>
				<input type="text" name="email" value="<?= $user['email']; ?>">
			</div>
			<div class="input">
				<p>生年月日</p>
				<input type="text" name="age" value="<?= $user['age']; ?>">
			</div>
			<div class="input">
				<p>身長</p>
				<input type="text" name="height" value="<?= $user['height']; ?>">
			</div>
			<div class="input">
				<p>体重</p>
				<input type="text" name="weight" value="<?= $user['weight']; ?>">
			</div>
			<div class="input">
				<p>性別</p>
				<select name="sex">
					<!-- 改善の余地あり -->
					<option value="">性別を選択</option>
					<option value="1">男</option>
					<option value="2">女</option>
					<option value="3">未選択</option>
				</select>
			</div>
			<input type="submit" value="更  新" name="submit" class="submit">
			<div class="reset">
				<a href="mypage.php?user_id=<?= $_SESSION['user_id'] ?>">戻&nbsp;&nbsp;る</a>
			</div>
		</form>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>