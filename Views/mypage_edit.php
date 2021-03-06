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
//追加
if (isset($_POST['user_id'])) {
	$check = $users->checkUpdateUser();
	if ($check === true) {
		//バリデーション機能がないので追加予定
		$update = $users->updateUser();
		//ページのリフレッシュ
		header("Location: mypage.php?user_id={$user['user_id']}");
	}
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
				<?php if (isset($_POST['user_name'])) : ?>
					<input type="text" name="user_name" value="<?= $_POST['user_name']; ?>">
				<?php else : ?>
					<input type="text" name="user_name" value="<?= $user['user_name']; ?>">
				<?php endif; ?>
			</div>
			<div class="input">
				<p>メールアドレス</p>
				<?php if (isset($_POST['email'])) : ?>
					<input type="text" name="email" value="<?= $_POST['email']; ?>">
				<?php else : ?>
					<input type="text" name="email" value="<?= $user['email']; ?>">
				<?php endif; ?>
			</div>
			<!-- エラーの際に表示 -->
			<?php if (isset($check['email'])) : ?>
				<div class="error">
					<p><?php echo $check['email']; ?></p>
				</div>
			<?php endif; ?>
			<!-- エラーの際に表示 -->
			<!-- 一旦保留 -->
			<!-- <div class="input">
				<p>生年月日</p>
				<input type="text" name="year" value="<?= $user['age']; ?>">
				<input type="text" name="month" value="<?= $user['age']; ?>">
				<input type="text" name="day" value="<?= $user['age']; ?>">
			</div> -->
			<div class="input">
				<p>身長</p>
				<?php if (isset($_POST['height'])) : ?>
					<input type="text" name="height" value="<?= $_POST['height']; ?>">
				<?php else : ?>
					<input type="text" name="height" value="<?= $user['height']; ?>">
				<?php endif; ?>
			</div>
			<!-- エラーの際に表示 -->
			<?php if (isset($check['height'])) : ?>
				<div class="error">
					<p><?php echo $check['height']; ?></p>
				</div>
			<?php endif; ?>
			<div class="input">
				<p>体重</p>
				<?php if (isset($_POST['weight'])) : ?>
					<input type="text" name="weight" value="<?= $_POST['weight']; ?>">
				<?php else : ?>
					<input type="text" name="weight" value="<?= $user['weight']; ?>">
				<?php endif; ?>
			</div>
			<!-- エラーの際に表示 -->
			<?php if (isset($check['weight'])) : ?>
				<div class="error">
					<p><?php echo $check['weight']; ?></p>
				</div>
			<?php endif; ?>
			<div class="input">
				<p>性別</p>
				<select name="sex">
					<?php if (isset($_POST['weight'])) : ?>
						<?php if ($_POST['sex'] == 1) : ?>
							<option value="1">男</option>
							<option value="2">女</option>
							<option value="3">未選択</option>
						<?php elseif ($_POST['sex'] == 2) : ?>
							<option value="2">女</option>
							<option value="1">男</option>
							<option value="3">未選択</option>
						<?php else : ?>
							<option value="3">未選択</option>
							<option value="1">男</option>
							<option value="2">女</option>
						<?php endif; ?>
					<?php else : ?>
						<?php if ($user['sex'] == 1) : ?>
							<option value="1">男</option>
							<option value="2">女</option>
							<option value="3">未選択</option>
						<?php elseif ($user['sex'] == 2) : ?>
							<option value="2">女</option>
							<option value="1">男</option>
							<option value="3">未選択</option>
						<?php else : ?>
							<option value="3">未選択</option>
							<option value="1">男</option>
							<option value="2">女</option>
						<?php endif; ?>
					<?php endif; ?>
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