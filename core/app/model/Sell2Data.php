<?php
/**
 * Modelo Sell2Data - Representa una compra / reabastecimiento de insumos (tabla `sell2`)
 */
class Sell2Data {
	public static $tablename = "sell2";

	public $id;
	public $user_id;
	public $operation_type_id = 1; // 1 = entrada/compra
	public $created_at;

	public function __construct() {
		$this->user_id = null;
		$this->operation_type_id = 1;
		$this->created_at = date("Y-m-d H:i:s");
	}

	private static function db(): \PDO {
		return Database::getPdo();
	}

	public function add() {
		$stmt = self::db()->prepare(
			"INSERT INTO " . self::$tablename . " (user_id, operation_type_id, created_at) " .
			"VALUES (:user_id, :operation_type_id, NOW())"
		);
		$stmt->execute([
			'user_id' => $this->user_id ?: null,
			'operation_type_id' => (int)($this->operation_type_id ?: 1)
		]);
		$this->id = self::db()->lastInsertId();
		return $this->id;
	}

	public static function delById($id) {
		$stmt = self::db()->prepare("DELETE FROM operation2 WHERE sell_id = :id");
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
		$stmt = self::db()->query("SELECT * FROM " . self::$tablename . " ORDER BY created_at DESC");
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getRecent(int $limit = 10): array {
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " ORDER BY created_at DESC LIMIT :limit");
		$stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public static function getByDateRange($start, $finish): array {
		$stmt = self::db()->prepare("SELECT * FROM " . self::$tablename . " WHERE DATE(created_at) >= :start AND DATE(created_at) <= :finish ORDER BY created_at DESC");
		$stmt->execute(['start' => $start, 'finish' => $finish]);
		return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, self::class);
	}

	public function getUser() {
		return $this->user_id ? UserData::getById($this->user_id) : null;
	}

	public function getOperations(): array {
		return Operation2Data::getBySellId($this->id);
	}

	public function getTotal(): float {
		$ops = $this->getOperations();
		$total = 0.0;
		foreach ($ops as $op) {
			$ing = $op->getIngredient();
			if ($ing) {
				$total += (float)$op->q * (float)$ing->price_in;
			}
		}
		return $total;
	}

	public function getItemsCount(): int {
		return count($this->getOperations());
	}
}
