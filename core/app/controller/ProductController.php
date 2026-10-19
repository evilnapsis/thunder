<?php
namespace App\Controller;

use App\Service\ProductService;
use Core;
use ViewEngine;

class ProductController {
	private $productService;
	private $baseFolder;

	public function __construct() {
		$this->productService = new ProductService();
		$this->baseFolder = Core::getBaseFolder();
	}

	public function index() {
		$products = $this->productService->getProducts();
		$categories = $this->productService->getCategories();

		ViewEngine::render('products/index.html.twig', [
			'products' => $products,
			'categories' => $categories
		]);
	}

	public function new() {
		$categories = $this->productService->getCategories();
		ViewEngine::render('products/new.html.twig', [
			'categories' => $categories
		]);
	}

	public function create() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->productService->createProduct($_POST);
			if ($id) {
				$_SESSION['flash_success'] = "Platillo agregado al menú.";
			}
		}
		header('Location: ' . $this->baseFolder . '/products');
		exit;
	}

	public function edit(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$product = $this->productService->getProductById($id);
		if (!$product) {
			header('Location: ' . $this->baseFolder . '/products');
			exit;
		}

		$categories = $this->productService->getCategories();
		ViewEngine::render('products/edit.html.twig', [
			'product' => $product,
			'categories' => $categories
		]);
	}

	public function update(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->productService->updateProduct($id, $_POST);
			$_SESSION['flash_success'] = "Platillo actualizado.";
		}
		header('Location: ' . $this->baseFolder . '/products');
		exit;
	}

	public function delete(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$this->productService->deleteProduct($id);
		$_SESSION['flash_success'] = "Platillo eliminado del menú.";
		header('Location: ' . $this->baseFolder . '/products');
		exit;
	}

	// Categorías de Menú
	public function categories() {
		$categories = $this->productService->getCategories();
		ViewEngine::render('products/categories.html.twig', [
			'categories' => $categories
		]);
	}

	public function saveCategory() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
			if ($id) {
				$this->productService->updateCategory($id, $_POST);
				$_SESSION['flash_success'] = "Categoría actualizada.";
			} else {
				$this->productService->createCategory($_POST);
				$_SESSION['flash_success'] = "Categoría creada con éxito.";
			}
		}
		header('Location: ' . $this->baseFolder . '/products/categories');
		exit;
	}

	public function deleteCategory(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$this->productService->deleteCategory($id);
		$_SESSION['flash_success'] = "Categoría eliminada.";
		header('Location: ' . $this->baseFolder . '/products/categories');
		exit;
	}
}
