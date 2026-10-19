<?php
namespace App\Controller;

use ProductData;
use CategoryData;
use TableData;
use UserData;
use SellData;
use OperationData;
use Sell2Data;
use Operation2Data;
use ProductIngredientData;
use Core;
use ViewEngine;

class PosController {
	private $baseFolder;

	public function __construct() {
		$this->baseFolder = Core::getBaseFolder();
	}

	public function index() {
		$products = ProductData::getAllActive();
		$categories = CategoryData::getAllActive();
		$tables = TableData::getAll();
		$meseros = UserData::getAllMeseros();

		$cart = $_SESSION["cart"] ?? [];
		$cartItems = [];
		$total = 0;
		foreach ($cart as $item) {
			$product = ProductData::getById($item['product_id']);
			if ($product) {
				$subtotal = $product->price_out * $item['q'];
				$total += $subtotal;
				$cartItems[] = [
					'product' => $product,
					'q' => $item['q'],
					'subtotal' => $subtotal
				];
			}
		}

		ViewEngine::render('pos/index.html.twig', [
			'products' => $products,
			'categories' => $categories,
			'tables' => $tables,
			'meseros' => $meseros,
			'cartItems' => $cartItems,
			'total' => $total
		]);
	}

	public function add() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$productId = (int)($_POST['product_id'] ?? 0);
			$quantity = (float)($_POST['q'] ?? 1);
			if ($quantity <= 0) $quantity = 1;

			if ($productId > 0) {
				if (!isset($_SESSION["cart"])) {
					$_SESSION["cart"] = [];
				}

				$found = false;
				foreach ($_SESSION["cart"] as &$item) {
					if ($item['product_id'] == $productId) {
						$item['q'] += $quantity;
						$found = true;
						break;
					}
				}
				unset($item);

				if (!$found) {
					$_SESSION["cart"][] = [
						'product_id' => $productId,
						'q' => $quantity
					];
				}
			}

			if ($this->isAjax()) {
				header('Content-Type: application/json');
				echo json_encode(['success' => true]);
				exit;
			}
		}

		header('Location: ' . $this->baseFolder . '/pos');
		exit;
	}

	public function update() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$productId = (int)($_POST['product_id'] ?? 0);
			$quantity = (float)($_POST['q'] ?? 1);

			if (isset($_SESSION["cart"])) {
				$newCart = [];
				foreach ($_SESSION["cart"] as $item) {
					if ($item['product_id'] == $productId) {
						if ($quantity > 0) {
							$item['q'] = $quantity;
							$newCart[] = $item;
						}
					} else {
						$newCart[] = $item;
					}
				}
				$_SESSION["cart"] = $newCart;
			}

			if ($this->isAjax()) {
				header('Content-Type: application/json');
				echo json_encode(['success' => true]);
				exit;
			}
		}

		header('Location: ' . $this->baseFolder . '/pos');
		exit;
	}

	public function remove(array $vars) {
		$productId = (int)($vars['id'] ?? ($_POST['product_id'] ?? 0));

		if (isset($_SESSION["cart"])) {
			$newCart = [];
			foreach ($_SESSION["cart"] as $item) {
				if ($item['product_id'] != $productId) {
					$newCart[] = $item;
				}
			}
			$_SESSION["cart"] = $newCart;
		}

		if ($this->isAjax()) {
			header('Content-Type: application/json');
			echo json_encode(['success' => true]);
			exit;
		}

		header('Location: ' . $this->baseFolder . '/pos');
		exit;
	}

	public function clear() {
		unset($_SESSION["cart"]);
		header('Location: ' . $this->baseFolder . '/pos');
		exit;
	}

	public function checkout() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$cart = $_SESSION["cart"] ?? [];
			if (empty($cart)) {
				$_SESSION['flash_error'] = "El carrito de venta está vacío.";
				header('Location: ' . $this->baseFolder . '/pos');
				exit;
			}

			$tableId = (int)($_POST['mesa'] ?? 0);
			$meseroId = (int)($_POST['mesero_id'] ?? ($_SESSION['user_id'] ?? 1));
			$personas = (int)($_POST['q'] ?? 1);
			if ($personas < 1) $personas = 1;

			if ($tableId <= 0) {
				$_SESSION['flash_error'] = "Debe seleccionar una mesa válida.";
				header('Location: ' . $this->baseFolder . '/pos');
				exit;
			}

			// Validar ingredientes obligatorios si existen recetas
			foreach ($cart as $item) {
				$ingredients = ProductIngredientData::getAllByProductId($item['product_id']);
				foreach ($ingredients as $in) {
					if ($in->is_required) {
						$qNeeded = $in->q * $item['q'];
						$qAvailable = Operation2Data::getQYesF($in->ingredient_id);
						if ($qAvailable < $qNeeded) {
							$ing = $in->getIngredient();
							$p = ProductData::getById($item['product_id']);
							$_SESSION['flash_error'] = "Stock insuficiente de " . ($ing ? $ing->name : 'insumo') . " para preparar " . ($p ? $p->name : 'platillo');
							header('Location: ' . $this->baseFolder . '/pos');
							exit;
						}
					}
				}
			}

			// Verificar si la mesa ya tiene orden activa o crear una nueva
			$table = TableData::getById($tableId);
			$activeOrder = $table ? $table->getActiveOrder() : null;

			if ($activeOrder) {
				$sellId = $activeOrder->id;
			} else {
				$sell = new SellData();
				$sell->item_id = $tableId;
				$sell->mesero_id = $meseroId;
				$sell->q = $personas;
				$sell->add();
				$sellId = $sell->id;
			}

			// Agregar consumos
			foreach ($cart as $item) {
				$op = new OperationData();
				$op->product_id = $item['product_id'];
				$op->sell_id = $sellId;
				$op->q = $item['q'];
				$op->operation_type_id = 2; // salida / consumo
				$op->add();

				// Descontar ingredientes si el producto tiene receta
				$ingredients = ProductIngredientData::getAllByProductId($item['product_id']);
				if (!empty($ingredients)) {
					$s2 = new Sell2Data();
					$s2->user_id = $_SESSION['user_id'] ?? 1;
					$s2->operation_type_id = 2; // salida
					$s2->add();

					foreach ($ingredients as $in) {
						$op2 = new Operation2Data();
						$op2->ingredient_id = $in->ingredient_id;
						$op2->operation_type_id = 2;
						$op2->sell_id = $s2->id;
						$op2->q = $in->q * $item['q'];
						$op2->add();
					}
				}
			}

			unset($_SESSION["cart"]);
			$_SESSION['flash_success'] = "Venta registrada con éxito para la Mesa " . ($table ? $table->name : $tableId) . ".";
			header('Location: ' . $this->baseFolder . '/orders/detail/' . $sellId);
			exit;
		}

		header('Location: ' . $this->baseFolder . '/pos');
		exit;
	}

	private function isAjax(): bool {
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ||
			(isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
	}
}
