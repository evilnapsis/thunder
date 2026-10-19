<?php
/**
 * Modelo IngredientData - Ingredientes e insumos del inventario
 */
class IngredientData {
	public static $tablename = "ingredient";

	public $id;
	public $code;
	public $name;
	public $price_in = 0.0;
	public $price_out = 0.0;
	public $unit = "kg";
	public $is_active = 1;
	public $user_id = 1;

	public function __construct() {
		$this->code = "";
		$this->name = "";
		$this->price_in = 0.0;
		$this->price_out = 0.0;
		$this->unit = "kg";
		$this->is_active = 1;
		$this->user_id = 1;
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add() {
		$stmt = self::db()->prepare(
			"INSERT INTO " . self::$tablename . " (code, name, price_in, price_out, unit, is_active, user_id) " .
			"VALUES (:code, :name, :price_in, :price_out, :unit, :is_active, :user_id)"
		);
		$stmt->execute([
			'code' => $this->code,
			'name' => $this->name,
			'price_in' => (float)($this->price_in ?: 0),
			'price_out' => (float)($this->price_out ?: 0),
			'unit' => $this->unit ?: 'kg',
			'is_active' => $this->is_active ? 1 : 0,
			'user_id' => (int)($this->user_id ?: 1),
		]);
		$this->id = self::db()->lastInsertId();
		return $this->id;
	}

	public function update() {
		$stmt = self::db()->prepare(
			"UPDATE " . self::$tablename . " SET code = :code, name = :name, price_in = :price_in, price_out = :price_out, unit = :unit, is_active = :is_active WHERE id = :id"
		);
		return $stmt->execute([
			'code' => $this->code,
			'name' => $this->name,
			'price_in' => (float)($this->price_in ?: 0),
			'price_out' => (float)($this->price_out ?: 0),
			'unit' => $this->unit ?: 'kg',
			'is_active' => $this->is_active ? 1 : 0,
			'id' => $this->id,
		]);
	}

	public static function delById($id) {
		$stmt = self::db()->prepare("DELETE FROM operation2 WHERE ingredient_id = :id");
		$stmt->execute(['id' => $id]);

		$stmt = self::db()->prepare("DELETE FROM " . self::$tablename . " WHERE id = :id");
		return $stmt->execute(['id' => $id]);
	}

	public function del() {
		return self::delById($this->id);
	}

	public static function getById($id) {
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE id = :id");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public static function getAll() {
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " ORDER BY name ASC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getActive() {
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " WHERE is_active = 1 ORDER BY name ASC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getLike($q) {
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE is_active = 1 AND (name LIKE :q1 OR code LIKE :q2) ORDER BY name ASC");
		$like = "%$q%";
		$stmt->execute(['q1' => $like, 'q2' => $like]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public function getStock(): float {
		return Operation2Data::getStockByIngredientId($this->id);
	}

	public function getUser() {
		return $this->user_id ? UserData::getById($this->user_id) : null;
	}
}
