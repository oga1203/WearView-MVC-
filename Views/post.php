<?php
session_start();
// idが空の場合、リダイレクト
if (empty($_SESSION['user_id']) && empty($item['item_id'])) {
	header("Location: ./login.php");
	exit;
}
require_once(ROOT_PATH . 'Controllers/ItemController.php');
$items = new ItemController();
$params = $items->view();
$item = $params['item'];
//追加
if (isset($_POST['item_id']) && isset($_POST['user_id']) && isset($_POST['review'])) {
	require_once(ROOT_PATH . 'Controllers/PostController.php');
	$posts = new PostController();
	$insert = $posts->insert();
	header("Location: item.php?item_id={$item['item_id']}");
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
	<!-- <div class="aicon_pic">
		<p>pic</p>
	</div>
	<p>ブランド</p>
	<p>カテゴリー</p>
	<p>商品名</p> -->
	<div class="body">
		<div class="upbody">
			<h1>投稿内容記入</h1>
		</div>
		<div class="downbody">
			<form action="" method="post">
				<!-- 仕様固まってないので保留 -->
				<!-- <p>サイズ</p>
				<select name='size'>
					<option value=''>サイズを選択</option>
					<option value='XS'>XS</option>
					<option value='S'>S</option>
					<option value='M'>M</option>
					<option value='L'>L</option>
					<option value='XL'>XL</option>
					<option value='XXL'>XXL</option>
				</select> -->
				<p>投稿内容</p>
				<p><?= $item['item_name']; ?></p>
				<p>投稿内容</p>
				<textarea id="body" name="review" placeholder=""></textarea>
				<div class="button">
					<div class="back_button">
						<a href="item.php?item_id=<?= $item['item_id'] ?>">戻&nbsp;&nbsp;る</a>
					</div>
				</div>
				<input type="hidden" name="item_id" value="<?= $item['item_id']; ?>"><!-- データのみ受け渡し -->
				<input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>"><!-- データのみ受け渡し -->
				<input type="submit" value="登&nbsp;&nbsp;録" class="submit" style="font-size:18px;">
		</div>
		</form>
	</div>
	</div>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>