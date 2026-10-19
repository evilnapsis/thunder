<?php
use App\Controller\HomeController;
use App\Controller\MonitorController;
use App\Controller\PosController;
use App\Controller\AuthController;
use App\Controller\ProfileController;
use App\Controller\OrderController;
use App\Controller\ProductController;
use App\Controller\TableController;
use App\Controller\ReportController;
use App\Controller\UserController;
use App\Controller\IngredientController;
use App\Controller\InventoryController;
use App\Controller\SupplyController;
use App\Controller\PurchaseController;

/**
 * Rutas de Thunder.
 */
return function(FastRoute\RouteCollector $r) {
	// Dashboard
	$r->addRoute('GET', '/', [HomeController::class, 'index']);
	$r->addRoute('GET', '/home', [HomeController::class, 'index']);

	// Punto de Venta (POS)
	$r->addRoute('GET', '/pos', [PosController::class, 'index']);
	$r->addRoute('GET', '/sell', [PosController::class, 'index']);
	$r->addRoute('POST', '/pos/cart/add', [PosController::class, 'add']);
	$r->addRoute('POST', '/pos/cart/update', [PosController::class, 'update']);
	$r->addRoute('POST', '/pos/cart/remove', [PosController::class, 'remove']);
	$r->addRoute('GET', '/pos/cart/remove/{id:\d+}', [PosController::class, 'remove']);
	$r->addRoute('GET', '/pos/cart/clear', [PosController::class, 'clear']);
	$r->addRoute('POST', '/pos/checkout', [PosController::class, 'checkout']);

	// Monitor de Mesas (Piso en Tiempo Real)
	$r->addRoute('GET', '/monitor', [MonitorController::class, 'index']);

	// Autenticación
	$r->addRoute('GET', '/login', [AuthController::class, 'showLogin']);
	$r->addRoute('POST', '/login', [AuthController::class, 'processLogin']);
	$r->addRoute('GET', '/logout', [AuthController::class, 'logout']);

	// Perfil de Usuario
	$r->addRoute('GET', '/profile', [ProfileController::class, 'index']);
	$r->addRoute('POST', '/profile/change-password', [ProfileController::class, 'changePassword']);

	// Comandas / Órdenes
	$r->addRoute('GET', '/orders', [OrderController::class, 'index']);
	$r->addRoute('GET', '/orders/table/{id:\d+}', [OrderController::class, 'table']);
	$r->addRoute('GET', '/orders/detail/{id:\d+}', [OrderController::class, 'detail']);
	$r->addRoute('POST', '/orders/open', [OrderController::class, 'open']);
	$r->addRoute('POST', '/orders/{id:\d+}/add-item', [OrderController::class, 'addItem']);
	$r->addRoute('GET', '/orders/remove-item/{id:\d+}', [OrderController::class, 'removeItem']);
	$r->addRoute(['GET', 'POST'], '/orders/{id:\d+}/checkout', [OrderController::class, 'checkout']);
	$r->addRoute(['GET', 'POST'], '/orders/{id:\d+}/cancel', [OrderController::class, 'cancel']);

	// Menú y Platillos
	$r->addRoute('GET', '/products', [ProductController::class, 'index']);
	$r->addRoute('GET', '/products/new', [ProductController::class, 'new']);
	$r->addRoute('POST', '/products/create', [ProductController::class, 'create']);
	$r->addRoute('GET', '/products/edit/{id:\d+}', [ProductController::class, 'edit']);
	$r->addRoute('POST', '/products/update/{id:\d+}', [ProductController::class, 'update']);
	$r->addRoute('GET', '/products/delete/{id:\d+}', [ProductController::class, 'delete']);

	// Categorías del Menú
	$r->addRoute('GET', '/products/categories', [ProductController::class, 'categories']);
	$r->addRoute('POST', '/products/categories/save', [ProductController::class, 'saveCategory']);
	$r->addRoute('GET', '/products/categories/delete/{id:\d+}', [ProductController::class, 'deleteCategory']);

	// Mesas
	$r->addRoute('GET', '/tables', [TableController::class, 'index']);
	$r->addRoute('POST', '/tables/save', [TableController::class, 'save']);
	$r->addRoute('GET', '/tables/delete/{id:\d+}', [TableController::class, 'delete']);

	// Ingredientes e Insumos
	$r->addRoute('GET', '/ingredients', [IngredientController::class, 'index']);
	$r->addRoute('GET', '/ingredients/new', [IngredientController::class, 'new']);
	$r->addRoute('POST', '/ingredients/create', [IngredientController::class, 'create']);
	$r->addRoute('GET', '/ingredients/edit/{id:\d+}', [IngredientController::class, 'edit']);
	$r->addRoute('POST', '/ingredients/update/{id:\d+}', [IngredientController::class, 'update']);
	$r->addRoute('GET', '/ingredients/delete/{id:\d+}', [IngredientController::class, 'delete']);

	// Inventario de Ingredientes
	$r->addRoute('GET', '/inventory', [InventoryController::class, 'index']);
	$r->addRoute('GET', '/inventory/history/{id:\d+}', [InventoryController::class, 'history']);

	// Reabastecimiento / Abastecer
	$r->addRoute('GET', '/supply', [SupplyController::class, 'index']);
	$r->addRoute('POST', '/supply/add', [SupplyController::class, 'addItem']);
	$r->addRoute('GET', '/supply/remove/{id:\d+}', [SupplyController::class, 'removeItem']);
	$r->addRoute('GET', '/supply/clear', [SupplyController::class, 'clear']);
	$r->addRoute('POST', '/supply/process', [SupplyController::class, 'process']);

	// Compras
	$r->addRoute('GET', '/purchases', [PurchaseController::class, 'index']);
	$r->addRoute('GET', '/purchases/detail/{id:\d+}', [PurchaseController::class, 'detail']);

	// Reportes
	$r->addRoute('GET', '/reports', [ReportController::class, 'index']);
	$r->addRoute('GET', '/reports/csv', [ReportController::class, 'exportCsv']);

	// Usuarios
	$r->addRoute('GET', '/users', [UserController::class, 'index']);
	$r->addRoute('GET', '/users/new', [UserController::class, 'new']);
	$r->addRoute('POST', '/users/create', [UserController::class, 'create']);
	$r->addRoute('GET', '/users/edit/{id:\d+}', [UserController::class, 'edit']);
	$r->addRoute('POST', '/users/update/{id:\d+}', [UserController::class, 'update']);
	$r->addRoute('GET', '/users/delete/{id:\d+}', [UserController::class, 'delete']);
};
