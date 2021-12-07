<?php
session_start();
// idが空の場合、リダイレクト
if (empty($_SESSION['user_id'])) {
	header("Location: ./login.php");
	exit;
}
require_once(ROOT_PATH . 'Controllers/ItemController.php');
$items = new ItemController();
$params = $items->index();
require_once(ROOT_PATH . 'Controllers/BrandController.php');
$brands = new BrandController();
$ba_params = $brands->index();
require_once(ROOT_PATH . 'Controllers/CategoryController.php');
$categories = new CategoryController();
$ca_params = $categories->index();
require_once(ROOT_PATH . 'Controllers/CategoryMidController.php');
$categories_mid = new CategoryMidController();
$ca_m_params = $categories_mid->index();
//追加
if (isset($_POST['brand_id']) && isset($_POST['category_id']) && isset($_POST['category_mid_id']) && isset($_POST['item_name'])) {
	if (empty($error)) {
		$insert = $items->insert();
		$comp_alert = "<script type='text/javascript'>
		alert('追加しました！');
		location.href = 'main.php';
		</script>";
		echo $comp_alert;
	}
}
//削除
if (isset($_POST["item_id"])) {
	$deleted = $items->deleted();
	$comp_alert = "<script type='text/javascript'>
	alert('削除しました！');
	location.href = 'main.php';
	</script>";
	echo $comp_alert;
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
	<table class="insert">
		<tr>
			<th>ブランド</th>
			<th>カテゴリー</th>
			<th>中カテゴリー</th>
			<th>商品名</th>
			<th>商品品番</th>
			<th>商品説明</th>
		</tr>
		<tr>
			<form action="" method="post" onSubmit="return insert()">
				<td>
					<label>
						<select name="brand_id">
							<option value="">ブランドを選択</option>
							<?php foreach ($ba_params["brand"] as $brand) : ?>
								<option value="<?= $brand["brand_id"] ?>">
									<?= $brand["brand_name"] ?>
								</option>
							<?php endforeach; ?>
						</select>
					</label>
				</td>
				<td>
					<label>
						<select name="category_id">
							<option value="">カテゴリーを選択</option>
							<?php foreach ($ca_params["category"] as $category) : ?>
								<option value="<?= $category["category_id"] ?>">
									<?= $category["category_name"] ?>
								</option>
							<?php endforeach; ?>
						</select>
					</label>
				</td>
				<td>
					<label>
						<select name="category_mid_id">
							<option value="">中カテゴリーを選択</option>
							<?php foreach ($ca_m_params["category_mid"] as $category_mid) : ?>
								<option value="<?= $category_mid["category_mid_id"] ?>">
									<?= $category_mid["category_mid_name"] ?>
								</option>
							<?php endforeach; ?>
						</select>
					</label>
				</td>
				<td>
					<input type="text" name="item_name" value="<?php if (isset($_POST["item_name"])) {
																	echo $_POST["item_name"];
																} ?>" required>
				</td>
				<td>
					<input type="text" name="item_number" value="<?php if (isset($_POST["item_number"])) {
																		echo $_POST["item_number"];
																	} ?>">
				</td>
				<td>
					<input type="text" name="item_explanation" value="<?php if (isset($_POST["item_explanation"])) {
																			echo $_POST["item_explanation"];
																		} ?>">
				</td>
		</tr>
		<tr>
			<th colspan="6"><input type="submit" value="追加" name="submit"></th>
			</form>
		</tr>
	</table>
	<table class="list">
		<tr>
			<th>商品名</th>
			<th>ブランド</th>
			<th>カテゴリー</th>
			<th>中カテゴリー</th>
			<th>詳細</th>
			<th class="<?PHP echo $class; ?>">削除</th>
		</tr>
		<?php foreach ($params["item"] as $item) : ?>
			<tr>
				<td><?= $item["item_name"] ?></td>
				<td><?= $item["brand_name"] ?></td>
				<td><?= $item["category_name"] ?></td>
				<td><?= $item["category_mid_name"] ?></td>
				<td><a href="item.php?item_id=<?= $item['item_id'] ?>">詳細</a></td>
				<td>
					<form action="" method="post" onSubmit="return deleted()">
						<input type="hidden" name="item_id" value="<?= $item["item_id"] ?>" required>
						<input type="submit" value="削除" name="submit">
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php include("footer.php"); ?>
</body>

</html>