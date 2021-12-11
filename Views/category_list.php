<?php
session_start();
require_once(ROOT_PATH . 'Controllers/CategoryMidController.php');
$items = new CategoryMidController();
$params = $items->viewCategoryList();
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
      <th>中カテゴリー</th>
    </tr>
    <?php foreach ($params['category_mid'] as $category_mid) : ?>
      <tr>
        <td><a href="category_mid_list.php?category_mid_id=<?= $category_mid['category_mid_id'] ?>"><?= $category_mid["category_mid_name"] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php include("footer.php"); ?>
</body>

</html>