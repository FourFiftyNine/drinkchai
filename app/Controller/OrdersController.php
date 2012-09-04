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
    public function index($id = null) {
        // $this->Order->recursive = -1;
      // CONTAINERABLE 
        if ($this->Auth->user('user_type') == 'business') {
            $return = $this->Order->findAllByDealIdAndBusinessId($id, $this->Auth->user('id'));
        } else {
            $return = $this->Order->findCustomerOrderList($this->Auth->user('id'));
        }
        
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
            $orderData['Business'] = $dealData['Business'];
            // debug($dealData);
            // if (!$this->DCAuth->businessOwnsDeal($orderData)) {
            //     $this->Session->setFlash('No way jose, not your deal.');
            //     $this->redirect('/account/deals');
            // }
            // debug($dealData);
            // $billingData = $this->Order->Billing->findMostRecentBillingData($userID);
            $this->request->data['Order']['id'] = $id;
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

            if ($this->request->is('post') || $this->request->is('put')) {

                if ($ret = $this->Order->save($this->request->data, array('validate' => 'only'))) {
                    $this->request->data['Order']['status_id'] = 45;
                    $this->Order->save($this->request->data, array('validate' => false));
                    $this->Session->setFlash(__('Your deal has been saved'));
                } else {
                    $this->Session->setFlash(__('The deal could not be saved. Please, try again.'));
                }
              
            } else {
                $this->request->data['Order']['tracking_number'] = $orderData['Order']['tracking_number'];
            }

        }
}