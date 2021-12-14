<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Brand extends Db
{
	private $table = 'brand';

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
	public function checkBrand($arr = ['brand_name' => ""])
	{
		$sql = 'SELECT * FROM ' . $this->table;
		$sql .= ' WHERE brand_name = :brand_name';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':brand_name', $arr['brand_name'], PDO::PARAM_STR);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * テーブルへ登録
	 * 
	 */
	public function insert($arr = ['brand_name' => ""])
	{
		$sql = 'INSERT INTO ' . $this->table . '(brand_name) VALUES (:brand_name)';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':brand_name', $arr['brand_name'], PDO::PARAM_STR);
		$sth->execute();
	}

	/**
	 * レコードの削除
	 * 
	 */
	public function deleted($arr = ['brand_id' => ""])
	{
		$sql = 'DELETE FROM ' . $this->table . ' WHERE brand_id = :id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':id', $arr['brand_id'], PDO::PARAM_STR);
		$sth->execute();
	}
}
