<?php
require_once(ROOT_PATH . '/Models/Post.php');

class PostController
{
    private $request; //リクエストパラメータ(GET,POST)
    private $Post; //モデル

    public function __construct()
    {
        //モデルオブジェクトの生成
        $this->Post = new Post();
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
    }

    public function findByItemId()
    {
        $post = $this->Post->findByItemId($this->request['get']['item_id']);
        $params = [
            'post' => $post,
        ];
        return $params;
    }

    public function checkEmpty()
    {
        if (isset($this->request['post']['review'])) {
            $review = $this->request['post']['review'];
            //continue;
        } else {
            return null;
        }
        if (empty($review)) {
            return false;
        } else {
            return true;
        }
    }

    public function checkSameUser()
    {
        if (isset($this->request['post']['user_id'])) {
            $user_id = $this->request['post']['user_id'];
            //continue;
        } else {
            return null;
        }
        $post = [
            'item_id' => $this->request['post']['item_id'],
            'user_id' => $user_id,
        ];
        $check = $this->Post->check($post);
        if ($check === false) {
            return true;
        } else {
            return false;
        }
    }

    public function view()
    {
        $post = $this->Post->findById($this->request['get']['user_id']);
        return $post;
    }
    public function insert()
    {
        $post = [
            'item_id' => $this->request['post']['item_id'],
            'user_id' => $this->request['post']['user_id'],
            'review' => $this->request['post']['review'],
        ];
        $this->Post->insert($post);
    }

    public function deleted()
    {
        $post_id = [
            'post_id' => $this->request['post']['post_id']
        ];
        $this->Post->deleted($post_id);
    }
}
