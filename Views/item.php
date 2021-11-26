<?php
require_once(ROOT_PATH . 'Controllers/ItemController.php');
$items = new ItemController();
$params = $items->view();
$item = $params['item'];

//削除
if (isset($_POST['item_id'])) {
  $deleted = $items->deleted();
  //ページのリフレッシュ
  header('Location: ./main.php');
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
  <div class="my_title">
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
    <tr>
      <th colspan="2">
        <a href="post.php?id=<?php //echo $_GET['id']; 
                              ?>">レビューを書く</a>
      </th>
    </tr>
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
    <tr>
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
    <tr>
      <td colspan="2">
        <form action="" method="post" onSubmit="return deleted()">
          <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>" required>
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
  <h1>投稿一覧</h1>
  <div class="view_list">
    <table>
      <tr>
        <th>ユーザー名</th>
        <th>年齢</th>
        <th>性別</th>
        <th>身長</th>
        <th>体重</th>
        <th>登録日</th>
        <th>サイズ</th>
        <th>投稿内容</th>
        <th class="<?PHP //echo $class; 
                    ?>">削除</th>
      </tr>
      <?php //foreach ($stmt3 as $row) : 
      ?>
      <tr>
        <td><?php //echo $row['ユーザー名']; 
            ?></td>
        <td><?php //echo $row['年齢']; 
            ?></td>
        <td><?php //echo $row['性別']; 
            ?></td>
        <td><?php //echo $row['身長']; 
            ?></td>
        <td><?php //echo $row['体重']; 
            ?></td>
        <td><?php //echo $row['登録日']; 
            ?></td>
        <td><?php //echo $row['サイズ']; 
            ?></td>
        <td><?php //echo $row['投稿内容']; 
            ?></td>
        <td class="<?PHP //echo $class; 
                    ?>"><a href="post_delete.php?id=<?php //echo $row['id']; 
                                                    ?>" class="delete">削除</a></td>
      </tr>
      <?php //endforeach; 
      ?>
    </table>
    <!-- <a href="post_delete.php">削除</a> -->
    <!-- ポップアップのみ表示&自分の投稿のみ削除可能にするか検討 -->
  </div>
  <?php include("footer.php"); ?>
</body>

</html>