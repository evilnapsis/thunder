<?php
namespace App\Service;

use TableData;

class TableService {
	public function getAll(): array {
		return TableData::getAll();
	}

	public function getById(int $id): ?TableData {
		return TableData::getById($id);
	}

	public function create(array $data): ?int {
		$table = new TableData();
		$table->name = trim($data['name'] ?? '');
		$table->capacity = !empty($data['capacity']) ? (int)$data['capacity'] : 4;
		$table->add();
		return $table->id;
	}

	public function update(int $id, array $data): bool {
		$table = TableData::getById($id);
		if (!$table) return false;
		$table->name = trim($data['name'] ?? $table->name);
		$table->capacity = !empty($data['capacity']) ? (int)$data['capacity'] : $table->capacity;
		$table->update();
		return true;
	}

	public function delete(int $id): bool {
		$table = TableData::getById($id);
		if ($table) {
			$table->del();
			return true;
		}
		return false;
	}
}
