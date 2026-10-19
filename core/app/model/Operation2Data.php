<?php
/**
 * Modelo Operation2Data - Movimientos de inventario para ingredientes (tabla `operation2`)
 */
class Operation2Data {
	public static $tablename = "operation2";

	public $id;
	public $ingredient_id;
	public $q = 0.0;
	public $operation_type_id = 1; // 1 = entrada (abastecimiento/compra), 2 = salida
	public $sell_id = null; // id en tabla sell2
	public $is_oficial = 0;
	public $created_at;

	public function __construct() {
		$this->ingredient_id = null;
		$this->q = 0.0;
		$this->operation_type_id = 1;
		$this->sell_id = null;
		$this->is_oficial = 0;
		$this->created_at = date("Y-m-d H:i:s");
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add() {
		$stmt = self::db()->prepare(
			"INSERT INTO " . self::$tablename . " (ingredient_id, q, operation_type_id, sell_id, is_oficial, created_at) " .
			"VALUES (:ingredient_id, :q, :operation_type_id, :sell_id, :is_oficial, NOW())"
		);
		$stmt->execute([
			'ingredient_id' => $this->ingredient_id,
			'q' => (float)$this->q,
			'operation_type_id' => (int)$this->operation_type_id,
			'sell_id' => $this->sell_id ?: null,
			'is_oficial' => $this->is_oficial ? 1 : 0
		]);
		$this->id = self::db()->lastInsertId();
		return $this->id;
	}

	public static function delById($id) {
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

	public static function getAllByIngredientId($ingredientId) {
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE ingredient_id = :id ORDER BY created_at DESC");
		$stmt->execute(['id' => $ingredientId]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getBySellId($sellId): array {
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE sell_id = :sid ORDER BY id ASC");
		$stmt->execute(['sid' => $sellId]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getStockByIngredientId($ingredientId): float {
		$stmtIn = self::db()->prepare("SELECT COALESCE(SUM(q), 0) as total FROM " . self::$tablename . " WHERE ingredient_id = :id AND operation_type_id = 1");
		$stmtIn->execute(['id' => $ingredientId]);
		$in = (float)($stmtIn->fetchColumn() ?: 0);

		$stmtOut = self::db()->prepare("SELECT COALESCE(SUM(q), 0) as total FROM " . self::$tablename . " WHERE ingredient_id = :id AND operation_type_id = 2");
		$stmtOut->execute(['id' => $ingredientId]);
		$out = (float)($stmtOut->fetchColumn() ?: 0);

		return $in - $out;
	}

	public static function getQYesF($ingredientId): float {
		return self::getStockByIngredientId($ingredientId);
	}

	public function getIngredient() {
		return $this->ingredient_id ? IngredientData::getById($this->ingredient_id) : null;
	}
}
