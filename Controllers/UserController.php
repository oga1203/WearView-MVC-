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

    public function check()
    {
        $login_user = [
            'email' => $this->request['post']['email'],
        ];
        $user = $this->User->checkUser($login_user);
        $params = [
            'user' => $user,
        ];
        return $params;
    }

    public function viewUser()
    {
        $view_user = [
            'user_id' => $this->request['get']['user_id'],
        ];
        $user = $this->User->viewUser($view_user);
        $params = [
            'user' => $user,
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

    public function updatePassword()
    {
        $update = [
            'email'    => $this->request['post']['email'],
            'password' => $this->request['post']['password']
        ];
        $this->User->updatePassword($update);
    }
    public function updateUser()
    {
        $update = [
            'user_id'   => $this->request['post']['user_id'],
            'user_name' => $this->request['post']['user_name'],
            'email'     => $this->request['post']['email'],
            'age'       => $this->request['post']['age'],
            'height'    => $this->request['post']['height'],
            'weight'    => $this->request['post']['weight'],
            'sex'       => $this->request['post']['sex']
        ];
        $this->User->updateUser($update);
    }
}
