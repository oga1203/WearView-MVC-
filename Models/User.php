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
		try {
			$sql = 'SELECT * FROM ' . $this->table . ' WHERE role = 0';
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
	 * テーブルから指定レコードを取得(ログイン用)
	 * 
	 * @return Array $result ログインユーザーレコード
	 */
	public function checkUser($arr = ['email' => ""])
	{
		try {
			$sql = 'SELECT * FROM ' . $this->table . ' WHERE email = :email';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			return $result;
		} catch (PDOException $e) {
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * テーブルから指定レコードを取得(マイページ用)
	 * 
	 * @return Array $result ログインユーザーレコード
	 */
	public function viewUser($arr = ['user_id' => ""])
	{
		try {
			$sql = 'SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
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
	public function insert($arr = ['email' => "", 'password' => ""]) //: Int
	{
		//ハッシュ化
		$password = password_hash($arr['password'], PASSWORD_DEFAULT);
		$this->dbh->beginTransaction();
		try {
			$sql = 'INSERT INTO ' . $this->table . '(email, password) VALUES (:email, :password)';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
			$sth->bindParam(':password', $password, PDO::PARAM_STR);
			$sth->execute();
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}
	/**
	 * ユーザー情報更新
	 * 
	 */
	public function updateUser(
		$arr = [
			'user_id' => "",
			'user_name' => "",
			'email' => "",
			// 'age' => "",
			'height' => "",
			'weight' => "",
			'sex' => ""
		]
	) {
		$this->dbh->beginTransaction();
		try {
			$sql = 'UPDATE ' . $this->table . ' SET';
			$sql .= ' user_name = :user_name, email = :email, height = :height,weight = :weight, sex = :sex';
			$sql .= ' WHERE user_id = :user_id';
			$sth = $this->dbh->prepare($sql);
			if (!empty($arr['user_id'])) {
				$sth->bindParam(':user_id', $arr['user_id'], PDO::PARAM_STR);
			} else {
				$user_id = null;
				$sth->bindParam(':user_id', $user_id, PDO::PARAM_STR);
			}
			if (!empty($arr['user_name'])) {
				$sth->bindParam(':user_name', $arr['user_name'], PDO::PARAM_STR);
			} else {
				$user_name = null;
				$sth->bindParam(':user_name', $user_name, PDO::PARAM_STR);
			}
			$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
			// $sth->bindParam(':age', $arr['age'], PDO::PARAM_STR);
			if (!empty($arr['height'])) {
				$sth->bindParam(':height', $arr['height'], PDO::PARAM_STR);
			} else {
				$height = null;
				$sth->bindParam(':height', $height, PDO::PARAM_STR);
			}
			if (!empty($arr['weight'])) {
				$sth->bindParam(':weight', $arr['weight'], PDO::PARAM_STR);
			} else {
				$weight = null;
				$sth->bindParam(':weight', $weight, PDO::PARAM_STR);
			}
			$sth->bindParam(':sex', $arr['sex'], PDO::PARAM_STR);
			$sth->execute();
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}


	/**
	 * 管理者権限の削除
	 * 
	 */
	public function deletedManager($arr = ['user_id' => ""])
	{
		$this->dbh->beginTransaction();
		try {
			$sql = 'UPDATE ' . $this->table . ' SET role = 1 WHERE user_id = :id';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':id', $arr['user_id'], PDO::PARAM_STR);
			$sth->execute();
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * 管理者権限の追加
	 * 
	 */
	public function updateManager($arr = ['email' => ""])
	{
		$this->dbh->beginTransaction();
		try {
			$sql = 'UPDATE ' . $this->table . ' SET role = 0 WHERE email = :email';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
			$sth->execute();
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}

	/**
	 * パスワード変更
	 * 
	 */
	public function updatePassword($arr = ['email' => "", 'password' => ""])
	{
		//ハッシュ化
		$password = password_hash($arr['password'], PASSWORD_DEFAULT);
		$this->dbh->beginTransaction();
		try {
			$sql = 'UPDATE ' . $this->table . ' SET password = :password WHERE email = :email';
			$sth = $this->dbh->prepare($sql);
			$sth->bindParam(':email', $arr['email'], PDO::PARAM_STR);
			$sth->bindParam(':password', $password, PDO::PARAM_STR);
			$sth->execute();
			$this->dbh->commit();
		} catch (PDOException $e) {
			$this->dbh->rollBack();
			echo "sqlエラー:" . $e->getMessage();
			exit();
		}
	}
}
