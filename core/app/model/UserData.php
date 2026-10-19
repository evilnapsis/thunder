<?php
/**
 * Modelo UserData para Thunder.
 */
class UserData {
	public static $tablename = "user";
	public $id;
	public $name;
	public $lastname;
	public $username;
	public $email;
	public $password;
	public $image;
	public $is_active = 1;
	public $is_admin = 0;
	public $is_mesero = 0;
	public $is_cajero = 0;
	public $created_at;

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->username = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->is_active = 1;
		$this->is_admin = 0;
		$this->is_mesero = 0;
		$this->is_cajero = 0;
		$this->created_at = date("Y-m-d H:i:s");
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare(
			"INSERT INTO " . self::$tablename . " (name, lastname, username, email, password, image, is_active, is_admin, is_mesero, is_cajero, created_at) " .
			"VALUES (:name, :lastname, :username, :email, :password, :image, :is_active, :is_admin, :is_mesero, :is_cajero, NOW())"
		);
		$stmt->execute([
			'name' => $this->name,
			'lastname' => $this->lastname,
			'username' => $this->username,
			'email' => $this->email,
			'password' => $this->password,
			'image' => $this->image ?: '',
			'is_active' => $this->is_active ? 1 : 0,
			'is_admin' => $this->is_admin ? 1 : 0,
			'is_mesero' => $this->is_mesero ? 1 : 0,
			'is_cajero' => $this->is_cajero ? 1 : 0,
		]);
		$this->id = self::db()->lastInsertId();
	}

	public static function delById($id){
		$stmt = self::db()->prepare("DELETE FROM " . self::$tablename . " WHERE id = :id");
		$stmt->execute(['id' => $id]);
	}

	public function del(){
		self::delById($this->id);
	}

	public function update(){
		$stmt = self::db()->prepare(
			"UPDATE " . self::$tablename . " SET name = :name, lastname = :lastname, username = :username, " .
			"email = :email, is_active = :is_active, is_admin = :is_admin, is_mesero = :is_mesero, is_cajero = :is_cajero WHERE id = :id"
		);
		$stmt->execute([
			'name' => $this->name,
			'lastname' => $this->lastname,
			'username' => $this->username,
			'email' => $this->email,
			'is_active' => $this->is_active ? 1 : 0,
			'is_admin' => $this->is_admin ? 1 : 0,
			'is_mesero' => $this->is_mesero ? 1 : 0,
			'is_cajero' => $this->is_cajero ? 1 : 0,
			'id' => $this->id,
		]);
	}

	public function update_passwd(){
		$stmt = self::db()->prepare("UPDATE " . self::$tablename . " SET password = :password WHERE id = :id");
		$stmt->execute(['password' => $this->password, 'id' => $this->id]);
	}

	public static function getById($id){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE id = :id");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public static function getByUsername($username){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE username = :u");
		$stmt->execute(['u' => $username]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public static function getAll(){
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " ORDER BY id ASC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllActive(){
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " WHERE is_active = 1 ORDER BY name ASC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllMeseros(){
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " WHERE is_active = 1 AND is_mesero = 1 ORDER BY name ASC");
		$res = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		if (empty($res)) {
			// Fallback si no hay meseros especificos marcados
			$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " WHERE is_active = 1 ORDER BY name ASC");
			$res = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		}
		return $res;
	}

	public static function getLike($q){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE name LIKE :q OR username LIKE :q");
		$stmt->execute(['q' => "%$q%"]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}
}
