<?php
/**
 *
 * @package
 */
App::uses('AppController', 'Controller');
// App::import('Vendor', 'AuthorizeNet/AuthorizeNet');


/**
 * Orders Controller
 *
 */
class OrdersController extends AppController {

    public $components = array('Stripe');


    // NORMAL ORDER VIEWS
    public function view() {
        $this->layout = 'default';
    }
}