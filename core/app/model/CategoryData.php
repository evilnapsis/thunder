<?php
/**
 * Modelo CategoryData - Categorías del menú de alimentos
 */
class CategoryData {
	public static $tablename = "category";

	public $id;
	public $name;
	public $is_active = 1;

	public function __construct(){
		$this->name = "";
		$this->is_active = 1;
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare("INSERT INTO " . self::$tablename . " (name, is_active) VALUES (:name, :is_active)");
		$stmt->execute([
			'name' => $this->name,
			'is_active' => $this->is_active ? 1 : 0
		]);
		$this->id = self::db()->lastInsertId();
	}

	public function update(){
		$stmt = self::db()->prepare("UPDATE " . self::$tablename . " SET name = :name, is_active = :is_active WHERE id = :id");
		$stmt->execute([
			'name' => $this->name,
			'is_active' => $this->is_active ? 1 : 0,
			'id' => $this->id
		]);
	}

	public static function delById($id){
		$stmt = self::db()->prepare("DELETE FROM " . self::$tablename . " WHERE id = :id");
		$stmt->execute(['id' => $id]);
	}

	public function del(){
		self::delById($this->id);
	}

	public static function getById($id){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE id = :id");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public static function getAll(){
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " ORDER BY name ASC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAllActive(){
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " WHERE is_active = 1 ORDER BY name ASC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}
}
