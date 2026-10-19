<?php
namespace App\Controller;

use Sell2Data;
use Core;
use ViewEngine;

class PurchaseController {
	private $baseFolder;

	public function __construct() {
		$this->baseFolder = Core::getBaseFolder();
	}

	public function index() {
		$purchases = Sell2Data::getAll();
		$totalSpent = 0.0;
		foreach ($purchases as $p) {
			$totalSpent += $p->getTotal();
		}

		ViewEngine::render('purchases/index.html.twig', [
			'purchases' => $purchases,
			'totalPurchases' => count($purchases),
			'totalSpent' => $totalSpent
		]);
	}

	public function detail(array $vars) {
		$id = (int)($vars['id'] ?? 0);
		$purchase = Sell2Data::getById($id);
		if (!$purchase) {
			header('Location: ' . $this->baseFolder . '/purchases');
			exit;
		}

		$operations = $purchase->getOperations();
		$total = $purchase->getTotal();

		ViewEngine::render('purchases/detail.html.twig', [
			'purchase' => $purchase,
			'operations' => $operations,
			'total' => $total
		]);
	}
}
