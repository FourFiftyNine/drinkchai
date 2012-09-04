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
    public $helpers = array('time');

    // NORMAL ORDER VIEWS
    public function index() {
        // $this->Order->recursive = -1;
      // CONTAINERABLE 
        $return = $this->Order->findOrderList($this->Auth->user('id'));
        // debug($return);
        $this->set('orders', $return);
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
        public function view($id = null) {
            $this->Order->id = $id;
            // $this->Order->recursive = 2;
            // debug(variable);
            $orderData = $this->Order->read();
            // debug($orderData);
            $dealData = $this->Order->Deal->findById($orderData['Deal']['id']);
            // debug($dealData);
            // if (!$this->DCAuth->businessOwnsDeal($orderData)) {
            //     $this->Session->setFlash('No way jose, not your deal.');
            //     $this->redirect('/account/deals');
            // }
            // debug($dealData);
            // $billingData = $this->Order->Billing->findMostRecentBillingData($userID);
            $this->set('quantity', $orderData['Order']['quantity']);
            $this->set('billingFirstname', $orderData['BillingAddress']['firstname']);
            $this->set('billingLastname', $orderData['BillingAddress']['lastname']);
            $this->set('cardType', $orderData['Billing']['card_type']);
            $this->set('lastFour', $orderData['Billing']['card_number_last_four']);
            // $shippingAddress = $this->Order->ShippingAddress->findMostRecentShippingAddress($userID);

            $this->set('shippingAddress', $orderData);
            $this->set('billingAddress', $orderData['BillingAddress']);

            $this->setDealData($dealData);
            $this->set('data', $orderData);

            // if ($this->request->is('post') || $this->request->is('put')) {
            //     $this->setBusinessData($dealData);
            //     unset($this->request->data['Image']);
            //     if ($ret = $this->Deal->saveAll($this->request->data)) {
            //         $this->Session->setFlash(__('Your deal has been saved'));
            //     } else {
            //         $this->Session->setFlash(__('The deal could not be saved. Please, try again.'));
            //     }
            //     // TODO Use $ret?
            //     // $this->request->data = $this->Deal->read();

            // } else {
            //     // $this->request->data = $dealData;
            // }
            // $this->setImages($this->request->data['Image']);

        }
}