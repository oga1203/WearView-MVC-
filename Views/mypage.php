<?php
session_start();
//idが空の場合、リダイレクト
if (empty($_SESSION['user_id'])) {
  header("Location: ./login.php");
  exit;
}
require_once(ROOT_PATH . 'Controllers/UserController.php');
$users = new UserController();
$params = $users->viewUser();
$user = $params['user'];
if ($user['sex'] == 1) {
  $sex = '男性';
} elseif ($user['sex'] == 2) {
  $sex = '女性';
} else {
  $sex = '未選択';
}
require_once(ROOT_PATH . 'Controllers/PostController.php');
$posts = new PostController();
$p_params = $posts->view();
//投稿の削除
if (isset($_POST['post_id'])) {
  $deleted = $posts->deleted();
  //ページのリフレッシュ
  header("Location: mypage.php?user_id={$user['user_id']}");
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
  <div class="title">
    <h1>マイページ</h1>
  </div>
  <table>
    <tr>
      <th>ユーザー名</th>
      <td><?= $user['user_name']; ?></td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?= $user['email']; ?></td>
    </tr>
    <tr>
      <th>年齢</th>
      <td><?= $user['age']; ?></td>
    </tr>
    <tr>
      <th>身長</th>
      <td><?= $user['height']; ?></td>
    </tr>
    <tr>
      <th>体重</th>
      <td><?= $user['weight']; ?></td>
    </tr>
    <tr>
      <th>性別</th>
      <td><?php echo $sex; ?></td>
    </tr>
    <tr>
      <!-- <th></th> -->
      <td colspan="2"><a href="mypage_edit.php?user_id=<?= $_SESSION['user_id'] ?>">編集</a></td>
    </tr>
  </table>
  </div>
  <hr>
  <div class="title">
    <h1>投稿一覧</h1>
  </div>
  <table class="list">
    <tr>
      <th>商品名</th>
      <th>ブランド</th>
      <th>カテゴリー</th>
      <th>投稿内容</th>
      <!-- <th>登録日</th> -->
      <th class="<?PHP echo $class; ?>">削除</th>
    </tr>
    <?php foreach ($p_params['post'] as $post) : ?>
      <tr>
        <td><a href="item.php?item_id=<?= $post['item_id'] ?>"><?= $post["item_name"] ?></a></td>
        <td><?= $post["brand_name"] ?></td>
        <td><?= $post["category_name"] ?></td>
        <td><?= $post["review"] ?></td>
        <td>
          <form action="" method="post" onSubmit="return deleted()">
            <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>" required>
            <input type="submit" value="削除" name="submit">
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <hr>
  <div class="title">
    <h1>お気に入り一覧</h1>
  </div>
  <table>
    <tr>
      <th>商品名</th>
    </tr>
    <?php //foreach ($stmt2 as $row) : 
    ?>
    <tr>
      <td><a href="goods.php?id=<?php //echo $row['ID']; 
                                ?>"><?php //echo $row['商品名']; 
                                    ?></a></td>
    </tr>
    <?php //endforeach; 
    ?>
  </table>
  <?php include("footer.php"); ?>
</body>

</html>