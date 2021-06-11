<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->add('employee', 'Employee::view');
$routes->add('employee/(:num)', 'Employee::view/$1');
$routes->add('employee/create', 'Employee::create');
$routes->add('employee/update', 'Employee::update');
$routes->add('employee/update/(:num)', 'Employee::update/$1');
$routes->add('employee/delete', 'Employee::delete');
$routes->add('employee/delete/(:num)', 'Employee::delete/$1/$2');
$routes->add('employee/delete/(:num)/(:num)', 'Employee::delete/$1/$2');

$routes->get('/', 'Home::index');

$routes->add('customer', 'Customer::view');
$routes->add('customer/(:num)', 'Customer::view/$1');
$routes->add('customer/create', 'Customer::create');
$routes->add('customer/update', 'Customer::update');
$routes->add('customer/update/(:num)', 'Customer::update/$1');
$routes->add('customer/delete', 'Customer::delete');
$routes->add('customer/delete/(:num)', 'Custmomer::delete/$1/$2');
$routes->add('customer/delete/(:num)/(:num)', 'Customer::delete/$1/$2');

$routes->get('/', 'Home::index');

$routes->add('orders', 'Orders::view');
$routes->add('orders/(:num)', 'Orders::view/$1');
$routes->add('orders/create', 'Orders::create');
$routes->add('orders/update', 'Orders::update');
$routes->add('orders/update/(:num)', 'Orders::update/$1');
$routes->add('orders/delete', 'Orders::delete');
$routes->add('orders/delete/(:num)', 'Orders::delete/$1/$2');
$routes->add('orders/delete/(:num)/(:num)', 'Orders::delete/$1/$2');

$routes->get('/', 'Home::index');

$routes->add('department', 'Department::view');
$routes->add('department/(:num)', 'Department::view/$1');
$routes->add('department/create', 'Department::create');
$routes->add('department/update', 'Department::update');
$routes->add('department/update/(:num)', 'Department::update/$1');
$routes->add('department/delete', 'Department::delete');
$routes->add('department/delete/(:num)', 'Department::delete/$1/$2');
$routes->add('department/delete/(:num)/(:num)', 'Department::delete/$1/$2');

$routes->get('/', 'Home::index');

$routes->add('address', 'Address::view');
$routes->add('address/(:num)', 'Address::view/$1');
$routes->add('address/create', 'Address::create');
$routes->add('address/update', 'Address::update');
$routes->add('address/update/(:num)', 'Address::update/$1');
$routes->add('address/delete', 'Address::delete');
$routes->add('address/delete/(:num)', 'Address::delete/$1/$2');
$routes->add('address/delete/(:num)/(:num)', 'Address::delete/$1/$2');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
