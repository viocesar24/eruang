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
$routes->get('/', 'Home::index');

use App\Controllers\Pegawai;
use App\Controllers\Ruangan;
use App\Controllers\Peminjaman;
use App\Controllers\Pages;
use App\Controllers\User;

$routes->get('login', 'User::login');
$routes->get('signup', 'User::signup');
$routes->get('logout', 'User::logout');
$routes->get('profile', 'User::profile');
$routes->post('login', 'User::login');
$routes->post('signup', 'User::signup');
$routes->post('logout', 'User::logout');
$routes->post('profile', 'User::profile');

$routes->post('peminjaman/create/(:segment)', [Peminjaman::class, 'create']);
$routes->post('peminjaman/create', [Peminjaman::class, 'create']);
$routes->get('peminjaman/create/(:segment)', [Peminjaman::class, 'create']);
$routes->get('peminjaman/create', [Peminjaman::class, 'create']);
$routes->post('peminjaman/edit/(:segment)', [Peminjaman::class, 'edit']);
$routes->post('peminjaman/edit', [Peminjaman::class, 'edit']);
$routes->get('peminjaman/edit/(:segment)', [Peminjaman::class, 'edit']);
$routes->get('peminjaman/edit', [Peminjaman::class, 'edit']);
$routes->post('peminjaman/hapus/(:segment)', [Peminjaman::class, 'hapus']);
$routes->post('peminjaman/hapus', [Peminjaman::class, 'hapus']);
$routes->get('peminjaman/hapus/(:segment)', [Peminjaman::class, 'hapus']);
$routes->get('peminjaman/hapus', [Peminjaman::class, 'hapus']);

$routes->match(['get', 'post'], 'pegawai/create', [Pegawai::class, 'create']);
$routes->match(['get', 'post'], 'ruangan/create', [Ruangan::class, 'create']);
$routes->match(['get', 'post'], 'peminjaman/create', [Peminjaman::class, 'create']);
$routes->match(['get', 'post'], 'user/login', [User::class, 'login']);
$routes->match(['get', 'post'], 'user/signup', [User::class, 'signup']);
$routes->match(['get', 'post'], 'user/logout', [User::class, 'logout']);
$routes->match(['get', 'post'], 'user/profile', [User::class, 'profile']);
$routes->get('pegawai/(:segment)', [Pegawai::class, 'view']);
$routes->get('pegawai', [Pegawai::class, 'index']);
$routes->get('ruangan/(:segment)', [Ruangan::class, 'view']);
$routes->get('ruangan', [Ruangan::class, 'index']);
$routes->get('peminjaman/(:segment)', [Peminjaman::class, 'view']);
$routes->get('peminjaman', [Peminjaman::class, 'index']);
$routes->get('view/(:segment)', [Peminjaman::class, 'viewPeminjamanUser']);
$routes->get('view', [Peminjaman::class, 'viewPeminjamanUser']);
$routes->get('pages/(:segment)', [Pages::class, 'view']);
$routes->get('pages', [Pages::class, 'view']);
$routes->get('user/(:segment)', [User::class, 'view']);
$routes->get('user', [User::class, 'index']);
$routes->get('profile/(:segment)', [User::class, 'profile']);
$routes->get('profile', [User::class, 'profile']);
$routes->get('view/(:segment)', [User::class, 'view']);
$routes->get('view', [User::class, 'index']);

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