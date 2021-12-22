<?php
require_once(ROOT_PATH . 'Controllers/BrandController.php');
$brands = new BrandController();
$brand_lists = $brands->index();
require_once(ROOT_PATH . 'Controllers/CategoryController.php');
$categories = new CategoryController();
$category_lists = $categories->index();
$counter = 1;
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
  <div class="sidebar">
    <details>
      <summary>ブランド一覧</summary>
      <?php foreach ($brand_lists['brand'] as $brand_list) : ?>
        <li>
          <?php if ($counter == 10) : ?>
            <a href="brand.php">もっと見る</a>
            <?php break; ?>
          <?php endif; ?>
          <a href="brand_list.php?brand_id=<?= $brand_list['brand_id'] ?>"><?= $brand_list['brand_name'] ?></a>
        </li>
        <?php $counter++; ?>
      <?php endforeach; ?>
    </details>
    <details>
      <summary>カテゴリー一覧</summary>
      <?php foreach ($category_lists['category'] as $category_list) : ?>
        <li>
          <a href="category_list.php?category_id=<?= $category_list['category_id'] ?>">
            <?= $category_list['category_name'] ?>
          </a>
        </li>
      <?php endforeach; ?>
    </details>
  </div>
</body>

</html>