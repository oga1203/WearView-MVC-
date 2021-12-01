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
	<div class="body">
		<div class="upbody">
			<h1>アカウント情報編集</h1>
		</div>
		<form action="" method="post" onSubmit="return update()">
			<input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">
			<div class="downbody">
				<h2>ユーザー名</h2>
				<input type="text" name="user_name" value="<?= $user['user_name']; ?>">
				<h2>メールアドレス</h2>
				<input type="text" name="email" value="<?= $user['email']; ?>">
				<h2>生年月日</h2>
				<input type="text" name="age" value="<?= $user['age']; ?>">
				<h2>身長</h2>
				<input type="text" name="height" value="<?= $user['height']; ?>">
				<h2>体重</h2>
				<input type="text" name="weight" value="<?= $user['weight']; ?>">
				<h2>性別</h2>
				<div class="">
					<select name="sex">
						<!-- 改善の余地あり -->
						<option value="">性別を選択</option>
						<option value="1">男</option>
						<option value="2">女</option>
						<option value="3">未選択</option>
					</select>
				</div>
				<input type="submit" value="更  新" name="submit" class="submit" style="font-size:18px;">
				<div class="button">
					<div class="back_button">
						<a href="mypage.php?user_id=<?= $_SESSION['user_id'] ?>">戻&nbsp;&nbsp;る</a>
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>