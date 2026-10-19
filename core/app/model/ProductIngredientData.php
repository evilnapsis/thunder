<?php
/**
 * Modelo ProductIngredientData - Receta / Relacion producto e ingrediente
 */
class ProductIngredientData {
	public static $tablename = "product_ingredient";

	public $id;
	public $product_id;
	public $ingredient_id;
	public $q = 1.0;
	public $is_required = 1;

	public function __construct(){
		$this->product_id = null;
		$this->ingredient_id = null;
		$this->q = 1.0;
		$this->is_required = 1;
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function getIngredient(){
		return IngredientData::getById($this->ingredient_id);
	}

	public function add(){
		$stmt = self::db()->prepare("INSERT INTO " . self::$tablename . " (product_id, ingredient_id, q, is_required) VALUES (:pid, :iid, :q, :req)");
		$stmt->execute([
			'pid' => $this->product_id,
			'iid' => $this->ingredient_id,
			'q' => (float)$this->q,
			'req' => $this->is_required ? 1 : 0
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

	public static function getAllByProductId($productId){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE product_id = :pid");
		$stmt->execute(['pid' => $productId]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getAll(){
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " ORDER BY id ASC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}
}
