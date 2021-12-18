<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Favorite extends Db
{
	private $table = 'favorite';

	public function __construct($dbh = null)
	{
		parent::__construct($dbh);
	}

	/**
	 * テーブルからすべてデータを取得
	 * 
	 * @return Array $result 全データ
	 */
	public function findAll(): array
	{
		$sql = 'SELECT * FROM ' . $this->table;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * テーブルへ登録
	 * 
	 */
	public function findById($arr = ['user_id' => "", 'item_id' => ""])
	{
		$sql = 'SELECT * FROM ' . $this->table;
		$sql .= ' WHERE user_id = :user_id AND item_id = :item_id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
		$sth->bindParam(':item_id', $arr['item_id'], PDO::PARAM_STR);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		return $result;
	}


	/**
	 * テーブルへ登録
	 * 
	 */
	public function insert($arr = ['user_id' => "", 'item_id' => ""])
	{
		$sql = 'INSERT INTO ' . $this->table . '(user_id, item_id) VALUES (:user_id, :item_id)';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
		$sth->bindParam(':item_id', $arr['item_id'], PDO::PARAM_STR);
		$sth->execute();
	}

	/**
	 * レコードの削除
	 * 
	 */
	public function deleted($arr = ['user_id' => "", 'item_id' => ""])
	{
		$sql = 'DELETE FROM ' . $this->table;
		$sql .= ' WHERE user_id = :user_id AND item_id = :item_id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
		$sth->bindParam(':item_id', $arr['item_id'], PDO::PARAM_STR);
		$sth->execute();
	}
}
