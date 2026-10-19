<?php
namespace App\Controller;

use IngredientData;
use Operation2Data;
use Core;
use ViewEngine;

class InventoryController {
	private $baseFolder;

	public function __construct() {
		$this->baseFolder = Core::getBaseFolder();
	}

	public function index() {
		$ingredients = IngredientData::getAll();
		$totalStockValue = 0.0;
		$lowStockCount = 0;

		$inventoryItems = [];
		foreach ($ingredients as $ing) {
			$stock = $ing->getStock();
			$stockValue = $stock * (float)$ing->price_in;
			$totalStockValue += $stockValue;

			if ($stock <= 5) {
				$lowStockCount++;
			}

			$inventoryItems[] = [
				'ingredient' => $ing,
				'stock' => $stock,
				'stock_value' => $stockValue
			];
		}

		ViewEngine::render('inventory/index.html.twig', [
			'items' => $inventoryItems,
			'totalStockValue' => $totalStockValue,
			'lowStockCount' => $lowStockCount,
			'totalIngredients' => count($ingredients)
		]);
	}

	public function history(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$ingredient = IngredientData::getById($id);
		if (!$ingredient) {
			header('Location: ' . $this->baseFolder . '/inventory');
			exit;
		}

		$operations = Operation2Data::getAllByIngredientId($id);
		$currentStock = $ingredient->getStock();

		ViewEngine::render('inventory/history.html.twig', [
			'ingredient' => $ingredient,
			'operations' => $operations,
			'currentStock' => $currentStock
		]);
	}
}
