<?php
namespace App\Service;

use ProductData;
use CategoryData;

class ProductService {
	public function getProducts(): array {
		return ProductData::getAll();
	}

	public function getActiveProducts(): array {
		return ProductData::getAllActive();
	}

	public function getProductById(int $id): ?ProductData {
		return ProductData::getById($id);
	}

	public function createProduct(array $data): ?int {
		$p = new ProductData();
		$p->code = trim($data['code'] ?? '');
		$p->name = trim($data['name'] ?? '');
		$p->image = trim($data['image'] ?? '');
		$p->description = trim($data['description'] ?? '');
		$p->preparation = trim($data['preparation'] ?? '');
		$p->price_in = (float)($data['price_in'] ?? 0);
		$p->price_out = (float)($data['price_out'] ?? 0);
		$p->unit = trim($data['unit'] ?? 'pz');
		$p->presentation = trim($data['presentation'] ?? '');
		$p->duration = !empty($data['duration']) ? (int)$data['duration'] : 10;
		$p->category_id = !empty($data['category_id']) ? (int)$data['category_id'] : null;
		$p->is_active = isset($data['is_active']) ? (int)$data['is_active'] : 1;
		$p->add();
		return $p->id;
	}

	public function updateProduct(int $id, array $data): bool {
		$p = ProductData::getById($id);
		if (!$p) return false;

		$p->code = trim($data['code'] ?? $p->code);
		$p->name = trim($data['name'] ?? $p->name);
		if (isset($data['image'])) {
			$p->image = trim($data['image']);
		}
		$p->description = trim($data['description'] ?? $p->description);
		$p->preparation = trim($data['preparation'] ?? $p->preparation);
		$p->price_in = isset($data['price_in']) ? (float)$data['price_in'] : $p->price_in;
		$p->price_out = isset($data['price_out']) ? (float)$data['price_out'] : $p->price_out;
		$p->unit = trim($data['unit'] ?? $p->unit);
		$p->presentation = trim($data['presentation'] ?? $p->presentation);
		$p->duration = !empty($data['duration']) ? (int)$data['duration'] : $p->duration;
		$p->category_id = !empty($data['category_id']) ? (int)$data['category_id'] : null;
		$p->is_active = isset($data['is_active']) ? (int)$data['is_active'] : $p->is_active;
		$p->update();
		return true;
	}

	public function deleteProduct(int $id): bool {
		$p = ProductData::getById($id);
		if ($p) {
			$p->del();
			return true;
		}
		return false;
	}

	// Categorías
	public function getCategories(): array {
		return CategoryData::getAll();
	}

	public function createCategory(array $data): ?int {
		$cat = new CategoryData();
		$cat->name = trim($data['name'] ?? '');
		$cat->is_active = 1;
		$cat->add();
		return $cat->id;
	}

	public function updateCategory(int $id, array $data): bool {
		$cat = CategoryData::getById($id);
		if (!$cat) return false;
		$cat->name = trim($data['name'] ?? $cat->name);
		$cat->is_active = isset($data['is_active']) ? (int)$data['is_active'] : 1;
		$cat->update();
		return true;
	}

	public function deleteCategory(int $id): bool {
		$cat = CategoryData::getById($id);
		if ($cat) {
			$cat->del();
			return true;
		}
		return false;
	}
}
