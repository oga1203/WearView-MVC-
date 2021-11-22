<?php
require_once(ROOT_PATH . '/Models/User.php');
//require_once(ROOT_PATH . '/Models/Goal.php');

class UserController
{
    private $request; //リクエストパラメータ(GET,POST)
    private $User; //モデル

    public function __construct()
    {
        //モデルオブジェクトの生成
        $this->User = new User();
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
    }

    public function insert()
    {
        $new_user = [
            'email'    => $this->request['post']['email'],
            'password' => $this->request['post']['password']
        ];
        $this->User->insert($new_user);
    }
}
