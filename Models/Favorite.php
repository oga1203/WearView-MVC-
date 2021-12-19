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
	 * 商品ページにユーザーが登録しているかのチェック
	 * 
	 */
	public function findById($arr = ['user_id' => "", 'item_id' => ""])
	{
		try {
			$sql = 'SELECT * FROM ' . $this->table;
			$sql .= ' WHERE user_id = :user_id AND item_id = :item_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
			$sth->bindParam(':item_id', $arr['item_id'], PDO::PARAM_STR);
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * マイページに表示
	 * 
	 */
	public function findByUserId($user_id)
	{
		try {
			$sql = 'SELECT item.item_name, item.item_id, ' . $this->table . '.favorite_id FROM ' . $this->table;
			$sql .= ' INNER JOIN item ON item.item_id = ' . $this->table . '.item_id';
			$sql .= ' WHERE user_id = :user_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':user_id', $user_id, PDO::PARAM_STR);
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
	public function insert($arr = ['user_id' => "", 'item_id' => ""])
	{
		$this->dbh->beginTransaction();
		try {
			$sql = 'INSERT INTO ' . $this->table . '(user_id, item_id) VALUES (:user_id, :item_id)';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
			$sth->bindParam(':item_id', $arr['item_id'], PDO::PARAM_STR);
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
	public function deleted($arr = ['user_id' => "", 'item_id' => ""])
	{
		$this->dbh->beginTransaction();
		try {
			$sql = 'DELETE FROM ' . $this->table;
			$sql .= ' WHERE user_id = :user_id AND item_id = :item_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
			$sth->bindParam(':item_id', $arr['item_id'], PDO::PARAM_STR);
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
	public function deletedUserFavoriteItem($favorite_id)
	{
		$this->dbh->beginTransaction();
		try {
			$sql = 'DELETE FROM ' . $this->table;
			$sql .= ' WHERE favorite_id = :favorite_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':favorite_id', $favorite_id, PDO::PARAM_STR);
			$sth->execute();
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}
}
