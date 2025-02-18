<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], '/', 'Home::index');

use App\Controllers\Pegawai;
use App\Controllers\Ruangan;
use App\Controllers\Peminjaman;
use App\Controllers\User;

$routes->match(['get', 'post'], 'peminjaman', [Peminjaman::class, 'index']);
$routes->match(['get', 'post'], 'peminjaman/create', [Peminjaman::class, 'create']);
$routes->match(['get', 'post'], 'peminjaman/edit', [Peminjaman::class, 'edit']);
$routes->match(['get', 'post'], 'peminjaman/end', [Peminjaman::class, 'end']);
$routes->match(['get', 'post'], 'peminjaman/hapus', [Peminjaman::class, 'hapus']);
$routes->match(['get', 'post'], 'view', [Peminjaman::class, 'viewPeminjamanUser']);
$routes->match(['get', 'post'], 'peminjaman/export', [Peminjaman::class, 'export']);

$routes->match(['get', 'post'], 'login', [User::class, 'login']);
$routes->match(['get', 'post'], 'signup', [User::class, 'signup_notice']);
$routes->match(['get', 'post'], 'logout', [User::class, 'logout']);
$routes->match(['get', 'post'], 'profile', [User::class, 'profile']);
$routes->match(['get', 'post'], 'user', [User::class, 'index']);
$routes->match(['get', 'post'], 'changePassword', [User::class, 'changePassword']);
$routes->match(['get', 'post'], 'edit', [User::class, 'edit']);
$routes->match(['get', 'post'], 'hapus', [User::class, 'hapus']);
$routes->match(['get', 'post'], 'signupadmin', [User::class, 'signupadmin']);

$routes->match(['get', 'post'], 'ruangan', [Ruangan::class, 'index']);
$routes->match(['get', 'post'], 'ruangan/create', [Ruangan::class, 'create']);
$routes->match(['get', 'post'], 'ruangan/edit/(:segment)', [Ruangan::class, 'edit']);
$routes->match(['get', 'post'], 'ruangan/update/(:segment)', [Ruangan::class, 'update']);
$routes->match(['get', 'post'], 'ruangan/delete/(:segment)', [Ruangan::class, 'delete']);

$routes->match(['get', 'post'], 'pegawai', [Pegawai::class, 'index']);
$routes->match(['get', 'post'], 'pegawai/create', [Pegawai::class, 'create']);
$routes->match(['get', 'post'], 'pegawai/edit', [Pegawai::class, 'edit']);
$routes->match(['get', 'post'], 'pegawai/edit/(:segment)', [Pegawai::class, 'edit']);
$routes->match(['get', 'post'], 'pegawai/delete', [Pegawai::class, 'delete']);
$routes->match(['get', 'post'], 'pegawai/delete/(:segment)', [Pegawai::class, 'delete']);

$routes->match(['get', 'post'], 'peminjaman/create/(:segment)', [Peminjaman::class, 'create']);
$routes->match(['get', 'post'], 'peminjaman/edit/(:segment)', [Peminjaman::class, 'edit']);
$routes->match(['get', 'post'], 'peminjaman/end/(:segment)', [Peminjaman::class, 'end']);
$routes->match(['get', 'post'], 'peminjaman/hapus/(:segment)', [Peminjaman::class, 'hapus']);

$routes->match(['get', 'post'], 'login/(:segment)', [User::class, 'login']);
$routes->match(['get', 'post'], 'signup/(:segment)', [User::class, 'signup_notice']);
$routes->match(['get', 'post'], 'logout/(:segment)', [User::class, 'logout']);
$routes->match(['get', 'post'], 'changePassword/(:segment)', [User::class, 'changePassword']);
$routes->match(['get', 'post'], 'edit/(:segment)', [User::class, 'edit']);
$routes->match(['get', 'post'], 'hapus/(:segment)', [User::class, 'hapus']);
$routes->match(['get', 'post'], 'signupadmin/(:segment)', [User::class, 'signupadmin']);

$routes->match(['get', 'post'], 'ruangan/(:segment)', [Ruangan::class, 'view']);
$routes->match(['get', 'post'], 'pegawai/(:segment)', [Pegawai::class, 'view']);

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}