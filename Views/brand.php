<?php
require_once(ROOT_PATH . 'Controllers/BrandController.php');
$brands = new BrandController();
$params = $brands->index();
$error = '';
//ブランド追加
if (isset($_POST['brand_name'])) {
  //改善の余地あり？
  foreach ($params['brand'] as $brand) {
    if ($_POST['brand_name'] == $brand['brand_name']) {
      $error = '既に登録されています。';
      break;
    }
  }
  //$errorがnullならば登録されていないので追加
  if ($error == null) {
    $insert = $brands->insert();
    //ページのリフレッシュ
    header("Refresh:1");
  }
}
//削除
if (isset($_POST['brand_id'])) {
  $deleted = $brands->deleted();
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
  <table class='list'>
    <tr>
      <th>ブランド</th>
      <th>削除</th>
    </tr>
    <?php foreach ($params['brand'] as $brand) : ?>
      <tr>
        <td><?= $brand['brand_name'] ?></td>
        <td>
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