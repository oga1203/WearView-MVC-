<?php
session_start();
require_once(ROOT_PATH . 'Controllers/FavoriteController.php');
$favorites = new FavoriteController();
$fav = $favorites->check();
if ($fav == 'お気に入り') {
    $favorites->insert();
    echo 'お気に入り済';
} else {
    $favorites->deleted();
    echo 'お気に入り';
}
