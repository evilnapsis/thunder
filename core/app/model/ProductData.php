<?php
/**
 * Modelo ProductData - Platillos y bebidas del menú
 */
class ProductData {
	public static $tablename = "product";

	public $id;
	public $code;
	public $name;
	public $image;
	public $description;
	public $preparation;
	public $price_in = 0.0;
	public $price_out = 0.0;
	public $unit;
	public $presentation;
	public $duration = 10;
	public $use_ingredient = 0;
	public $is_active = 1;
	public $user_id;
	public $category_id;

	public function __construct(){
		$this->code = "";
		$this->name = "";
		$this->image = null;
		$this->description = "";
		$this->preparation = "";
		$this->price_in = 0.0;
		$this->price_out = 0.0;
		$this->unit = "pz";
		$this->presentation = "";
		$this->duration = 10;
		$this->use_ingredient = 0;
		$this->is_active = 1;
		$this->user_id = 1;
		$this->category_id = null;
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare(
			"INSERT INTO " . self::$tablename . " (code, name, image, description, preparation, price_in, price_out, unit, presentation, duration, use_ingredient, is_active, user_id, category_id) " .
			"VALUES (:code, :name, :image, :description, :preparation, :price_in, :price_out, :unit, :presentation, :duration, :use_ingredient, :is_active, :user_id, :category_id)"
		);
		$stmt->execute([
			'code' => $this->code,
			'name' => $this->name,
			'image' => $this->image ?: null,
			'description' => $this->description ?: '',
			'preparation' => $this->preparation ?: '',
			'price_in' => (float)($this->price_in ?: 0),
			'price_out' => (float)($this->price_out ?: 0),
			'unit' => $this->unit ?: 'pz',
			'presentation' => $this->presentation ?: '',
			'duration' => (int)($this->duration ?: 10),
			'use_ingredient' => $this->use_ingredient ? 1 : 0,
			'is_active' => $this->is_active ? 1 : 0,
			'user_id' => $this->user_id ?: 1,
			'category_id' => $this->category_id ?: null
		]);
		$this->id = self::db()->lastInsertId();
	}

	public function update(){
		$stmt = self::db()->prepare(
			"UPDATE " . self::$tablename . " SET code = :code, name = :name, image = :image, description = :description, " .
			"preparation = :preparation, price_in = :price_in, price_out = :price_out, unit = :unit, " .
			"presentation = :presentation, duration = :duration, is_active = :is_active, category_id = :category_id WHERE id = :id"
		);
		$stmt->execute([
			'code' => $this->code,
			'name' => $this->name,
			'image' => $this->image ?: null,
			'description' => $this->description ?: '',
			'preparation' => $this->preparation ?: '',
			'price_in' => (float)($this->price_in ?: 0),
			'price_out' => (float)($this->price_out ?: 0),
			'unit' => $this->unit ?: 'pz',
			'presentation' => $this->presentation ?: '',
			'duration' => (int)($this->duration ?: 10),
			'is_active' => $this->is_active ? 1 : 0,
			'category_id' => $this->category_id ?: null,
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

	public static function getActive(){
		return self::getAllActive();
	}

	public static function getActiveLike($q){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE is_active = 1 AND (name LIKE :q OR code LIKE :q) ORDER BY name ASC");
		$stmt->execute(['q' => "%$q%"]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getLike($q){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE name LIKE :q OR code LIKE :q ORDER BY name ASC");
		$stmt->execute(['q' => "%$q%"]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getActiveByCategoryId($categoryId){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE is_active = 1 AND category_id = :cid ORDER BY name ASC");
		$stmt->execute(['cid' => $categoryId]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public function getCategory(){
		return $this->category_id ? CategoryData::getById($this->category_id) : null;
	}
}
