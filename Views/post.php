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
require_once(ROOT_PATH . 'Controllers/PostController.php');
$posts = new PostController();
$checkEmpty = $posts->checkEmpty();
if ($checkEmpty === true) {
	$check = $posts->checkSameUser();
	if ($check === false) {
		$comp_alert = "<script type='text/javascript'>
		alert('既に投稿しています・');
		location.href = 'item.php?item_id={$item['item_id']}';
		</script>";
		echo $comp_alert;
	} else {
		if ($check === true) {
			$insert = $posts->insert();
			$comp_alert = "<script type='text/javascript'>
			alert('投稿完了！');
			location.href = 'item.php?item_id={$item['item_id']}';
			</script>";
			echo $comp_alert;
		}
	}
} else {
	if ($checkEmpty === false) {
		$error = '必ず入力してください。';
	} else {
		$error = null;
	}
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
	<!-- <div class="aicon_pic">
		<p>pic</p>
	</div>
	<p>ブランド</p>
	<p>カテゴリー</p>
	<p>商品名</p> -->
	<div class="title">
		<h1>投稿内容記入</h1>
		<h2><?= $item['item_name']; ?></h2>
	</div>
	<div class="body">
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
			<div class="input">
				<p>投稿内容</p>
				<textarea name="review" placeholder=""></textarea>
			</div>
			<!-- エラーの際に表示 -->
			<?php if (isset($error)) { ?>
				<div class="error">
					<p><?php echo $error; ?></p>
				</div>
			<?php } ?>
			<!-- エラーの際に表示 -->
			<input type="hidden" name="item_id" value="<?= $item['item_id']; ?>"><!-- データのみ受け渡し -->
			<input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>"><!-- データのみ受け渡し -->
			<div class="sub">
				<input type="submit" value="登&nbsp;&nbsp;録" class="submit" style="font-size:18px;">
			</div>
		</form>
		<div class="reset">
			<a href="item.php?item_id=<?= $item['item_id'] ?>">戻&nbsp;&nbsp;る</a>
		</div>
	</div>
	<?php include("footer.php"); ?>
</body>

</html>