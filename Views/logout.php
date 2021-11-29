<?php

session_start();
$_SESSION = array(); //セッションの中身をすべて削除
session_destroy(); //セッションを破壊
$comp_alert = "<script type='text/javascript'>
alert('ログアウトしました！');
location.href = 'login.php';
</script>";
echo $comp_alert;
