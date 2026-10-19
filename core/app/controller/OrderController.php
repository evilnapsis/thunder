<?php
namespace App\Controller;

use App\Service\OrderService;
use App\Service\TableService;
use App\Service\ProductService;
use Core;
use ViewEngine;
use UserData;

class OrderController {
	private $orderService;
	private $tableService;
	private $productService;
	private $baseFolder;

	public function __construct() {
		$this->orderService = new OrderService();
		$this->tableService = new TableService();
		$this->productService = new ProductService();
		$this->baseFolder = Core::getBaseFolder();
	}

	public function index() {
		$activeOrders = $this->orderService->getActiveOrders();
		$closedOrders = $this->orderService->getClosedOrders();

		ViewEngine::render('orders/index.html.twig', [
			'activeOrders' => $activeOrders,
			'closedOrders' => $closedOrders
		]);
	}

	public function table(array $vars) {
		$tableId = (int)($vars['id'] ?? 0);
		$table = $this->tableService->getById($tableId);
		if (!$table) {
			header('Location: ' . $this->baseFolder . '/monitor');
			exit;
		}

		$order = $this->orderService->getActiveOrderByTable($tableId);
		$products = $this->productService->getActiveProducts();
		$categories = $this->productService->getCategories();

		ViewEngine::render('orders/table.html.twig', [
			'table' => $table,
			'order' => $order,
			'products' => $products,
			'categories' => $categories
		]);
	}

	public function open() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$tableId = (int)($_POST['table_id'] ?? 0);
			$comensales = (int)($_POST['q'] ?? 1);
			$meseroId = (int)($_SESSION['user_id'] ?? 1);

			$orderId = $this->orderService->openOrder($tableId, $comensales, $meseroId);
			$_SESSION['flash_success'] = "Mesa abierta con éxito.";
			header('Location: ' . $this->baseFolder . '/orders/table/' . $tableId);
			exit;
		}
		header('Location: ' . $this->baseFolder . '/monitor');
		exit;
	}

	public function addItem(array $vars) {
		$orderId = (int)($vars['id'] ?? 0);
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$productId = (int)($_POST['product_id'] ?? 0);
			$quantity = (float)($_POST['quantity'] ?? 1.0);

			if ($productId > 0 && $quantity > 0) {
				$this->orderService->addItem($orderId, $productId, $quantity);
				$_SESSION['flash_success'] = "Platillo agregado a la comanda.";
			}
		}
		$order = $this->orderService->getById($orderId);
		$redirect = $order ? ($this->baseFolder . '/orders/table/' . $order->item_id) : ($this->baseFolder . '/monitor');
		header('Location: ' . $redirect);
		exit;
	}

	public function removeItem(array $vars) {
		$opId = (int)($vars['id'] ?? 0);
		$tableId = (int)($_GET['table_id'] ?? 0);
		$this->orderService->removeItem($opId);
		$_SESSION['flash_success'] = "Platillo removido de la comanda.";
		$redirect = $tableId ? ($this->baseFolder . '/orders/table/' . $tableId) : ($this->baseFolder . '/monitor');
		header('Location: ' . $redirect);
		exit;
	}

	public function checkout(array $vars) {
		$orderId = (int)($vars['id'] ?? 0);
		$cajeroId = (int)($_SESSION['user_id'] ?? 1);
		if ($cajeroId <= 0 || !UserData::getById($cajeroId)) {
			$cajeroId = 1;
		}
		$this->orderService->closeOrder($orderId, $cajeroId);
		$_SESSION['flash_success'] = "Cuenta pagada y mesa liberada con éxito.";
		header('Location: ' . $this->baseFolder . '/monitor');
		exit;
	}

	public function cancel(array $vars) {
		$orderId = (int)($vars['id'] ?? 0);
		$this->orderService->cancelOrder($orderId);
		$_SESSION['flash_success'] = "Comanda cancelada y mesa liberada.";
		header('Location: ' . $this->baseFolder . '/monitor');
		exit;
	}

	public function detail(array $vars) {
		$orderId = (int)($vars['id'] ?? 0);
		$order = $this->orderService->getById($orderId);
		if (!$order) {
			header('Location: ' . $this->baseFolder . '/orders');
			exit;
		}

		ViewEngine::render('orders/detail.html.twig', [
			'order' => $order
		]);
	}
}
