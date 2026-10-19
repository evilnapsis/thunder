<?php
namespace App\Service;

use TableData;
use SellData;
use Sell2Data;
use ProductData;
use IngredientData;
use Database;

class HomeService {
	/**
	 * Datos para el Monitor de Mesas en Piso
	 */
	public function getMonitorData(): array {
		$tables = TableData::getAll();
		$occupiedCount = 0;
		$freeCount = 0;
		$activeTotal = 0.0;

		$tablesWithStatus = [];
		foreach ($tables as $t) {
			$order = $t->getActiveOrder();
			$isOccupied = ($order !== null);
			if ($isOccupied) {
				$occupiedCount++;
				$activeTotal += $order->getTotal();
			} else {
				$freeCount++;
			}

			$tablesWithStatus[] = [
				'table' => $t,
				'is_occupied' => $isOccupied,
				'order' => $order
			];
		}

		$closedToday = SellData::getByDateRange(date('Y-m-d'), date('Y-m-d'));
		$salesToday = 0.0;
		foreach ($closedToday as $s) {
			$salesToday += $s->getTotal();
		}

		return [
			'tables' => $tablesWithStatus,
			'totalTables' => count($tables),
			'occupiedCount' => $occupiedCount,
			'freeCount' => $freeCount,
			'activeTotal' => $activeTotal,
			'salesToday' => $salesToday,
			'closedTodayCount' => count($closedToday),
		];
	}

	/**
	 * Datos para el Dashboard Principal
	 */
	public function getDashboardData(): array {
		// 1. Métricas de Mesas en Piso
		$tables = TableData::getAll();
		$occupiedTables = 0;
		$activeFloorTotal = 0.0;
		foreach ($tables as $t) {
			$order = $t->getActiveOrder();
			if ($order !== null) {
				$occupiedTables++;
				$activeFloorTotal += $order->getTotal();
			}
		}
		$totalTables = count($tables);
		$freeTables = max(0, $totalTables - $occupiedTables);

		// 2. Ventas de Hoy
		$today = date('Y-m-d');
		$todaySells = SellData::getByDateRange($today, $today);
		$salesToday = 0.0;
		foreach ($todaySells as $s) {
			$salesToday += $s->getTotal();
		}
		$ordersTodayCount = count($todaySells);

		// 3. Compras del Mes
		$firstDayMonth = date('Y-m-01');
		$monthPurchases = Sell2Data::getByDateRange($firstDayMonth, $today);
		$purchasesMonthTotal = 0.0;
		foreach ($monthPurchases as $p) {
			$purchasesMonthTotal += $p->getTotal();
		}
		$purchasesMonthCount = count($monthPurchases);

		// 4. Productos e Ingredientes
		$products = ProductData::getActive();
		$totalProducts = count($products);

		$ingredients = IngredientData::getActive();
		$totalIngredients = count($ingredients);
		$lowStockCount = 0;
		foreach ($ingredients as $ing) {
			if ($ing->getStock() <= 5) {
				$lowStockCount++;
			}
		}

		// 5. Gráfica de Ventas de los últimos 14 días
		$chartLabels = [];
		$chartAmounts = [];
		$chartOrders = [];

		for ($i = 13; $i >= 0; $i--) {
			$dayDate = date('Y-m-d', strtotime("-$i days"));
			$label = date('d M', strtotime($dayDate));
			$chartLabels[] = $label;

			$daySales = SellData::getByDateRange($dayDate, $dayDate);
			$dayTotal = 0.0;
			foreach ($daySales as $s) {
				$dayTotal += $s->getTotal();
			}
			$chartAmounts[] = round($dayTotal, 2);
			$chartOrders[] = count($daySales);
		}

		// 6. Listado de Ventas Recientes (últimas 8 cerradas)
		$recentSales = SellData::getRecentClosed(8);

		// 7. Listado de Compras Recientes (últimas 8)
		$recentPurchases = Sell2Data::getRecent(8);

		return [
			'salesToday' => $salesToday,
			'ordersTodayCount' => $ordersTodayCount,
			'occupiedTables' => $occupiedTables,
			'freeTables' => $freeTables,
			'totalTables' => $totalTables,
			'activeFloorTotal' => $activeFloorTotal,
			'purchasesMonthTotal' => $purchasesMonthTotal,
			'purchasesMonthCount' => $purchasesMonthCount,
			'totalProducts' => $totalProducts,
			'totalIngredients' => $totalIngredients,
			'lowStockCount' => $lowStockCount,
			'chartLabels' => $chartLabels,
			'chartAmounts' => $chartAmounts,
			'chartOrders' => $chartOrders,
			'recentSales' => $recentSales,
			'recentPurchases' => $recentPurchases,
		];
	}
}
