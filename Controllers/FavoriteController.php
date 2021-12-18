<?php
require_once(ROOT_PATH . '/Models/Favorite.php');

class FavoriteController
{
    private $Favorite; //モデル

    public function __construct()
    {
        //モデルオブジェクトの生成
        $this->Favorite = new Favorite();
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        $this->request['session'] = $_SESSION;
    }

    public function index()
    {
        $favorites = [
            'item_id' => $this->request['get']['item_id'],
            'user_id' => $this->request['session']['user_id'],
        ];
        $favorite = $this->Favorite->findById($favorites);
        if ($favorite != false) {
            $result = 'お気に入り済';
        } else {
            $result = 'お気に入り';
        }
        return $result;
    }

    public function check()
    {
        $favorites = [
            'item_id' => $this->request['post']['item_id'],
            'user_id' => $this->request['post']['user_id'],
        ];
        $favorite = $this->Favorite->findById($favorites);
        if ($favorite != false) {
            $result = 'お気に入り済';
        } else {
            $result = 'お気に入り';
        }
        return $result;
    }

    public function indexUser()
    {
        $user_id = $this->request['get']['user_id'];
        $favorite = $this->Favorite->findByUserId($user_id);
        return $favorite;
    }

    public function insert()
    {
        $favorites = [
            'item_id' => $this->request['post']['item_id'],
            'user_id' => $this->request['post']['user_id'],
        ];
        $this->Favorite->insert($favorites);
    }

    public function deleted()
    {
        $favorites = [
            'item_id' => $this->request['post']['item_id'],
            'user_id' => $this->request['post']['user_id'],
        ];
        $this->Favorite->deleted($favorites);
    }

    public function deletedUserFavoriteItem()
    {
        $favorite_id = $this->request['post']['favorite_id'];
        $this->Favorite->deletedUserFavoriteItem($favorite_id);
    }
}
