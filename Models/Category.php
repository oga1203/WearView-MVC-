<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Category extends Db
{
	private $table = 'category';

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
			$sql = 'SELECT * FROM ' . $this->table;
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
	 * テーブルへ登録
	 * 
	 */
	public function insert($arr = ['category_name' => ""])
	{
		$this->dbh->beginTransaction();
		try {
			$sql = 'INSERT INTO ' . $this->table . '(category_name) VALUES (:category_name)';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':category_name', $arr['category_name'], PDO::PARAM_STR);
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
	public function deleted($arr = ['category_id' => ""])
	{
		$this->dbh->beginTransaction();
		try {
			$sql = 'DELETE FROM ' . $this->table . ' WHERE category_id = :id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $arr['category_id'], PDO::PARAM_STR);
			$sth->execute();
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}
}
