<?php
require_once(ROOT_PATH . '/Models/Item.php');

class ItemController
{
    private $request; //リクエストパラメータ(GET,POST)
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

    public function view()
    {
        $item = $this->Item->findById($this->request['get']['item_id']);
        $params = [
            'item' => $item
        ];
        return $params;
    }
    public function insert()
    {
        $item = [
            'brand_id' => $this->request['post']['brand_id'],
            'category_id' => $this->request['post']['category_id'],
            'category_mid_id' => $this->request['post']['category_mid_id'],
            'item_name' => $this->request['post']['item_name'],
            'item_number' => $this->request['post']['item_number'],
            'item_explanation' => $this->request['post']['item_explanation']
        ];
        $this->Item->insert($item);
    }

    public function deleted()
    {
        $item_id = [
            'item_id' => $this->request['post']['item_id']
        ];
        $this->Item->deleted($item_id);
    }
}
