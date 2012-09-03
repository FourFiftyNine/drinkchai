<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
    // App::import('Lib', 'routes/SlugRoute');

    // STATIC PagesController
    Router::connect('/', array('controller' => 'users', 'action' => 'launch'));

    // Router::connect('/about-us', array('controller' => 'pages', 'action' => 'display', 'about_us'));

    /****** How It Works ******/
    Router::connect('/how-it-works', 
        array('controller' => 'pages', 'action' => 'display', 'how_it_works'));

    /****** Sign Up / Login ******/
    // Business Sign Up
    Router::connect('/businesses/sign-up', 
        array('controller' => 'users', 'action' => 'businesses_sign_up'));
    Router::connect('/businesses/how-it-works', 
        array('controller' => 'users', 'action' => 'businesses_sign_up'));


    // Users Sign Up
    Router::connect('/users/sign-up', 
        array('controller' => 'users', 'action' => 'sign_up'));
    Router::connect('/signup', 
        array('controller' => 'users', 'action' => 'sign_up'));
    // Users Login Alternative
    Router::connect('/login', 
        array('controller' => 'users', 'action' => 'login'));

    /****** User Accounts ******/   
    Router::connect('/account', 
        array('controller' => 'users', 'action' => 'index'));
    Router::connect('/account/edit', 
        array('controller' => 'users', 'action' => 'edit'));
    Router::connect('/account/edit/shipping', 
        array('controller' => 'users', 'action' => 'edit_shipping'));
    Router::connect('/account/edit/billing', 
        array('controller' => 'users', 'action' => 'edit_billing'));

    Router::connect('/account/deals', 
        array('controller' => 'deals', 'action' => 'index'));
    Router::connect('/deals/delete/:id', 
        array('controller' => 'deals', 'action' => 'delete'), array('pass' => array('id')));
    Router::connect('/account/deals/create', 
        array('controller' => 'deals', 'action' => 'create'));

    Router::connect('/account/deals/edit/:id', 
        array('controller' => 'deals', 'action' => 'edit'), array('pass' => array('id')));

    /****** Admin ******/
    // Router::connect('/admin', 
    //     array('controller' => 'users', 'action' => 'admin_index'));
    // Router::connect('/admin/users', 
    //     array('controller' => 'users', 'action' => 'admin_users'));
    // Router::connect('/admin/deals', 
    //     array('controller' => 'deals', 'action' => 'admin_deals'));
    // Router::connect('/account/deals/edit/:id/images/manage', 
    //     array('controller' => 'images', 'action' => 'manage'));
    // Router::connect('/account/deals/delete/:id', 
    //     array('controller' => 'deals', 'action' => 'delete'), array('pass' => array('id')));
    Router::connect('/account/deals/preview/:id', 
        array('controller' => 'deals', 'action' => 'preview'), array('pass' => array('id')));
    Router::connect('/account/orders', 
        array('controller' => 'orders', 'action' => 'view'));

    // Deals Routes (viewing deals)
    Router::connect('/deals/view', 
        array('controller' => 'deals', 'action' => 'view'));
    Router::connect('/deals/:company/:deal', 
        array('controller' => 'deals', 'action' => 'view'));

    /************************************
    ** Checkout
    ************************************/
    Router::connect('/checkout/login', 
        array('controller' => 'checkout', 'action' => 'login'));
    Router::connect('/checkout/signup', 
        array('controller' => 'checkout', 'action' => 'sign_up'));
    Router::connect('/checkout/review', 
        array('controller' => 'checkout', 'action' => 'review'));
    Router::connect('/checkout/address', 
        array('controller' => 'checkout', 'action' => 'address'));
    Router::connect('/checkout/shipping/edit', 
        array('controller' => 'checkout', 'action' => 'shipping_edit'));
    Router::connect('/checkout/payment', 
        array('controller' => 'checkout', 'action' => 'payment'));
    Router::connect('/checkout/payment/edit', 
        array('controller' => 'checkout', 'action' => 'payment_edit'));
    Router::connect('/checkout/check_response_code', 
        array('controller' => 'checkout', 'action' => 'check_response_code'));
    Router::connect('/checkout/confirm', 
        array('controller' => 'checkout', 'action' => 'confirm'));
    Router::connect('/checkout/success', 
        array('controller' => 'checkout', 'action' => 'success'));
    // Router::connect('/:slug/deals/create', array('controller' => 'deals', 'action' => 'create'), array('routeClass' => 'SlugRoute'));

    // Router::connect('/:slug/deals/edit/:id', array('controller' => 'deals', 'action' => 'edit'), array('routeClass' => 'SlugRoute'));
    // Router::connect('/:slug/deals', array('controller' => 'deals', 'action' => 'index'), array('routeClass' => 'SlugRoute'));

    // Router::connect('/:slug', array('controller' => 'deals', 'action' => 'index'), array('routeClass' => 'SlugRoute'));


/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
  Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
  CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
  require CAKE . 'Config' . DS . 'routes.php';
