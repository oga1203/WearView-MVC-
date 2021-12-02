<?php
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
	<div class="header">
		<a href="main.php">Wear View</a>
		<div class="">
			<a href="manager_list.php" class="">管理者一覧</a><!-- 管理者がログイン状態で表示 -->
			<a href="category.php">カテゴリー一覧</a>
			<a href="category_mid.php">中カテゴリー一覧</a>
			<a href="brand.php">ブランド一覧</a>
			<a href="mypage.php?user_id=<?= $_SESSION['user_id'] ?>">マイページ</a>
			<a href="logout.php">ログアウト</a><!-- ログイン状態で表示 -->
		</div>
	</div>
</body>

</html>