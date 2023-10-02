<?php

use App\Controllers\MaterialController;
// use App\Controllers\IncController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('material', 'MaterialController::index');
$routes->get('inc', 'IncController::index');
$routes->get('attribute', 'attributeController::index');
$routes->get('group', 'groupController::index');
$routes->get('globalattribute', 'globalattributeController::index');
$routes->post('inc', 'IncController::create');
$routes->post('attribute', 'attributeController::create');
$routes->post('globalattribute', 'globalattributeController::create');
$routes->post('group', 'GroupController::create');
$routes->patch('material/updateCat/(:num)', 'MaterialController::updateCat/$1');