<?php

use App\Controllers\MaterialController;
use App\Controllers\IncController;
use App\Controllers\GroupController;
use App\Controllers\UserController;
use App\Controllers\AttributeController;
use App\Controllers\GlobalAttributeController;
use App\Controllers\UserRoleController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// $routes->get('material/bulkInsert', 'MaterialController::bulkInsertFromExcel');
$routes->post('inc/bulkInsert', 'IncController::bulkInsertFromExcel');
$routes->post('material/bulkInsert', 'MaterialController::bulkInsertFromExcel');
$routes->post('attribute/bulkInsert', 'AttributeController::bulkInsertFromExcel');
$routes->post('group/bulkInsert', 'GroupController::bulkInsertFromExcel');
$routes->post('global/bulkInsert', 'GlobalAttributeController::bulkInsertFromExcel');
$routes->post('user/bulkInsert', 'UserController::bulkInsertFromExcel');

$routes->post('update-inc-by-ids', 'MaterialController::updateINCByIDs');
$routes->post('update-cat-by-ids', 'MaterialController::updatecatByIDs');
$routes->post('update-qc-by-ids', 'MaterialController::updateQcByIDs');
$routes->post('update-status-by-ids', 'MaterialController::updateStatusByIDs');

$routes->get('/', 'Home::index');
$routes->get('material', 'MaterialController::index');
$routes->get('allMaterial', 'MaterialController::getAllData');
// $routes->get('material/search', 'MaterialController::search'); 
$routes->post('search', 'MaterialController::search');
$routes->get('inc', 'IncController::index');
$routes->get('attribute', 'AttributeController::index');
$routes->get('globalattribute', 'GlobalAttributeController::index');
$routes->get('group', 'GroupController::index');
$routes->get('user', 'UserController::index');
$routes->get('userCat', 'UserController::getCataloguer');
$routes->get('userByRole/(:num)', 'UserController::getUserByRole/$1');
$routes->get('userRole', 'UserRoleController::index');


$routes->post('material', 'MaterialController::create');
$routes->post('inc', 'IncController::create');
$routes->post('attribute', 'AttributeController::create');
$routes->post('globalattribute', 'GlobalAttributeController::create');
$routes->post('group', 'GroupController::create');
$routes->post('user', 'UserController::create');

$routes->put('material/(:num)', 'MaterialController::update/$1');
$routes->put('inc/(:num)', 'IncController::update/$1');
$routes->put('attribute/(:num)', 'AttributeController::update/$1');
$routes->put('globalattribute/(:num)', 'GlobalAttributeController::update/$1');
$routes->put('group/(:num)', 'GroupController::update/$1');
$routes->put('user/(:num)', 'UserController::update/$1');

$routes->delete('material/(:num)', 'MaterialController::delete/$1');
$routes->delete('inc/(:num)', 'IncController::delete/$1');
$routes->delete('attribute/(:num)', 'AttributeController::delete/$1');
$routes->delete('globalattribute/(:num)', 'GlobalAttributeController::delete/$1');
$routes->delete('group/(:num)', 'GroupController::delete/$1');
$routes->delete('user/(:num)', 'UserController::delete/$1');

$routes->post('api/login', 'AuthController::login');
$routes->get('api/logout', 'AuthController::logout');

$routes->patch('material/updateCat/(:num)', 'MaterialController::updateCat/$1');