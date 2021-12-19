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
		try {
			$sql = 'SELECT ' . $this->table . '.item_name,' . $this->table . '.item_id, brand.brand_name, category.category_name, category_mid.category_mid_name FROM ' . $this->table;
			$sql .= ' INNER JOIN brand ON brand.brand_id = ' . $this->table . '.brand_id';
			$sql .= ' INNER JOIN category ON category.category_id = ' . $this->table . '.category_id';
			$sql .= ' INNER JOIN category_mid ON category_mid.category_mid_id = ' . $this->table . '.category_mid_id';
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * テーブルから指定idに一致するデータを取得
	 * 
	 * @param integer $id 商品のID
	 * @return Array $result 指定の商品データ
	 */
	public function findById($item_id = 0): array
	{
		try {
			$sql = 'SELECT ' . $this->table . '.item_name,' . $this->table . '.item_id,' . $this->table . '.item_number,' . $this->table . '.item_explanation, brand.brand_name, category.category_name, category_mid.category_mid_name FROM ' . $this->table;
			$sql .= ' INNER JOIN brand ON brand.brand_id = ' . $this->table . '.brand_id';
			$sql .= ' INNER JOIN category ON category.category_id = ' . $this->table . '.category_id';
			$sql .= ' INNER JOIN category_mid ON category_mid.category_mid_id = ' . $this->table . '.category_mid_id';
			$sql .= ' WHERE item_id = :item_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':item_id', $item_id, PDO::PARAM_INT);
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * テーブルから指定idに一致するデータを取得
	 * 
	 * @param integer $brand_id ブランドのID
	 * @return Array $result 指定の商品データ
	 */
	public function findByBrandId($brand_id = 0): array
	{
		try {
			$sql = 'SELECT ' . $this->table . '.item_name,' . $this->table . '.item_id,' . $this->table . '.item_number,' . $this->table . '.item_explanation, brand.brand_name, category.category_name, category_mid.category_mid_name FROM ' . $this->table;
			$sql .= ' INNER JOIN brand ON brand.brand_id = ' . $this->table . '.brand_id';
			$sql .= ' INNER JOIN category ON category.category_id = ' . $this->table . '.category_id';
			$sql .= ' INNER JOIN category_mid ON category_mid.category_mid_id = ' . $this->table . '.category_mid_id';
			$sql .= ' WHERE brand.brand_id = :brand_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':brand_id', $brand_id, PDO::PARAM_STR);
			$sth->execute();
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * テーブルから指定idに一致するデータを取得
	 * 
	 * @param integer $category_mid_id 中カテゴリーのID
	 * @return Array $result 指定の商品データ
	 */
	public function findByCategoryMidId($category_mid_id = 0): array
	{
		try {
			$sql = 'SELECT ' . $this->table . '.item_name,' . $this->table . '.item_id,' . $this->table . '.item_number,' . $this->table . '.item_explanation, brand.brand_name, category.category_name, category_mid.category_mid_name FROM ' . $this->table;
			$sql .= ' INNER JOIN brand ON brand.brand_id = ' . $this->table . '.brand_id';
			$sql .= ' INNER JOIN category ON category.category_id = ' . $this->table . '.category_id';
			$sql .= ' INNER JOIN category_mid ON category_mid.category_mid_id = ' . $this->table . '.category_mid_id';
			$sql .= ' WHERE category_mid.category_mid_id = :category_mid_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':category_mid_id', $category_mid_id, PDO::PARAM_STR);
			$sth->execute();
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * テーブルへ登録
	 * 
	 */
	public function insert($arr = ['brand_id' => "", 'category_id' => "", 'category_mid_id' => "", 'item_name' => "", 'item_number' => "", 'item_explanation' => ""])
	{
		$this->dbh->beginTransaction();
		try {
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
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * レコードの削除
	 * 
	 */
	public function deleted($arr = ['item_id' => ""])
	{
		$this->dbh->beginTransaction();
		try {
			$sql = 'DELETE FROM ' . $this->table . ' WHERE item_id = :item_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':item_id', $arr['item_id'], PDO::PARAM_STR);
			$sth->execute();
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}
}
