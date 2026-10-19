<?php
namespace App\Controller;

use App\Service\HomeService;
use ViewEngine;

class HomeController {
	private $homeService;

	public function __construct() {
		$this->homeService = new HomeService();
	}

	public function index() {
		$data = $this->homeService->getDashboardData();
		ViewEngine::render('home/index.html.twig', $data);
	}
}
