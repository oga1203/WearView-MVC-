<?php
session_start();
require_once(ROOT_PATH . 'Controllers/CategoryMidController.php');
$categories_mid = new CategoryMidController();
$params = $categories_mid->index();
require_once(ROOT_PATH . 'Controllers/CategoryController.php');
$categories = new CategoryController();
$ca_params = $categories->index();
// 固定するので不要？検討中
// $error = '';
// //追加
// if (isset($_POST['category_mid_name']) && isset($_POST['category_id'])) {
// 	//改善の余地あり？
// 	foreach ($params['category_mid'] as $category_mid) {
// 		if ($_POST['category_mid_name'] == $category_mid['category_mid_name']) {
// 			$error = '既に登録されています。';
// 			break;
// 		}
// 	}
// 	//$errorがnullならば登録されていないので追加
// 	if (empty($error)) {
// 		$insert = $categories_mid->insert();
// 		$comp_alert = "<script type='text/javascript'>
// 		alert('追加しました！');
// 		location.href = 'category_mid.php';
// 		</script>";
// 		echo $comp_alert;
// 	}
// }
// //削除
// if (isset($_POST['category_mid_id'])) {
// 	$deleted = $categories_mid->deleted();
// 	$comp_alert = "<script type='text/javascript'>
// 	alert('削除しました！');
// 	location.href = 'category_mid.php';
// 	</script>";
// 	echo $comp_alert;
// }
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
	<!-- 固定するので不要？検討中 -->
	<!-- <table class='insert'>
		<tr>
			<td>カテゴリー</td>
			<td>中カテゴリー</td>
			<td>追加</td>
		</tr>
		<tr>
			<form action="" method="post" onSubmit="return insert()">
				<th>
					<label>
						<select name="category_id">
							<option value="">カテゴリーを選択</option>
							<?php foreach ($ca_params['category'] as $category) : ?>
								<option value="<?= $category["category_id"] ?>">
									<?= $category["category_name"] ?>
								</option>
							<?php endforeach; ?>
						</select>
					</label>
				</th>
				<th><input type="text" name="category_mid_name" value="<?php if (isset($_POST['category_mid_name'])) {
																			echo $_POST['category_mid_name'];
																		} ?>" required></th>
				<th><input type="submit" value="追加" name="submit"></th>
			</form>
		</tr>
	</table>
	<div class='error'>
		<p><?php echo $error; ?></p>
	</div> -->
	<!-- 固定するので不要？検討中 -->
	<table class='list'>
		<tr>
			<th>カテゴリー</th>
			<th>中カテゴリー</th>
			<!-- 固定するので不要？検討中 -->
			<!-- <th>削除</th> -->
		</tr>
		<?php foreach ($params['category_mid'] as $category_mid) : ?>
			<tr>
				<td><?= $category_mid['category_name'] ?></td>
				<td><?= $category_mid['category_mid_name'] ?></td>
				<!-- 固定するので不要？検討中 -->
				<!-- <td>
					<form action="" method="post" onSubmit="return deleted()">
						<input type="hidden" name="category_mid_id" value="<?= $category_mid['category_mid_id'] ?>" required>
						<input type="submit" value="削除" name="submit">
					</form>
				</td> -->
				<!-- 固定するので不要？検討中 -->
			</tr>
		<?php endforeach; ?>
	</table>
	<?php include("footer.php"); ?>
</body>

</html>