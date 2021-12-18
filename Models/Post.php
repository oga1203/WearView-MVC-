<?php
require_once(ROOT_PATH . '/Models/Db.php');

class Post extends Db
{
	private $table = 'post';

	public function __construct($dbh = null)
	{
		parent::__construct($dbh);
	}

	/**
	 * テーブルからすべてデータを取得
	 *
	 * @return Array $result 全データ
	 */
	public function findByItemId($item_id = 0): array
	{
		$sql = 'SELECT users.user_id, users.user_name, users.age, users.height, users.weight, users.sex, ' . $this->table . '.review, ' . $this->table . '.post_id FROM ' . $this->table;
		$sql .= ' INNER JOIN users ON users.user_id = ' . $this->table . '.user_id';
		$sql .= ' WHERE ' . $this->table . '.item_id = :item_id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':item_id', $item_id, PDO::PARAM_STR);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * テーブルから指定idに一致するデータを取得
	 *
	 * @param integer $id 商品のID
	 * @return Array $result 指定の商品データ
	 */
	public function findById($user_id = 0): array
	{
		$sql = 'SELECT item.item_id, item.item_name, category.category_name, brand.brand_name, ' . $this->table . '.review, ' . $this->table . '.post_id, users.user_id FROM ' . $this->table;
		$sql .= ' INNER JOIN item ON item.item_id = ' . $this->table . '.item_id';
		$sql .= ' INNER JOIN brand ON brand.brand_id = item.brand_id';
		$sql .= ' INNER JOIN category ON category.category_id = item.category_id';
		$sql .= ' INNER JOIN category_mid ON category_mid.category_mid_id = item.category_mid_id';
		$sql .= ' INNER JOIN users ON users.user_id = ' . $this->table . '.user_id';
		$sql .= ' WHERE ' . $this->table . '.user_id = :user_id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':user_id', $user_id, PDO::PARAM_STR);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	/**
	 * 登録済みか確認
	 *
	 */
	public function check($arr = ['item_id' => "", 'user_id' => ""])
	{
		$sql = 'SELECT * FROM ' . $this->table;
		$sql .= ' WHERE user_id = :user_id';
		$sql .= ' AND item_id = :item_id';
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
	public function insert($arr = ['item_id' => "", 'user_id' => "", 'review' => ""])
	{
		$sql = 'INSERT INTO ' . $this->table;
		$sql .= ' (user_id, item_id, review)';
		$sql .= ' VALUES (:user_id, :item_id, :review)';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
		$sth->bindParam(':item_id', $arr['item_id'], PDO::PARAM_STR);
		$sth->bindParam(':review', $arr['review'], PDO::PARAM_STR);
		$sth->execute();
	}

	/**
	 * レコードの削除
	 *
	 */
	public function deleted($arr = ['post_id' => ""])
	{
		$sql = 'DELETE FROM ' . $this->table . ' WHERE post_id = :post_id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindParam(':post_id', $arr['post_id'], PDO::PARAM_STR);
		$sth->execute();
	}
}
