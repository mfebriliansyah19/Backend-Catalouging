<?php

use App\Controllers\MaterialController;
use App\Controllers\IncController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('material', 'MaterialController::index');
$routes->get('inc', 'IncController::index');