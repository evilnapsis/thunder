<?php
/**
 * Modelo SellData - Representa la comanda / cuenta de una mesa (tabla `sell`)
 */
class SellData {
	public static $tablename = "sell";

	public $id;
	public $item_id; // id de la mesa
	public $q = 1; // cantidad de comensales
	public $is_applied = 0; // 0=abierta, 1=cerrada/cobrada
	public $mesero_id;
	public $cajero_id;
	public $created_at;

	public function __construct(){
		$this->item_id = null;
		$this->q = 1;
		$this->is_applied = 0;
		$this->mesero_id = null;
		$this->cajero_id = null;
		$this->created_at = date("Y-m-d H:i:s");
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add(){
		$stmt = self::db()->prepare(
			"INSERT INTO " . self::$tablename . " (item_id, q, is_applied, mesero_id, created_at) " .
			"VALUES (:item_id, :q, 0, :mesero_id, NOW())"
		);
		$stmt->execute([
			'item_id' => $this->item_id,
			'q' => (int)($this->q ?: 1),
			'mesero_id' => $this->mesero_id ?: null
		]);
		$this->id = self::db()->lastInsertId();
	}

	public function apply(int $cajeroId){
		$stmt = self::db()->prepare("UPDATE " . self::$tablename . " SET is_applied = 1, cajero_id = :cid WHERE id = :id");
		$stmt->execute([
			'cid' => $cajeroId,
			'id' => $this->id
		]);
		$this->is_applied = 1;
		$this->cajero_id = $cajeroId;
	}

	public static function delById($id){
		$stmt = self::db()->prepare("DELETE FROM operation WHERE sell_id = :id");
		$stmt->execute(['id' => $id]);

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
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " ORDER BY created_at DESC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getActive(){
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " WHERE is_applied = 0 ORDER BY created_at DESC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getClosed(){
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " WHERE is_applied = 1 ORDER BY created_at DESC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getRecentClosed(int $limit = 10): array {
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE is_applied = 1 ORDER BY created_at DESC LIMIT :limit");
		$stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getByDateRange($start, $finish){
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE DATE(created_at) >= :start AND DATE(created_at) <= :finish AND is_applied = 1 ORDER BY created_at DESC");
		$stmt->execute(['start' => $start, 'finish' => $finish]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public function getTable(){
		return $this->item_id ? TableData::getById($this->item_id) : null;
	}

	public function getMesero(){
		return $this->mesero_id ? UserData::getById($this->mesero_id) : null;
	}

	public function getCajero(){
		return $this->cajero_id ? UserData::getById($this->cajero_id) : null;
	}

	public function getOperations(): array {
		$stmt = self::db()->prepare("SELECT * FROM operation WHERE sell_id = :sid ORDER BY id ASC");
		$stmt->execute(['sid' => $this->id]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'OperationData');
	}

	public function getTotal(): float {
		$ops = $this->getOperations();
		$total = 0.0;
		foreach ($ops as $op) {
			$product = $op->getProduct();
			if ($product) {
				$total += (float)$op->q * (float)$product->price_out;
			}
		}
		return $total;
	}
}
