<?php
namespace App\Controller;

use App\Service\OrderService;
use ViewEngine;

class ReportController {
	private $orderService;

	public function __construct() {
		$this->orderService = new OrderService();
	}

	public function index() {
		$start = $_GET['start'] ?? date('Y-m-d');
		$finish = $_GET['finish'] ?? date('Y-m-d');

		if (isset($_GET['export']) && $_GET['export'] === 'csv') {
			$this->exportCsv($start, $finish);
			return;
		}

		$orders = $this->orderService->getByDateRange($start, $finish);
		$totalSales = 0.0;
		foreach ($orders as $o) {
			$totalSales += $o->getTotal();
		}

		ViewEngine::render('reports/index.html.twig', [
			'orders' => $orders,
			'start' => $start,
			'finish' => $finish,
			'totalSales' => $totalSales
		]);
	}

	public function exportCsv(?string $startDate = null, ?string $finishDate = null) {
		$start = $startDate ?? ($_GET['start'] ?? date('Y-m-d'));
		$finish = $finishDate ?? ($_GET['finish'] ?? date('Y-m-d'));

		$orders = $this->orderService->getByDateRange($start, $finish);
		$filename = "reporte_ventas_{$start}_al_{$finish}.csv";

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');
		fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

		fputcsv($output, [
			'Folio Comanda',
			'Mesa',
			'Comensales',
			'Fecha y Hora',
			'Mesero',
			'Cajero',
			'Total Venta ($)',
			'Estado'
		]);

		foreach ($orders as $o) {
			$table = $o->getTable();
			$mesero = $o->getMesero();
			$cajero = $o->getCajero();

			fputcsv($output, [
				$o->id,
				$table ? $table->name : 'Mesa #' . $o->item_id,
				$o->q,
				$o->created_at,
				$mesero ? ($mesero->name . ' ' . $mesero->lastname) : '-',
				$cajero ? ($cajero->name . ' ' . $cajero->lastname) : '-',
				number_format($o->getTotal(), 2, '.', ''),
				$o->is_applied ? 'Cobrada / Cerrada' : 'Abierta'
			]);
		}

		fclose($output);
		exit;
	}
}
