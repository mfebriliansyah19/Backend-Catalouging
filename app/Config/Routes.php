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
$routes->get('user', 'userController::index');

$routes->post('inc', 'IncController::create');
$routes->post('attribute', 'attributeController::create');
$routes->post('globalattribute', 'globalattributeController::create');
$routes->post('group', 'GroupController::create');
$routes->post('user', 'userController::create');

$routes->delete('material/(:num)', 'MaterialController::delete/$1');
$routes->delete('inc/(:num)', 'IncController::delete/$1');
$routes->delete('attribute/(:num)', 'attributeController::delete/$1');
$routes->delete('globalattribute/(:num)', 'globalattributeController::delete/$1');
$routes->delete('group/(:num)', 'groupController::delete/$1');
$routes->delete('user/(:num)', 'userController::delete/$1');

$routes->patch('material/updateCat/(:num)', 'MaterialController::updateCat/$1');