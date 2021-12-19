<?php
session_start();
require_once(ROOT_PATH . 'Controllers/ItemController.php');
$items = new ItemController();
$params = $items->viewBrandList();
//削除
if (isset($_POST['item_id'])) {
  $deleted = $items->deleted();
  $comp_alert = "<script type='text/javascript'>
  alert('削除しました！');
  location.href = 'brand_list.php?brand_id={$item['brand_id']}';
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
  <table class='list'>
    <tr>
      <th>商品名</th>
      <th>ブランド</th>
      <!-- 不要かな？ -->
      <!-- <th>カテゴリー</th>
      <th>中カテゴリー</th> -->
      <?php if (isset($_SESSION['user_id'])) : ?>
        <?php if ($_SESSION['role'] == 0) : ?>
          <th>削除</th>
        <?php endif; ?>
      <?php endif; ?>
    </tr>
    <?php foreach ($params['item'] as $item) : ?>
      <tr>
        <td><a href="item.php?item_id=<?= $item['item_id'] ?>"><?= $item["item_name"] ?></a></td>
        <td><?= $item["brand_name"] ?></td>
        <!-- 不要かな？ -->
        <!-- <td><?= $item["category_name"] ?></td>
        <td><?= $item["category_mid_name"] ?></td> -->
        <!-- 管理者のみ表示 -->
        <?php if (isset($_SESSION['user_id'])) : ?>
          <?php if ($_SESSION['role'] == 0) : ?>
            <td>
              <form action="" method="post" onSubmit="return deleted()">
                <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                <input type="submit" value="削除" name="submit">
              </form>
            </td>
          <?php endif; ?>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php include("footer.php"); ?>
</body>

</html>