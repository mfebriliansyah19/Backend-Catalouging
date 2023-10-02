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
$routes->post('inc', 'IncController::create');
$routes->patch('material/updateCat/(:num)', 'MaterialController::updateCat/$1');
$routes->post('group', 'GroupController::create');