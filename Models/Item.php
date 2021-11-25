<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Item extends Db
{
	private $table = 'item';

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
		// $sql = 'SELECT ' . $this->table . '.item_name, brand.brand_name, category.category_name FROM ' . $this->table;
		$sql = 'SELECT ' . $this->table . '.item_name,' . $this->table . '.item_id, brand.brand_name, category.category_name, category_mid.category_mid_name FROM ' . $this->table;
		$sql .= ' INNER JOIN brand ON brand.brand_id = ' . $this->table . '.brand_id';
		$sql .= ' INNER JOIN category ON category.category_id = ' . $this->table . '.category_id';
		$sql .= ' INNER JOIN category_mid ON category_mid.category_mid_id = ' . $this->table . '.category_mid_id';
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * テーブルへ登録
	 * 
	 */
	public function insert($arr = ['brand_id' => "", 'category_id' => "", 'category_mid_id' => "", 'item_name' => "", 'item_number' => "", 'item_explanation' => ""])
	{
		$sql = 'INSERT INTO ' . $this->table;
		$sql .= ' (brand_id, category_id, category_mid_id, item_name, item_number, item_explanation)';
		$sql .= ' VALUES (:brand_id, :category_id, :category_mid_id, :item_name, :item_number, :item_explanation)';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':brand_id', $arr['brand_id'], PDO::PARAM_STR);
		$sth->bindParam(':category_id', $arr['category_id'], PDO::PARAM_STR);
		$sth->bindParam(':category_mid_id', $arr['category_mid_id'], PDO::PARAM_STR);
		$sth->bindParam(':item_name', $arr['item_name'], PDO::PARAM_STR);
		$sth->bindParam(':item_number', $arr['item_number'], PDO::PARAM_STR);
		$sth->bindParam(':item_explanation', $arr['item_explanation'], PDO::PARAM_STR);
		$sth->execute();
	}

	/**
	 * レコードの削除
	 * 
	 */
	public function deleted($arr = ['item_id' => ""])
	{
		$sql = 'DELETE FROM ' . $this->table . ' WHERE brand_id = :id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':id', $arr['item_id'], PDO::PARAM_STR);
		$sth->execute();
	}
}
