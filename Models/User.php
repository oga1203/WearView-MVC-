<?php
require_once(ROOT_PATH . '/Models/Db.php');

class User extends Db
{
	private $table = 'users';

	public function __construct($dbh = null)
	{
		parent::__construct($dbh);
	}

	/**
	 * テーブルからすべて管理者レコードを取得
	 * 
	 * @return Array $result 管理者レコード
	 */
	public function findManager(): array
	{
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE role = 0';
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * テーブルから指定レコードを取得(ログイン用)
	 * 
	 * @return Array $result ログインユーザーレコード
	 */
	public function checkUser($arr = ['email' => ""])
	{
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE email = :email';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * テーブルから指定レコードを取得(マイページ用)
	 * 
	 * @return Array $result ログインユーザーレコード
	 */
	public function viewUser($arr = ['user_id' => ""])
	{
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * テーブルへ登録
	 * 
	 */
	public function insert($arr = ['email' => "", 'password' => ""]) //: Int
	{
		//ハッシュ化
		$password = password_hash($arr['password'], PASSWORD_DEFAULT);
		$sql = 'INSERT INTO ' . $this->table . '(email, password) VALUES (:email, :password)';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
		$sth->bindParam(':password', $password, PDO::PARAM_STR);
		$sth->execute();
	}
	/**
	 * ユーザー情報更新
	 * 
	 */
	public function updateUser($arr = ['user_id' => "", 'user_name' => "", 'email' => "", 'age' => "", 'height' => "", 'weight' => "", 'sex' => ""])
	{
		$sql = 'UPDATE ' . $this->table . ' SET user_name = :user_name, email = :email, age = :age, height = :height, weight = :weight, sex = :sex WHERE user_id = :user_id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
		$sth->bindParam(':user_name', $arr['user_name'], PDO::PARAM_STR);
		$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
		$sth->bindParam(':age', $arr['age'], PDO::PARAM_STR);
		$sth->bindParam(':height', $arr['height'], PDO::PARAM_STR);
		$sth->bindParam(':weight', $arr['weight'], PDO::PARAM_STR);
		$sth->bindParam(':sex', $arr['sex'], PDO::PARAM_STR);
		$sth->execute();
	}


	/**
	 * 管理者権限の削除
	 * 
	 */
	public function deletedManager($arr = ['user_id' => ""])
	{
		$sql = 'UPDATE ' . $this->table . ' SET role = 1 WHERE user_id = :id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':id', $arr['user_id'], PDO::PARAM_STR);
		$sth->execute();
	}

	/**
	 * 管理者権限の追加
	 * 
	 */
	public function updateManager($arr = ['email' => ""])
	{
		$sql = 'UPDATE ' . $this->table . ' SET role = 0 WHERE email = :email';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
		$sth->execute();
	}

	/**
	 * パスワード変更
	 * 
	 */
	public function updatePassword($arr = ['email' => "", 'password' => ""])
	{
		//ハッシュ化
		$password = password_hash($arr['password'], PASSWORD_DEFAULT);
		$sql = 'UPDATE ' . $this->table . ' SET password = :password WHERE email = :email';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
		$sth->bindParam(':password', $password, PDO::PARAM_STR);
		$sth->execute();
	}
}
