<?php
require_once(ROOT_PATH . '/Models/CategoryMid.php');

class CategoryMidController
{
    private $CategoryMid; //モデル

    public function __construct()
    {
        //モデルオブジェクトの生成
        $this->CategoryMid = new CategoryMid();
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
    }

    public function index()
    {
        $category_mid = $this->CategoryMid->findAll();
        $params = [
            'category_mid' => $category_mid,
        ];
        return $params;
    }

    public function findById()
    {

        $category_mid_id = $this->request['get']['category_mid_id'];
        $category_mid_name = $this->CategoryMid->findById($category_mid_id);
        return $category_mid_name;
    }

    public function insert()
    {
        $category_mid = [
            'category_mid_name' => $this->request['post']['category_mid_name'],
            'category_id' => $this->request['post']['category_id']
        ];
        $this->CategoryMid->insert($category_mid);
    }

    public function viewCategoryList()
    {
        $category_mid = $this->CategoryMid->findByCategoryId($this->request['get']['category_id']);
        $params = [
            'category_mid' => $category_mid
        ];
        return $params;
    }

    public function deleted()
    {
        $category_mid_id = [
            'category_mid_id' => $this->request['post']['category_mid_id']
        ];
        $this->CategoryMid->deleted($category_mid_id);
    }
}
