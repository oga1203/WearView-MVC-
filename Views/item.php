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
if (isset($_SESSION['role'])) {
  //管理者権限に分けて表示を選択
  if ($_SESSION['role'] == 0) {
    $table_class = null;
  } else {
    $table_class = 'none';
  }
  $view = null;
  $log = 'none';
} else {
  $view = 'none';
  $log = null;
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
  <?php //include("login_now.php");
  ?>
  <div class="title">
    <h1><?= $item['item_name']; ?></h1><!-- DBから引用 -->
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
    <!-- ログインすると表示 -->
    <tr class="<?PHP echo $view; ?>">
      <th colspan="2">
        <a href="post.php?item_id=<?= $item['item_id'] ?>">レビューを書く</a>
      </th>
    </tr>
    <!-- ログインすると表示 -->
    <!-- ログインしていないときに表示 -->
    <tr class="<?PHP echo $log; ?>">
      <td colspan="2">
        <p>ログインするとレビューを書けます。</p>
      </td>
    </tr>
    <!-- ログインしていないときに表示 -->
    <?PHP
    // $sql2 = "SELECT COUNT(*) AS count FROM likes WHERE goods_id = $goods_id AND user_id = $user_id ";

    // $stmt2 = $dbh->prepare($sql2);
    // $stmt2->bindParam(':id', $id, PDO::PARAM_STR);
    // $stmt2->execute();
    // $member = $stmt2->fetch();

    // if ($member['count'] > 0) {
    //   $likes_id = 'お気に入り済';
    // } else {
    //   $likes_id = 'お気に入り';
    // }
    ?>
    <!-- ログインすると表示 -->
    <tr class="<?PHP echo $view; ?>">
      <th colspan="2">
        <input type="hidden" name="user_id" value="<?php //echo $user_id; 
                                                    ?>">
        <input type="hidden" name="goods_id" value="<?php //echo $goods_id; 
                                                    ?>">
        <div id="result"><?php //echo $likes_id; 
                          ?></div>
        <input type="button" class="sample_btn" id="result" value="お気に入り登録">
      </th>
    </tr>
    <!-- ログインすると表示 -->
    <!-- ログインしていないときに表示 -->
    <tr class="<?PHP echo $log; ?>">
      <td colspan="2">
        <p>ログインするとお気に入り登録できます。</p>
      </td>
    </tr>
    <!-- ログインしていないときに表示 -->
    <tr class="<?php echo $view ?>">
      <td colspan="2">
        <form action="" method="post" onSubmit="return deleted()">
          <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
          <input type="submit" value="削除" name="submit">
        </form>
      </td>
    </tr>
  </table>
  </div>
  <!---------------------------------------------------------------------------------------->
  <script>
    $(function() {
      //.sampleをクリックしてajax通信を行う
      $('.sample_btn').click(function() {
        $.ajax({
          url: 'favorite.php',
          type: 'POST',
          /* json形式で受け取るためdataTypeを変更 */
          dataType: 'text',
          data: {
            user_id: $('[name="user_id"]').val(),
            goods_id: $('[name="goods_id"]').val()
          }
        }).done(function(data) {
          //alert('通信成功！');
          $('#result').text(data);

        }).fail(function(data) {
          /* 通信失敗時 */
          alert('通信失敗！');

        });
      });
    });
  </script>
  <!---------------------------------------------------------------------------------------->
  <hr>
  <div class="title">
    <h1>投稿一覧</h1>
  </div>
  <table class="list">
    <tr>
      <th>ユーザー名</th>
      <th>年齢</th>
      <th>性別</th>
      <th>身長</th>
      <th>体重</th>
      <!-- 一旦、保留 -->
      <!-- <th>登録日</th> -->
      <!-- <th>サイズ</th> -->
      <th>投稿内容</th>
      <!-- ここの表示をどうするか検討中 -->
      <!-- <th class="<?PHP echo $table_class; ?>">削除</th> -->
    </tr>
    <?php
    foreach ($p_params["post"] as $post) :
      // DBの性別判定表示
      if ($post["sex"] == 1) {
        $sex = '男';
      } elseif ($post["sex"] == 2) {
        $sex = '女';
      } else {
        $sex = '不明';
      }
      if (isset($_SESSION['user_id'])) {
        // 自分が投稿した投稿のみ削除可能
        if ($post["user_id"] == $_SESSION["user_id"]) {
          $table_class = null;
        } else {
          $table_class = 'none';
        }
      } else {
        $table_class = 'none';
      }
    ?>
      <tr>
        <td><?= $post["user_name"] ?></td>
        <td><?= $post["age"] ?></td>
        <td><?php echo $sex; ?></td>
        <td><?= $post["height"] ?></td>
        <td><?= $post["weight"] ?></td>
        <td><?= $post["review"] ?></td>
        <td class="<?php echo $table_class ?>">
          <form action="" method="post" onSubmit="return deleted()">
            <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
            <input type="submit" value="削除" name="submit">
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php include("footer.php"); ?>
</body>

</html>