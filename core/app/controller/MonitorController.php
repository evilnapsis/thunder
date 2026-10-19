<?php
namespace App\Controller;

use App\Service\HomeService;
use ViewEngine;

class MonitorController {
	private $homeService;

	public function __construct() {
		$this->homeService = new HomeService();
	}

	public function index() {
		$data = $this->homeService->getMonitorData();
		ViewEngine::render('monitor/index.html.twig', $data);
	}
}
