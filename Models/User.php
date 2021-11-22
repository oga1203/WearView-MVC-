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
}
