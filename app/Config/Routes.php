<?php

use App\Controllers\MaterialController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('material', 'MaterialController::index');
$routes->patch('material/updateCat/(:num)', 'MaterialController::updateCat/$1');
$routes->post('group', 'GroupController::create');