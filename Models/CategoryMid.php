<?php
require_once(ROOT_PATH . '/Models/Db.php');

class CategoryMid extends Db
{
	private $table = 'category_mid';

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
		$sql = 'SELECT category.category_name, category_mid.category_mid_name, category_mid.category_mid_id FROM ' . $this->table;
		$sql .= ' INNER JOIN category ON category.category_id = ' . $this->table . '.category_id';
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * テーブルへ登録
	 * 
	 */
	public function insert($arr = ['category_mid_name' => "", 'category_id' => ""])
	{
		$sql = 'INSERT INTO ' . $this->table . '(category_mid_name, category_id) VALUES (:category_mid_name, :category_id)';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':category_mid_name', $arr['category_mid_name'], PDO::PARAM_STR);
		$sth->bindParam(':category_id', $arr['category_id'], PDO::PARAM_STR);
		$sth->execute();
	}

	/**
	 * レコードの削除
	 * 
	 */
	public function deleted($arr = ['category_mid_id' => ""])
	{
		$sql = 'DELETE FROM ' . $this->table . ' WHERE category_mid_id = :id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':id', $arr['category_mid_id'], PDO::PARAM_STR);
		$sth->execute();
	}
}
