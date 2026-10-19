<?php
namespace App\Controller;

use App\Service\TableService;
use Core;
use ViewEngine;

class TableController {
	private $tableService;
	private $baseFolder;

	public function __construct() {
		$this->tableService = new TableService();
		$this->baseFolder = Core::getBaseFolder();
	}

	public function index() {
		$tables = $this->tableService->getAll();
		ViewEngine::render('tables/index.html.twig', [
			'tables' => $tables
		]);
	}

	public function save() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
			if ($id) {
				$this->tableService->update($id, $_POST);
				$_SESSION['flash_success'] = "Mesa actualizada.";
			} else {
				$this->tableService->create($_POST);
				$_SESSION['flash_success'] = "Mesa agregada correctamente.";
			}
		}
		header('Location: ' . $this->baseFolder . '/tables');
		exit;
	}

	public function delete(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$this->tableService->delete($id);
		$_SESSION['flash_success'] = "Mesa eliminada.";
		header('Location: ' . $this->baseFolder . '/tables');
		exit;
	}
}
