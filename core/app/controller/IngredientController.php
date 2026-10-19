<?php
namespace App\Controller;

use IngredientData;
use Core;
use ViewEngine;

class IngredientController {
	private $baseFolder;

	public function __construct() {
		$this->baseFolder = Core::getBaseFolder();
	}

	public function index() {
		$ingredients = IngredientData::getAll();
		ViewEngine::render('ingredients/index.html.twig', [
			'ingredients' => $ingredients
		]);
	}

	public function new() {
		ViewEngine::render('ingredients/new.html.twig');
	}

	public function create() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$ing = new IngredientData();
			$ing->code = trim($_POST['code'] ?? '');
			$ing->name = trim($_POST['name'] ?? '');
			$ing->price_in = (float)($_POST['price_in'] ?? 0);
			$ing->price_out = (float)($_POST['price_out'] ?? 0);
			$ing->unit = trim($_POST['unit'] ?? 'kg');
			$ing->is_active = isset($_POST['is_active']) ? 1 : 0;
			$ing->user_id = (int)($_SESSION['user_id'] ?? 1);

			if (!empty($ing->name)) {
				$ing->add();
				$_SESSION['flash_success'] = "Ingrediente '{$ing->name}' registrado exitosamente.";
			}
		}
		header('Location: ' . $this->baseFolder . '/ingredients');
		exit;
	}

	public function edit(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$ingredient = IngredientData::getById($id);
		if (!$ingredient) {
			header('Location: ' . $this->baseFolder . '/ingredients');
			exit;
		}

		ViewEngine::render('ingredients/edit.html.twig', [
			'ingredient' => $ingredient
		]);
	}

	public function update(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$ingredient = IngredientData::getById($id);
		if ($ingredient && $_SERVER['REQUEST_METHOD'] === 'POST') {
			$ingredient->code = trim($_POST['code'] ?? '');
			$ingredient->name = trim($_POST['name'] ?? '');
			$ingredient->price_in = (float)($_POST['price_in'] ?? 0);
			$ingredient->price_out = (float)($_POST['price_out'] ?? 0);
			$ingredient->unit = trim($_POST['unit'] ?? 'kg');
			$ingredient->is_active = isset($_POST['is_active']) ? 1 : 0;
			$ingredient->update();

			$_SESSION['flash_success'] = "Ingrediente '{$ingredient->name}' actualizado correctamente.";
		}
		header('Location: ' . $this->baseFolder . '/ingredients');
		exit;
	}

	public function delete(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$ingredient = IngredientData::getById($id);
		if ($ingredient) {
			$name = $ingredient->name;
			$ingredient->del();
			$_SESSION['flash_success'] = "Ingrediente '{$name}' eliminado del sistema.";
		}
		header('Location: ' . $this->baseFolder . '/ingredients');
		exit;
	}
}
