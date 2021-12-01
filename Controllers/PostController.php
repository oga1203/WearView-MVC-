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

    public function index()
    {
        $post = $this->Post->findAll();
        $params = [
            'post' => $post,
        ];
        return $params;
    }

    public function view()
    {
        $post = $this->Post->findById($this->request['get']['user_id']);
        $params = [
            'post' => $post
        ];
        return $params;
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
