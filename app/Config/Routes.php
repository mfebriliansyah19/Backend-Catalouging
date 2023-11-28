<?php

use App\Controllers\MaterialController;
// use App\Controllers\IncController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// $routes->get('material/bulkInsert', 'MaterialController::bulkInsertFromExcel');
$routes->get('inc/bulkInsert', 'IncController::bulkInsertFromExcel');
$routes->post('material/bulkInsert', 'MaterialController::bulkInsertFromExcel');


$routes->get('/', 'Home::index');
$routes->get('material', 'MaterialController::index');
$routes->get('inc', 'IncController::index');
$routes->get('attribute', 'attributeController::index');
$routes->get('globalattribute', 'globalattributeController::index');
$routes->get('group', 'groupController::index');
$routes->get('user', 'userController::index');

$routes->post('material', 'MaterialController::create');
$routes->post('inc', 'IncController::create');
$routes->post('attribute', 'attributeController::create');
$routes->post('globalattribute', 'globalattributeController::create');
$routes->post('group', 'GroupController::create');
$routes->post('user', 'userController::create');

$routes->put('material/(:num)', 'MaterialController::update/$1');
$routes->put('inc/(:num)', 'IncController::update/$1');
$routes->put('attribute/(:num)', 'attributeController::update/$1');
$routes->put('globalattribute/(:num)', 'globalattributeController::update/$1');
$routes->put('group/(:num)', 'groupController::update/$1');
$routes->put('user/(:num)', 'userController::update/$1');

$routes->delete('material/(:num)', 'MaterialController::delete/$1');
$routes->delete('inc/(:num)', 'IncController::delete/$1');
$routes->delete('attribute/(:num)', 'attributeController::delete/$1');
$routes->delete('globalattribute/(:num)', 'globalattributeController::delete/$1');
$routes->delete('group/(:num)', 'groupController::delete/$1');
$routes->delete('user/(:num)', 'userController::delete/$1');

$routes->post('api/login', 'AuthController::login');
$routes->get('api/logout', 'AuthController::logout');

$routes->patch('material/updateCat/(:num)', 'MaterialController::updateCat/$1');