<?php
session_start();
require_once(ROOT_PATH . 'Controllers/ItemController.php');
$items = new ItemController();
$params = $items->view();
$item = $params['item'];
require_once(ROOT_PATH . 'Controllers/PostController.php');
$posts = new PostController();
$p_params = $posts->findByItemId();
$post = $p_params['post'];
require_once(ROOT_PATH . 'Controllers/FavoriteController.php');
$favorites = new FavoriteController();
// $user_id = $_SESSION['user_id'];
$fav = $favorites->index();
//アイテムの削除
if (isset($_POST['item_id'])) {
  $deleted = $items->deleted();
  //ページのリフレッシュ
  header("Location: main.php");
}
//投稿の削除
if (isset($_POST['post_id'])) {
  $deleted = $posts->deleted();
  //ページのリフレッシュ
  header("Location: item.php?item_id={$item['item_id']}");
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
  <!-- jsファイルに格納できないか検討 -->
  <script>
    $(function() {
      // ボタンがクリックされたら
      $(".sample_btn").on("click", function(event) {
        // 入力されたID値を取得
        item_id = $('.item_id').val();
        user_id = $('.user_id').val();
        $.ajax({
          type: "POST",
          url: "favorite.php",
          data: {
            "item_id": item_id,
            "user_id": user_id,
          },
          dataType: "text"
        }).done(function(data) {
          $('#result').text(data);
        }).fail(function(XMLHttpRequest, status, e) {
          alert(e);
        });
      });
    });
  </script>
</head>

<body>
  <?php include("header.php"); ?>
  <div class="main">
    <?php include("sidebar.php"); ?>
    <div class="inside">
      <div class="title">
        <h1><?= $item['item_name']; ?></h1>
      </div>
      <table class="insert">
        <tr>
          <th>品番</th>
          <td><?= $item['item_number']; ?></td>
        </tr>
        <tr>
          <th>ブランド</th>
          <td><?= $item['brand_name']; ?></td>
        </tr>
        <tr>
          <th>カテゴリー</th>
          <td><?= $item['category_name']; ?></td>
        </tr>
        <tr>
          <th>中カテゴリー</th>
          <td><?= $item['category_mid_name']; ?></td>
        </tr>
        <tr>
          <th>商品説明</th>
          <td><?= $item['item_explanation']; ?></td>
        </tr>
        <tr>
          <th colspan="2">
            <?php if (isset($_SESSION['user_id'])) : ?>
              <a href="post.php?item_id=<?= $item['item_id'] ?>">レビューを書く</a>
            <?php else : ?>
              ログインするとレビューを書けます。
            <?php endif; ?>
          </th>
        </tr>
        <tr>
          <th colspan="2">
            <?php if (isset($_SESSION['user_id'])) : ?>
              <input type="hidden" class="user_id" name="user_id" value="<?= $_SESSION['user_id']; ?>">
              <input type="hidden" class="item_id" name="item_id" value="<?= $_GET['item_id']; ?>">
              <div id="result"><?php echo $fav; ?></div>
              <input type="button" class="sample_btn" id="result" value="お気に入り登録">
            <?php else : ?>
              ログインするとお気に入り登録できます。
            <?php endif; ?>
          </th>
        </tr>
        <?php if (isset($_SESSION['user_id'])) : ?>
          <?php if ($_SESSION['role'] == 0) : ?>
            <tr>
              <td colspan="2">
                <form action="" method="post" onSubmit="return deleted()">
                  <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                  <input type="submit" value="削除" name="submit">
                </form>
              </td>
            </tr>
          <?php endif; ?>
        <?php endif; ?>
      </table>
      <!-- </div> -->
      <hr>
      <div class="title">
        <h1>投稿一覧</h1>
      </div>
      <table class="list">
        <tr>
          <th>ユーザー名</th>
          <!-- 一旦、保留 -->
          <!-- <th>年齢</th> -->
          <th>性別</th>
          <th>身長</th>
          <th>体重</th>
          <!-- 一旦、保留 -->
          <!-- <th>登録日</th> -->
          <!-- <th>サイズ</th> -->
          <th>投稿内容</th>
        </tr>
        <?php foreach ($p_params["post"] as $post) : ?>
          <tr>
            <td><?= $post["user_name"] ?></td>
            <!-- 一旦、保留 -->
            <!-- <td><?= $post["age"] ?></td> -->
            <td>
              <!-- DBの性別判定表示 -->
              <?php if ($post["sex"] == 1) : ?>
                男性
              <?php elseif ($post["sex"] == 2) : ?>
                女性
              <?php else : ?>
                不明
              <?php endif; ?>
            </td>
            <td><?= $post["height"] ?></td>
            <td><?= $post["weight"] ?></td>
            <?php if (isset($_SESSION['user_id'])) : ?>
              <td><?= $post["review"] ?></td>
              <?php if ($post["user_id"] == $_SESSION['user_id']) : ?>
                <td>
                  <form action="" method="post" onSubmit="return deleted()">
                    <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                    <input type="submit" value="削除" name="submit">
                  </form>
                </td>
              <?php endif; ?>
            <?php else : ?>
              <td>ログインすると投稿内容が見れます。</td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
  <?php include("footer.php"); ?>
</body>

</html>