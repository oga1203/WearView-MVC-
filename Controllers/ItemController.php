<?php
require_once(ROOT_PATH . '/Models/Item.php');

class ItemController
{
    private $Item; //モデル

    public function __construct()
    {
        //モデルオブジェクトの生成
        $this->Item = new Item();
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
    }

    public function index()
    {
        $item = $this->Item->findAll();
        $params = [
            'item' => $item,
        ];
        return $params;
    }

    // public function insert()
    // {
    //     $brand = [
    //         'brand_name' => $this->request['post']['brand_name']
    //     ];
    //     $this->Brand->insert($brand);
    // }

    public function deleted()
    {
        $item_id = [
            'item_id' => $this->request['post']['item_id']
        ];
        $this->Item->deleted($item_id);
    }
}
