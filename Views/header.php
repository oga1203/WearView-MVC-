<?php
if (isset($_SESSION['role'])) {
	$link = 'logout.php';
	$link_name = 'ログアウト';
	$mypage = $_SESSION['user_id'];
	//管理者権限に分けて表示を選択
	if ($_SESSION['role'] == 0) {
		$role = null;
	} else {
		$role = 'none';
	}
} else {
	$link = 'login.php';
	$link_name = 'ログイン';
	$mypage = null;
	$table_class = 'none';
	$role = 'none';
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
	<div class="header">
		<a href="main.php">Wear View</a>
		<div class="">
			<a href="manager_list.php" class="<?php echo $role; ?>">管理者一覧</a><!-- 管理者がログイン状態で表示 -->
			<a href="category.php">カテゴリー検索</a>
			<!-- 不要？検討中 -->
			<!-- <a href="category_mid.php">中カテゴリー一覧</a> -->
			<a href="brand.php">ブランド検索</a>
			<a href="mypage.php?user_id=<?= $mypage ?>" class="<?php echo $table_class; ?>">マイページ</a>
			<!-- 不要？検討中 -->
			<!-- <a href=" search.php">検索</a> -->
			<a href="<?php echo $link; ?>"><?php echo $link_name; ?></a><!-- ログイン状態で表示 -->
		</div>
	</div>
</body>

</html>