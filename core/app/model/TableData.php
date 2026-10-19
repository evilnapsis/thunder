<?php
/**
 * Modelo TableData - Representa las mesas del restaurante (tabla `item`)
 */
class TableData {
	public static $tablename = "item";

	public $id;
	public $name;
	public $capacity = 4;

	public function __construct(){
		$this->name = "";
		$this->capacity = 4;
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare("INSERT INTO " . self::$tablename . " (name, capacity) VALUES (:name, :capacity)");
		$stmt->execute([
			'name' => $this->name,
			'capacity' => (int)($this->capacity ?: 4)
		]);
		$this->id = self::db()->lastInsertId();
	}

	public function update(){
		$stmt = self::db()->prepare("UPDATE " . self::$tablename . " SET name = :name, capacity = :capacity WHERE id = :id");
		$stmt->execute([
			'name' => $this->name,
			'capacity' => (int)($this->capacity ?: 4),
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
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " ORDER BY CAST(name AS UNSIGNED), name ASC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public function getActiveOrder(){
		$stmt = self::db()->prepare("SELECT * FROM sell WHERE item_id = :id AND is_applied = 0 ORDER BY created_at DESC LIMIT 1");
		$stmt->execute(['id' => $this->id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'SellData');
		return $stmt->fetch() ?: null;
	}

	public function isOccupied(): bool {
		return $this->getActiveOrder() !== null;
	}
}

class_alias('TableData', 'ItemData');
