<?php namespace Config;

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

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//home controller
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');

//post controller
$routes->post('add', 'Post::add');
$routes->get('add', 'Post::add');
$routes->get('delete-post/(:num)', 'Post::delete_post/$1');
$routes->get('camp-post/(:num)', 'Post::camp_post/$1');
$routes->post('like-post', 'Post::like_post');

//user controller
$routes->get('me', 'User::me');
$routes->get('camp-user/(:any)', 'User::camp_user/$1');
$routes->get('login', 'User::login_form');
$routes->post('login', 'User::login');
$routes->get('signup', 'User::signup');
$routes->post('signup', 'User::signup');
$routes->get('logout', 'User::logout');

//comment
$routes->post('add-comment/(:any)', 'Comment::add_comment/$1');

//notifications
$routes->get('notifications', 'Notifications::index');


/**
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