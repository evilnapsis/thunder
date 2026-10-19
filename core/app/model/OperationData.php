<?php
/**
 * Modelo OperationData - Renglón de platillo en la comanda de mesa (tabla `operation`)
 */
class OperationData {
	public static $tablename = "operation";

	public $id;
	public $product_id;
	public $q = 1.0;
	public $operation_type_id = 2; // 2=salida/consumo
	public $sell_id;
	public $is_oficial = 0;
	public $created_at;

	public function __construct(){
		$this->product_id = null;
		$this->q = 1.0;
		$this->operation_type_id = 2;
		$this->sell_id = null;
		$this->is_oficial = 0;
		$this->created_at = date("Y-m-d H:i:s");
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare(
			"INSERT INTO " . self::$tablename . " (product_id, q, operation_type_id, sell_id, is_oficial, created_at) " .
			"VALUES (:product_id, :q, :operation_type_id, :sell_id, 0, NOW())"
		);
		$stmt->execute([
			'product_id' => $this->product_id,
			'q' => (float)$this->q,
			'operation_type_id' => $this->operation_type_id ?: 2,
			'sell_id' => $this->sell_id
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

	public static function getById($id){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE id = :id");
		$stmt->execute(['id' => $id]);
		$stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
		return $stmt->fetch() ?: null;
	}

	public function getProduct(){
		return $this->product_id ? ProductData::getById($this->product_id) : null;
	}
}
