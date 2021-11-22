<?php
require_once(ROOT_PATH . '/Models/Category.php');

class CategoryController
{
    private $Category; //モデル

    public function __construct()
    {
        //モデルオブジェクトの生成
        $this->Category = new Category();
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
    }

    public function index()
    {
        $category = $this->Category->findAll();
        $params = [
            'category' => $category,
        ];
        return $params;
    }

    public function insert()
    {
        $category = [
            'category_name' => $this->request['post']['category_name']
        ];
        $this->Category->insert($category);
    }

    public function deleted()
    {
        $category_id = [
            'category_id' => $this->request['post']['category_id']
        ];
        $this->Category->deleted($category_id);
    }
}
