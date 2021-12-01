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
//   // データベースの処理
//   require './dbc.php';
//   $sql = "SELECT * FROM users Where id = :id";
//   $dbh = dbConnect();

//   try {
//     // レコードの取得
//     // プレースホルダーによるSQLインジェクション対策
//     $stmt = $dbh->prepare($sql);
//     $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
//     $stmt->execute();
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     // idが存在しない場合、リダイレクト
//     if (!$result) {
//       header("Location: ./login_form.php");
//       exit;
//     }
//     // カラムの値をそれぞれ変数に代入
//     $goods_id = $result['id'];
//     $user_name = $result['user_name'];
//     $email = $result['email'];
//     $age = $result['age'];
//     $weight = $result['weight'];
//     $height = $result['height'];
//     $sex = $result['sex'];
//   } catch(PDOException $e) {
//     exit($e);
//   }
//   $sql1 = "SELECT post.id, goods.goods_name AS 商品名, category.category AS カテゴリー, brand.brand AS ブランド, post AS 投稿内容, DATE_FORMAT(created_at, '%Y年%m月%d日') AS 登録日, goods.id AS 商品id, category.id AS カテゴリーid, brand.id AS ブランドid FROM post LEFT JOIN goods on post.goods_id = goods.id LEFT JOIN brand on goods.brand_id = brand.id LEFT JOIN category on goods.category_id = category.id WHERE user_id = :id";
//   try {
//     // レコードの取得
//     // プレースホルダーによるSQLインジェクション対策
//     $stmt1 = $dbh->prepare($sql1);
//     $stmt1->bindValue(':id', (int)$id, PDO::PARAM_INT);
//     $stmt1->execute();
//   } catch(PDOException $e) {
//     exit($e);
//   }


//   $sql2 = "SELECT goods.id AS ID, goods.goods_name AS 商品名 FROM likes LEFT JOIN goods on likes.goods_id = goods.id WHERE user_id = :id";
//   try {

//     // レコードの取得
//     // プレースホルダーによるSQLインジェクション対策
//     $stmt2 = $dbh->prepare($sql2);
//     $stmt2->bindValue(':id', (int)$id, PDO::PARAM_INT);
//     $stmt2->execute();

//   } catch(PDOException $e) {
//     exit($e);
//   }
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>Wear View</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
  <script src="/js/base.js"></script>
</head>

<body>
  <?php include("header.php"); ?>
  <div class="my_title">
    <h1>マイページ</h1>
  </div>
  <!--<div class="prof">
		<div class="aicon_pic">
			<p>pic</p>-->
  <!-- DBから引用? -->
  <!--</div>-->
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
      <th></th>
      <td><a href="mypage_edit.php?user_id=<?= $_SESSION['user_id'] ?>">編集</a></td>
    </tr>
  </table>
  </div>
  <hr>
  <h1>投稿一覧</h1>
  <div class="view_list">
    <table>
      <tr>
        <th>商品名</th>
        <th>ブランド</th>
        <th>カテゴリー</th>
        <th>投稿内容</th>
        <th>登録日</th>
        <th class="<?PHP echo $class; ?>">削除</th>
      </tr>
      <?php foreach ($stmt1 as $row) : ?>
        <tr>
          <td><a href="goods.php?id=<?php echo $row['商品id']; ?>"><?php echo $row['商品名']; ?></a></td>
          <td><a href="brand_list.php?id=<?php echo $row['ブランドid']; ?>"><?php echo $row['ブランド']; ?></a></td>
          <td><a href="category_list.php?id=<?php echo $row['カテゴリーid']; ?>"><?php echo $row['カテゴリー']; ?></a></td>
          <td><?php echo $row['投稿内容']; ?></td>
          <td><?php echo $row['登録日']; ?></td>
          <td class="<?PHP echo $class; ?>"><a href="post_delete.php?id=<?php echo $row['id']; ?>" class="delete">削除</a></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <hr>
  <h1>お気に入り一覧</h1>
  <table>
    <tr>
      <th>商品名</th>
    </tr>
    <?php foreach ($stmt2 as $row) : ?>
      <tr>
        <td><a href="goods.php?id=<?php echo $row['ID']; ?>"><?php echo $row['商品名']; ?></a></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php include("footer.php"); ?>
</body>

</html>