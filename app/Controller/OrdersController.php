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

    /**
     * Easy access throughout controller
     */
    private $dealData;

/**
 * beforeFilter method
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();

        $this->dealData = $this->setViewDealCheckoutData();
        $this->layout = 'stripped';

        if ($this->getTimeLeft($this->dealData) == false) {
            $this->Session->setFlash('Deal is no longer available');
            $this->redirect('/deals/view');
        }

        $this->Auth->allow('login', 'sign_up');
    }

/**
 * login method
 *
 * @return void
 */
    public function login() {
        if ($this->Auth->loggedIn()) {
            $this->redirect('/checkout/review');
        }

        $this->set('title_for_layout', 'Make a deal, sell lots of Tea');

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect('/checkout/review');
            } else {
                $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
            }
        }
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function sign_up() {
        if ($this->Auth->loggedIn()) {
            return $this->redirect($this->Auth->redirect());
        }

        $this->layout = 'stripped';
        if ($this->RequestHandler->isPost()) {
            $this->request->data['User']['user_type'] = 'customer';
            if ($return = $this->Order->User->saveAll($this->request->data)) {
                $email = new CakeEmail('gmail');
                // $email->template('sign_up')
                $email->from(array('team@drinkchai.com' => 'DrinkChai.com'))
                ->to($this->data['User']['email'])
                ->subject('Welcome to DrinkChai')
                ->send();
                $this->Auth->login();

                $this->redirect('/checkout/review');
            }
        }
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function review() {
        $dealData = $this->dealData;

        $this->set('title_for_layout', 'Select Options - ' . $dealData['Deal']['product_name']);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Session->write('Order.quantity', $this->request->data['Order']['quantity']);

            $this->redirect('/checkout/address');
        } else {
            if ($this->Session->check('Order.quantity')) {
                $this->request->data['Order']['quantity'] = $this->Session->read('Order.quantity');
            } else {
                $this->request->data['Order']['quantity'] = 1;
            }
        }

    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function address() {
        $userID = $this->Auth->user('id');

        if (!$this->Session->check('Order.quantity')) {
            $this->Session->setFlash('Please select a quantity');
            $this->redirect('/checkout/review');
        }

        // TODO optimize into 1 query (look for count of 2?)
        if ($this->Order->hasBillingAddress($userID) && $this->Order->hasShippingAddress($userID)) {
            $this->redirect('/checkout/payment');
        }

        $states = ClassRegistry::init('State')->find('list', array('fields' => array('State.stateabbr', 'State.statename')));
        $this->set('states', $states);

        $dealData = $this->dealData;
        $this->set('title_for_layout', 'Address Information - ' . $dealData['Deal']['product_name']);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['ShippingAddress']['user_id'] = $userID;
            $this->request->data['BillingAddress']['user_id']  = $userID;

            if ($this->request->data['ShippingAddress']['same_as_billing'] == true) {
                $this->request->data['ShippingAddress'] = $this->request->data['BillingAddress'];
            }

            if ($this->Order->saveAll($this->request->data, array('validate' => 'only'))) {
                // TODO should these be ifStatements?
                $this->Order->ShippingAddress->save($this->request->data, array('validate' => false));
                $this->Order->BillingAddress->save($this->request->data, array('validate' => false));
                $this->redirect('/checkout/payment');
            }
        } else {
            // TODO this is never used...
            $billingAddress = $this->Order->BillingAddress->findMostRecentBillingAddress($userID);
            $shippingAddress = $this->Order->ShippingAddress->findMostRecentShippingAddress($userID);
            if ($billingAddress && $shippingAddress) {
                $this->request->data['ShippingAddress'] = $shippingAddress['ShippingAddress'];
                $this->request->data['BillingAddress']  = $billingAddress['BillingAddress'];
            } else {
                $this->request->data['ShippingAddress']['firstname']       = $this->Auth->user('firstname');
                $this->request->data['ShippingAddress']['lastname']        = $this->Auth->user('lastname');
                $this->request->data['ShippingAddress']['same_as_billing'] = true;

                $this->request->data['BillingAddress']['firstname']        = $this->Auth->user('firstname');
                $this->request->data['BillingAddress']['lastname']         = $this->Auth->user('lastname');
            }
        }
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function shipping_edit($value='') {
        $userID = $this->Auth->user('id');
        $shippingAddress = $this->Order->ShippingAddress->findMostRecentShippingAddress($userID);

        $states = ClassRegistry::init('State')->find('list', array('fields' => array('State.stateabbr', 'State.statename')));
        $this->set('states', $states);

        $dealData = $this->dealData;
        $this->set('title_for_layout', 'Enter Your Payment Details - ' . $dealData['Deal']['product_name']);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['ShippingAddress']['user_id'] = $userID;
            if (false == $this->Order->ShippingAddress->findDuplicateShippingAddress($this->request->data, $userID)) {
                unset($this->request->data['ShippingAddress']['id']);
                if ($this->Order->ShippingAddress->save($this->request->data)) {
                    $this->redirect('/checkout/confirm');
                }
            }
        } else {
            $this->request->data['ShippingAddress'] = $shippingAddress['ShippingAddress'];
        }
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function payment() {
        $userID = $this->Auth->user('id');

        if ($this->Order->Billing->hasAny(array('Billing.user_id' => $userID)) && $this->Session->check('Order.quantity')) {
            $this->redirect('/checkout/confirm');
        }
        $dealData = $this->dealData;
        $this->set('title_for_layout', 'Enter Your Payment Details - ' . $dealData['Deal']['product_name']);

        $billingAddress = $this->Order->BillingAddress->findMostRecentBillingAddress($userID);

        if ($this->request->is('post') || $this->request->is('put')) {
            try {
                $token = $this->request->data['stripe_token'];
                $customer = $this->Stripe->createCustomer($token);
            } catch (Exception $e) {
                $this->set('card_error', $e->json_body['error']['message']);
                return false;
            }
            $this->setBillingRequestData($customer);
            $this->request->data['Billing']['address_id'] = $billingAddress['BillingAddress']['id'];
            if ($this->Order->Billing->save($this->request->data)) {
                $this->redirect('/checkout/confirm');
            }
        } else {

            $this->request->data['BillingAddress'] = $billingAddress['BillingAddress'];
        }
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function payment_edit() {
        $userID = $this->Auth->user('id');
        $billingAddress = $this->Order->BillingAddress->findMostRecentBillingAddress($userID);

        $states = ClassRegistry::init('State')->find('list', array('fields' => array('State.stateabbr', 'State.statename')));
        $this->set('states', $states);

        $dealData = $this->dealData;
        $this->set('title_for_layout', 'Enter Your Payment Details - ' . $dealData['Deal']['product_name']);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['BillingAddress']['user_id'] = $userID;

            if (false == $this->Order->BillingAddress->findDuplicateBillingAddress($this->request->data, $userID)) {
                unset($this->request->data['BillingAddress']['id']);
            } else {
                $this->request->data['Billing']['address_id'] = $this->request->data['BillingAddress']['id'];
            }

            // create a Customer
            if (isset($this->request->data['stripe_token'])) {
                if ($billingData = $this->Order->Billing->findMostRecentBillingData($userID)) {
                    try {
                        $token = $this->request->data['stripe_token'];
                        $customer = $this->Stripe->updateCustomer($billingData['Billing']['stripe_customer_id'], $token);
                    } catch (Exception $e) {
                      $this->set('card_error', $e->json_body['error']['message']);
                      return false;
                    }
                    $this->setBillingRequestData($customer);

                    // TODO NEED TO PICK REQUEST OR FOUND BIZ ADDY.
                    // debug($this->request->data); exit;
                    if ($ret = $this->Order->Billing->saveAll($this->request->data)) {
                        $this->redirect('/checkout/confirm');
                    } else {

                    }
                }
            }
        } else {
            $this->request->data['BillingAddress'] = $billingAddress['BillingAddress'];
        }

    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    private function setBillingRequestData($customer) {
        $userID = $this->Auth->user('id');
        $this->request->data['Billing']['card_type'] = $customer->active_card->type;
        $this->request->data['Billing']['user_id'] = $userID;
        $this->request->data['Billing']['stripe_customer_id'] = $customer->id;
        $this->request->data['Billing']['card_number_last_four'] = $customer->active_card->last4;
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function confirm() {
        // set your secret key: remember to change this to your live secret key in production
        $userID = $this->Auth->user('id');
        $dealData = $this->dealData;
        $this->set('title_for_layout', 'Address Information - ' . $dealData['Deal']['product_name']);
        $this->set('quantity', $this->Session->read('Order.quantity'));

        $billingData = $this->Order->Billing->findMostRecentBillingData($userID);
        $this->set('billingFirstname', $billingData['BillingAddress']['firstname']);
        $this->set('billingLastname', $billingData['BillingAddress']['lastname']);
        $this->set('cardType', $billingData['Billing']['card_type']);
        $this->set('lastFour', $billingData['Billing']['card_number_last_four']);
        $shippingAddress = $this->Order->ShippingAddress->findMostRecentShippingAddress($userID);

        $this->set('shippingAddress', $shippingAddress);

        if ($this->request->is('post') || $this->request->is('put')) {
            $userID     = $this->Auth->user('id');
            $amount     = $this->Session->read('Order.quantity') * $dealData['Deal']['price'] * 100;
            $customerID = $billingData['Billing']['stripe_customer_id'];
            try {
                $charge = $this->Stripe->createCharge($customerID , $amount);
            } catch (Exception $e) {
                // https://stripe.com/docs/api#errors
                // TODO WHAT TO TEST https://stripe.com/docs/testing
                var_dump($e->json_body);
                $this->set('card_error', $e->json_body['error']['message']);
                return false;
            }
            if ($charge->id) {
                $this->Order->set('user_id', $userID);
                $this->Order->set('stripe_charge_id', $charge->id);
                $this->Order->set('business_id', $dealData['Deal']['business_id']);
                $this->Order->set('shipping_address_id', $shippingAddress['ShippingAddress']['id']);
                $this->Order->set('billing_address_id', $billingData['Billing']['address_id']);
                $this->Order->set('billing_id', $billingData['Billing']['id']);
                $this->Order->set('deal_id', $dealData['Deal']['id']);
                $this->Order->set('quantity', $this->Session->read('Order.quantity'));
                if ($this->Order->save()) {
                    $this->redirect('/checkout/success');
                }

            }
        }
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
    private function setViewDealCheckoutData() {

        // TODO set Session, then check and if not found do below.

        $this->Order->Deal->Behaviors->attach('Containable', array('recursive' => false));
        $this->Order->Deal->contain('Image', 'Business.name');
        $dealData = $this->Order->Deal->getLiveDeal();
        unset($dealData['Deal']['limit']);
        // debug($dealData);
        $this->setImages($dealData['Image']);
        $this->setDealData($dealData);
        return $dealData;
    }
}