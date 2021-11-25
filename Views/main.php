<?php
require_once(ROOT_PATH . 'Controllers/ItemController.php');
$items = new ItemController();
$params = $items->index();
//削除
if (isset($_POST['item_id'])) {
	$deleted = $items->deleted();
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
	<table class='list'>
		<tr>
			<th>商品名</th>
			<th>ブランド</th>
			<th>カテゴリー</th>
			<th>中カテゴリー</th>
			<th class="<?PHP echo $class; ?>">削除</th>
		</tr>
		<?php foreach ($params['item'] as $item) : ?>
			<tr>
				<td><?= $item['item_name'] ?></td>
				<td><?= $item['brand_name'] ?></td>
				<td><?= $item['category_name'] ?></td>
				<td><?= $item['category_mid_name'] ?></td>
				<td>
					<form action="" method="post" onSubmit="return deleted()">
						<input type="hidden" name="item_id" value="<?= $item['item_id'] ?>" required>
						<input type="submit" value="削除" name="submit">
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php include("footer.php"); ?>
</body>

</html>