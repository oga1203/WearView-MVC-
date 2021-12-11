<?php
session_start();
require_once(ROOT_PATH . 'Controllers/BrandController.php');
$brands = new BrandController();
$params = $brands->index();
$error = '';
//追加
if (isset($_POST['brand_name'])) {
  //改善の余地あり？
  foreach ($params['brand'] as $brand) {
    if ($_POST['brand_name'] == $brand['brand_name']) {
      $error = '既に登録されています。';
      break;
    }
  }
  //$errorがnullならば登録されていないので追加
  if (empty($error)) {
    $insert = $brands->insert();
    $comp_alert = "<script type='text/javascript'>
    alert('追加しました！');
    location.href = 'brand.php';
    </script>";
    echo $comp_alert;
  }
}
//削除
if (isset($_POST['brand_id'])) {
  $deleted = $brands->deleted();
  $comp_alert = "<script type='text/javascript'>
  alert('削除しました！');
  location.href = 'brand.php';
  </script>";
  echo $comp_alert;
}
if (isset($_SESSION['role'])) {
  //管理者権限に分けて表示を選択
  if ($_SESSION['role'] == 0) {
    $table_class = null;
  } else {
    $table_class = 'none';
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
  <!-- 管理者のみ表示 -->
  <div class="<?php echo $table_class ?>">
    <table class='insert'>
      <tr>
        <td>ブランド</td>
        <td>追加</td>
      </tr>
      <tr>
        <form action="" method="post" onSubmit="return insert()">
          <th><input type="text" name="brand_name" value="<?php if (isset($_POST['brand_name'])) {
                                                            echo $_POST['brand_name'];
                                                          } ?>" required></th>
          <th><input type="submit" value="追加" name="submit"></th>
        </form>
      </tr>
    </table>
    <div class='error'>
      <p><?php echo $error; ?></p>
    </div>
  </div>
  <table class='list'>
    <tr>
      <th>ブランド</th>
      <th class="<?php echo $table_class ?>">削除</th>
    </tr>
    <?php foreach ($params['brand'] as $brand) : ?>
      <tr>
        <td><a href="brand_list.php?brand_id=<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></a></td>
        <!-- 管理者のみ表示 -->
        <td class="<?php echo $table_class ?>">
          <form action="" method="post" onSubmit="return deleted()">
            <input type="hidden" name="brand_id" value="<?= $brand['brand_id'] ?>" required>
            <input type="submit" value="削除" name="submit">
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php include("footer.php"); ?>
</body>

</html>