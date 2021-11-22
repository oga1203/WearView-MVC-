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
	 * usersテーブルへ登録
	 * 
	 */
	public function insert($arr = ['email' => "", 'password' => ""]) //: Int
	{
		$sql = 'INSERT INTO ' . $this->table . '(email, password) VALUES (:email, :password)';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
		$sth->bindParam(':password', $arr['password'], PDO::PARAM_STR);
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
}
