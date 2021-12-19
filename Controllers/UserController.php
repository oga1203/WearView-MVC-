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

    //メールアドレスとパスワードのバリデーション
    public function validationUser()
    {
        if (isset($this->request['post']['email'])) {
            $email = $this->request['post']['email'];
        } else {
            return false;
        }
        if (isset($this->request['post']['password'])) {
            $password = $this->request['post']['password'];
        } else {
            return false;
        }
        // メールアドレスのチェック
        if (empty($email)) {
            $error_email = "メールアドレスは必須入力です。<br>正しくご入力ください。";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_email = "メールアドレスは正しくご入力ください。";
        } else {
            $error_email = null;
        }
        // パスワードのチェック
        if (empty($password)) {
            $error_password = "パスワードは必須入力です。<br>正しくご入力ください。";
        } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $password)) {
            $error_password = "パスワードは半角英数字のみでご入力ください。";
        } else {
            $error_password = null;
        }
        // エラー判定
        if (isset($error_email) || isset($error_password)) {
            $errors = ['email' => $error_email, 'password' => $error_password];
            return $errors;
        } else {
            return true;
        }
    }

    public function check()
    {
        $email = [
            'email' => $this->request['post']['email'],
        ];
        $user = $this->User->checkUser($email);
        // メールアドレスが登録判定
        if (empty($user)) {
            return null;
        } else {
            $db_pass = $user['password'];
            $password = $this->request['post']['password'];
            $check_password = $this->validationPassword($password, $db_pass);
            //パスワードの合致判定
            if ($check_password === false) {
                return false;
            } else {
                $params = [
                    'user' => $user,
                ];
                return $params;
            }
        }
    }

    // メールの合致判定
    public function validationPassword($password, $db_pass)
    {
        // パスワードの合致判定
        if (password_verify($password, $db_pass)) {
            return true;
        } else {
            return false;
        }
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

    public function checkUpdateUser()
    {
        $email = $this->request['post']['email'];
        // メールアドレスのチェック
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "メールアドレスは正しくご入力ください。";
        } else {
            $error = null;
        }
        if (empty($error)) {
            return true;
        } else {
            return $error;
        }
    }

    public function updateUser()
    {
        $update = [
            'user_id'   => $this->request['post']['user_id'],
            'user_name' => $this->request['post']['user_name'],
            'email'     => $this->request['post']['email'],
            // 'age'       => $this->request['post']['age'],
            'height'    => $this->request['post']['height'],
            'weight'    => $this->request['post']['weight'],
            'sex'       => $this->request['post']['sex']
        ];
        $this->User->updateUser($update);
    }
}
