<?php
namespace App\Service;

use SellData;
use OperationData;
use TableData;

class OrderService {
	public function getActiveOrders(): array {
		return SellData::getActive();
	}

	public function getClosedOrders(): array {
		return SellData::getClosed();
	}

	public function getById(int $id): ?SellData {
		return SellData::getById($id);
	}

	public function getActiveOrderByTable(int $tableId): ?SellData {
		$table = TableData::getById($tableId);
		return $table ? $table->getActiveOrder() : null;
	}

	public function openOrder(int $tableId, int $comensales, int $meseroId): ?int {
		// Verificar si ya tiene orden activa
		$existing = $this->getActiveOrderByTable($tableId);
		if ($existing) {
			return $existing->id;
		}

		$sell = new SellData();
		$sell->item_id = $tableId;
		$sell->q = $comensales ?: 1;
		$sell->mesero_id = $meseroId;
		$sell->add();
		return $sell->id;
	}

	public function addItem(int $sellId, int $productId, float $quantity = 1.0): ?int {
		$op = new OperationData();
		$op->sell_id = $sellId;
		$op->product_id = $productId;
		$op->q = $quantity ?: 1.0;
		$op->operation_type_id = 2; // consumo
		$op->add();
		return $op->id;
	}

	public function removeItem(int $operationId): bool {
		$op = OperationData::getById($operationId);
		if ($op) {
			$op->del();
			return true;
		}
		return false;
	}

	public function closeOrder(int $sellId, int $cajeroId): bool {
		$sell = SellData::getById($sellId);
		if (!$sell) return false;
		$sell->apply($cajeroId);
		return true;
	}

	public function cancelOrder(int $sellId): bool {
		$sell = SellData::getById($sellId);
		if ($sell) {
			$sell->del();
			return true;
		}
		return false;
	}

	public function getByDateRange(string $start, string $finish): array {
		return SellData::getByDateRange($start, $finish);
	}
}
