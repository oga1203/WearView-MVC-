<?php
session_start();
require_once(ROOT_PATH . 'Controllers/UserController.php');
$users = new UserController();
$params = $users->indexManager();
//追加
if (isset($_POST['email'])) {
  //バリデーション機能がないので追加予定 => 一旦保留
  $update = $users->updateManager();
  //ページのリフレッシュ
  header("Refresh:1");
}

//削除
if (isset($_POST['user_id'])) {
  $deleted = $users->deletedManager();
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
      <th>追加管理者のメールアドレス</th>
      <th>追加</th>
    </tr>

    <tr>
      <form action="" method="post" onSubmit="return insert()">
        <th><input type="text" name="email" value="<?php if (isset($_POST['email'])) {
                                                      echo $_POST['email'];
                                                    } ?>" required></th>
        <th><input type="submit" value="追加" name="submit"></th>
      </form>
    </tr>
  </table>
  <table class='list'>
    <tr>
      <th>ユーザー名</th>
      <th>メールアドレス</th>
      <th>削除</th>
    </tr>
    <?php foreach ($params['manager'] as $manager) : ?>
      <tr>
        <td><?= $manager['user_name'] ?></td>
        <td><?= $manager['email'] ?></td>
        <td>
          <form action="" method="post" onSubmit="return deletedManager()">
            <input type="hidden" name="user_id" value="<?= $manager['user_id'] ?>" required>
            <input type="submit" value="変更" name="submit">
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php include("footer.php"); ?>
</body>

</html>