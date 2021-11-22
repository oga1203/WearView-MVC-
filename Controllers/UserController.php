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

    public function indexManager()
    {
        $manager = $this->User->findManager();
        $params = [
            'manager' => $manager,
        ];
        return $params;
    }

    public function insert()
    {
        $new_user = [
            'email'    => $this->request['post']['email'],
            'password' => $this->request['post']['password']
        ];
        $this->User->insert($new_user);
    }

    public function deletedManager()
    {
        $user_id = [
            'user_id' => $this->request['post']['user_id']
        ];
        $this->User->deletedManager($user_id);
    }

    public function updateManager()
    {
        $update = [
            'email' => $this->request['post']['email']
        ];
        $this->User->updateManager($update);
    }
}
