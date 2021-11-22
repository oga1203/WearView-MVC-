<?php
require_once(ROOT_PATH . '/Models/Brand.php');

class BrandController
{
    private $Brand; //モデル

    public function __construct()
    {
        //モデルオブジェクトの生成
        $this->Brand = new Brand();
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
    }

    public function index()
    {
        $brand = $this->Brand->findAll();
        $params = [
            'brand' => $brand,
        ];
        return $params;
    }

    public function insert()
    {
        $brand = [
            'brand_name' => $this->request['post']['brand_name']
        ];
        $this->Brand->insert($brand);
    }

    public function deleted()
    {
        $brand_id = [
            'brand_id' => $this->request['post']['brand_id']
        ];
        $this->Brand->deleted($brand_id);
    }
}