<?php
require_once(ROOT_PATH . 'Controllers/CategoryController.php');
$categories = new CategoryController();
$params = $categories->index();
$error = '';
//追加
if (isset($_POST['category_name'])) {
	//改善の余地あり？
	foreach ($params['category'] as $category) {
		if ($_POST['category_name'] == $category['category_name']) {
			$error = '既に登録されています。';
			break;
		}
	}
	//$errorがnullならば登録されていないので追加
	if (empty($error)) {
		$insert = $categories->insert();
		//ページのリフレッシュ
		header("Refresh:1");
	}
}
//削除
if (isset($_POST['category_id'])) {
	$deleted = $categories->deleted();
	//ページのリフレッシュ
	header("Refresh:1");
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
	<table class='insert'>
		<tr>
			<form action="" method="post" onSubmit="return insert()">
				<th><input type="text" name="category_name" value="<?php if (isset($_POST['category_name'])) {
																		echo $_POST['category_name'];
																	} ?>" required></th>
				<th><input type="submit" value="追加" name="submit"></th>
			</form>
		</tr>
	</table>
	<div class='error'>
		<p><?php echo $error; ?></p>
	</div>
	<table class='list'>
		<tr>
			<th>カテゴリー</th>
			<th>削除</th>
		</tr>
		<?php foreach ($params['category'] as $category) : ?>
			<tr>
				<td><?= $category['category_name'] ?></td>
				<td>
					<form action="" method="post" onSubmit="return deleted()">
						<input type="hidden" name="category_id" value="<?= $category['category_id'] ?>" required>
						<input type="submit" value="削除" name="submit">
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php include("footer.php"); ?>
</body>

</html>