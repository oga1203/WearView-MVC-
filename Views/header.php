<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>Wear View</title>
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body>
	<div class="header">
		<a href="main.php">Wear View</a>
		<div class="">
			<?php if (isset($_SESSION['user_id'])) : ?>
				<!-- 管理者がログイン状態で表示 -->
				<?php if ($_SESSION['role'] == 0) : ?>
					<a href="manager_list.php" class="">管理者一覧</a>
				<?php endif; ?>
			<?php endif; ?>
			<!-- 不要？検討中 -->
			<!-- <a href="category.php">カテゴリー検索</a> -->
			<!-- 不要？検討中 -->
			<!-- <a href="category_mid.php">中カテゴリー一覧</a> -->
			<?php if (isset($_SESSION['user_id'])) : ?>
				<!-- 管理者がログイン状態で表示 -->
				<?php if ($_SESSION['role'] == 0) : ?>
					<a href="brand.php">ブランド検索</a>
				<?php endif; ?>
			<?php endif; ?>
			<!-- 不要？検討中 -->
			<a href="search.php">検索</a>
			<!-- ログインまたはログアウト判定 -->
			<?php if (isset($_SESSION['user_id'])) : ?>
				<a href="mypage.php?user_id=<?= $_SESSION['user_id'] ?>" class="">マイページ</a>
				<a href="logout.php">ログアウト</a>
			<?php else : ?>
				<a href="login.php">ログイン</a>
			<?php endif; ?>
		</div>
	</div>
</body>

</html>