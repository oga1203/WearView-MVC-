<?php
session_start();
//idが空の場合、リダイレクト
require_once(ROOT_PATH . 'Controllers/UserController.php');
$users = new UserController();
$params = $users->viewUser();
$user = $params['user'];
require_once(ROOT_PATH . 'Controllers/FavoriteController.php');
$favorites = new FavoriteController();
$favorite_item = $favorites->indexUser();
require_once(ROOT_PATH . 'Controllers/PostController.php');
$posts = new PostController();
$p_params = $posts->view();
//投稿の削除
if (isset($_POST['post_id'])) {
  $deleted = $posts->deleted();
  //ページのリフレッシュ
  header("Location: mypage.php?user_id={$user['user_id']}");
}
//お気に入りの削除の削除
if (isset($_POST['favorite_id'])) {
  $favorites->deletedUserFavoriteItem();
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
      <td>
        <?php if (isset($user['user_name'])) : ?>
          <?= $user['user_name']; ?>
        <?php else : ?>
          <p>登録されていません。</p>
        <?php endif; ?>
      </td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?= $user['email']; ?></td>
    </tr>
    <!-- 一旦保留 -->
    <!-- <tr>
      <th>年齢</th>
      <td><?= $user['age']; ?></td>
    </tr> -->
    <tr>
      <th>身長</th>
      <td>
        <?php if (isset($user['height'])) : ?>
          <?= $user['height']; ?>cm
        <?php else : ?>
          <p>登録されていません。</p>
        <?php endif; ?>
      </td>
    </tr>
    <tr>
      <th>体重</th>
      <td>
        <?php if (isset($user['weight'])) : ?>
          <?= $user['weight']; ?>kg
        <?php else : ?>
          <p>登録されていません。</p>
        <?php endif; ?>
      </td>
    </tr>
    <tr>
      <th>性別</th>
      <td>
        <?php if ($user['sex'] == 1) : ?>
          男性
        <?php elseif ($user['sex'] == 2) : ?>
          女性
        <?php else : ?>
          未選択
        <?php endif; ?>
      </td>
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
  <?php if (empty($p_params)) : ?>
    <div class="no_list">
      <p>投稿がありません。</p>
    </div>
  <?php else : ?>
    <table class="list">
      <tr>
        <th>商品名</th>
        <th>ブランド</th>
        <th>カテゴリー</th>
        <th>投稿内容</th>
        <!-- <th>登録日</th> -->
        <th class="<?PHP echo $class; ?>">削除</th>
      </tr>
      <?php foreach ($p_params as $post) : ?>
        <tr>
          <td><a href="item.php?item_id=<?= $post['item_id'] ?>"><?php echo $post["item_name"] ?></a></td>
          <td><?php echo $post["brand_name"] ?></td>
          <td><?php echo $post["category_name"] ?></td>
          <td><?php echo $post["review"] ?></td>
          <td>
            <form action="" method="post" onSubmit="return deleted()">
              <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>" required>
              <input type="submit" value="削除" name="submit">
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
  <hr>
  <div class="title">
    <h1>お気に入り一覧</h1>
  </div>
  <?php if (empty($favorite_item)) : ?>
    <div class="no_list">
      <p>お気に入り商品がありません。</p>
    </div>
  <?php else : ?>
    <table class="list">
      <tr>
        <th>商品名</th>
        <th>削除</th>
      </tr>
      <?php foreach ($favorite_item as $favorite) : ?>
        <tr>
          <td><a href="item.php?item_id=<?= $favorite['item_id']; ?>"><?php echo $favorite['item_name']; ?></a></td>
          <td>
            <form action="" method="post" onSubmit="return deleted()">
              <input type="hidden" name="favorite_id" value="<?= $favorite['favorite_id'] ?>">
              <input type="submit" value="削除" name="submit">
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
  <?php include("footer.php"); ?>
</body>

</html>