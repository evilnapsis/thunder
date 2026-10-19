<?php
namespace App\Controller;

use IngredientData;
use Operation2Data;
use Sell2Data;
use Core;
use ViewEngine;

class SupplyController {
	private $baseFolder;

	public function __construct() {
		$this->baseFolder = Core::getBaseFolder();
	}

	public function index() {
		$searchQuery = trim($_GET['q'] ?? '');
		$searchResults = [];
		if (!empty($searchQuery)) {
			$searchResults = IngredientData::getLike($searchQuery);
		} else {
			// Si no hay búsqueda, mostramos los ingredientes activos para facilidad de selección
			$searchResults = IngredientData::getActive();
		}

		$cart = $_SESSION['reabastecer'] ?? [];
		$cartItems = [];
		$total = 0.0;

		foreach ($cart as $key => $item) {
			$ing = IngredientData::getById($item['ingredient_id']);
			if ($ing) {
				$subtotal = (float)$item['q'] * (float)$ing->price_in;
				$total += $subtotal;
				$cartItems[] = [
					'index' => $key,
					'ingredient' => $ing,
					'q' => (float)$item['q'],
					'subtotal' => $subtotal
				];
			}
		}

		ViewEngine::render('supply/index.html.twig', [
			'searchQuery' => $searchQuery,
			'searchResults' => $searchResults,
			'cartItems' => $cartItems,
			'total' => $total,
		]);
	}

	public function addItem() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$ingredientId = (int)($_POST['ingredient_id'] ?? 0);
			$q = (float)($_POST['q'] ?? 1);

			if ($ingredientId > 0 && $q > 0) {
				if (!isset($_SESSION['reabastecer'])) {
					$_SESSION['reabastecer'] = [];
				}

				$found = false;
				foreach ($_SESSION['reabastecer'] as &$item) {
					if ($item['ingredient_id'] === $ingredientId) {
						$item['q'] += $q;
						$found = true;
						break;
					}
				}
				unset($item);

				if (!$found) {
					$_SESSION['reabastecer'][] = [
						'ingredient_id' => $ingredientId,
						'q' => $q
					];
				}

				$_SESSION['flash_success'] = "Insumo agregado a la lista de reabastecimiento.";
			}
		}
		header('Location: ' . $this->baseFolder . '/supply');
		exit;
	}

	public function removeItem(array $vars) {
		$ingredientId = (int)($vars['id'] ?? 0);
		if (isset($_SESSION['reabastecer'])) {
			$_SESSION['reabastecer'] = array_values(array_filter($_SESSION['reabastecer'], function($item) use ($ingredientId) {
				return $item['ingredient_id'] !== $ingredientId;
			}));
			$_SESSION['flash_success'] = "Insumo removido de la lista.";
		}
		header('Location: ' . $this->baseFolder . '/supply');
		exit;
	}

	public function clear() {
		unset($_SESSION['reabastecer']);
		$_SESSION['flash_success'] = "Lista de reabastecimiento vaciada.";
		header('Location: ' . $this->baseFolder . '/supply');
		exit;
	}

	public function process() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$cart = $_SESSION['reabastecer'] ?? [];
			if (empty($cart)) {
				$_SESSION['flash_error'] = "La lista de reabastecimiento está vacía.";
				header('Location: ' . $this->baseFolder . '/supply');
				exit;
			}

			// 1. Crear cabecera de compra en sell2
			$sell2 = new Sell2Data();
			$sell2->user_id = (int)($_SESSION['user_id'] ?? 1);
			$sell2->operation_type_id = 1; // 1 = entrada / compra
			$sell2Id = $sell2->add();

			// 2. Registrar cada insumo en operation2
			foreach ($cart as $item) {
				$op = new Operation2Data();
				$op->ingredient_id = $item['ingredient_id'];
				$op->q = (float)$item['q'];
				$op->operation_type_id = 1; // entrada
				$op->sell_id = $sell2Id;
				$op->is_oficial = 1;
				$op->add();
			}

			// 3. Limpiar carrito
			unset($_SESSION['reabastecer']);

			$_SESSION['flash_success'] = "¡Reabastecimiento procesado exitosamente! Compra registrada con Folio #{$sell2Id}.";
			header('Location: ' . $this->baseFolder . '/purchases/detail/' . $sell2Id);
			exit;
		}
		header('Location: ' . $this->baseFolder . '/supply');
		exit;
	}
}
