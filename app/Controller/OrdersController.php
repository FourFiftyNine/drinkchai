<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'AuthorizeNet/AuthorizeNet');
App::import('Vendor', 'Stripe/lib/Stripe');

/**
 * Orders Controller
 *
 */
class OrdersController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
public $scaffold;

    // public $api_login_id;
    // public $transaction_key;

    public function beforeFilter() {
        // $this->layout
        $this->layout = 'stripped';
        parent::beforeFilter();
    }

    // TODO OBSOLETE
    public function index() {
        // $this->Session->write('Order.deal_id', $this->request->data['Deal']['id']);
        // $this->Session->write('Order.user_id', $this->Auth->user('id'));
        $this->Order->set('deal_id', $this->request->data['Deal']['id']);
        $this->Order->set('user_id', $this->Auth->user('id'));
        // if($this->Order->save()) {
        //   debug('herr');exit;
        // }
        if ($this->Auth->loggedIn()) {
            // debug($this->request->data); exit;
            $this->redirect('/checkout/review');
        } else {
            $this->render('/users/signup');
        }
    }

    public function review() {
      // debug($this->Session->read('Order.quantity'));

      $dealData = $this->setViewDealCheckoutData();
      $this->set('title_for_layout', 'Select Options - ' . $dealData['Deal']['product_name']);
      if ($this->request->is('post') || $this->request->is('put')) {
          $this->Session->write('Order.quantity', $this->request->data['Order']['quantity']);
          $this->redirect('/checkout/address');
      } else {
          // $this->request->data = $this->User->read(null, $this->User->id);
        if ($this->Session->check('Order.quantity')) {
          $this->request->data['Order']['quantity'] = $this->Session->read('Order.quantity');
          // $this->Session->check('Key.id');
         // $this->redirect('/checkout/address');
        }
      }

    }

    public function address() {
      $userID = $this->Auth->user('id');
      if (!$this->Session->check('Order.quantity')) {
        $this->Session->setFlash('Please select a quantity');
        $this->redirect('/checkout/review');
      }
      if ($this->Order->BillingAddress->hasAny(array('BillingAddress.user_id' => $userID)) && $this->Order->ShippingAddress->hasAny(array('ShippingAddress.user_id' => $userID))) {
        $this->redirect('/checkout/payment');
      }

      $states = ClassRegistry::init('State')->find('list', array('fields' => array('State.stateabbr', 'State.statename')));
      $this->set('states', $states);
      $userID = $this->Auth->user('id');

      $dealData = $this->setViewDealCheckoutData();
      $this->set('title_for_layout', 'Address Information - ' . $dealData['Deal']['product_name']);


      if ($this->request->is('post') || $this->request->is('put')) {
        $this->request->data['ShippingAddress']['user_id'] = $this->Auth->user('id');
        $this->request->data['BillingAddress']['user_id'] = $this->Auth->user('id');

        if ($ret = $this->Order->saveAll($this->request->data, array('validate' => 'only'))) {
          $authorized = $this->Order->ShippingAddress->save($this->request->data, array('validate' => false));
          $this->Order->BillingAddress->save($this->request->data, array('validate' => false));
          // debug($authorized); exit;

          // $this->Session->write('ShippingAddress', $this->request->data['ShippingAddress']);
          $this->Session->write('BillingAddress.address_one', $this->request->data['BillingAddress']['address_one']);
          $this->Session->write('BillingAddress.zip', $this->request->data['BillingAddress']['zip']);
          $this->Session->write('BillingAddress.firstname', $this->request->data['BillingAddress']['firstname']);
          $this->Session->write('BillingAddress.lastname', $this->request->data['BillingAddress']['lastname']);
          $this->redirect('/checkout/payment');
        }
      } else {
          // $this->redirect('/checkout/address');
        $billingAddress = $this->Order->BillingAddress->findMostRecentBillingAddress($userID);
        $shippingAddress = $this->Order->ShippingAddress->findMostRecentShippingAddress($userID);
        if($billingAddress && $shippingAddress) {
          $this->request->data['ShippingAddress'] = $shippingAddress['ShippingAddress'];
          $this->request->data['BillingAddress'] = $billingAddress['BillingAddress'];
        } else {
          $this->request->data['ShippingAddress']['firstname'] = $this->Auth->user('firstname');
          $this->request->data['ShippingAddress']['lastname'] = $this->Auth->user('lastname');
          $this->request->data['BillingAddress']['firstname'] = $this->Auth->user('firstname');
          $this->request->data['BillingAddress']['lastname'] = $this->Auth->user('lastname');
        }
      }
    }

    public function payment() {
      $userID = $this->Auth->user('id');

      if ($this->Order->Billing->hasAny(array('Billing.user_id' => $userID)) && $this->Session->check('Order.quantity')) {
        $this->redirect('/checkout/confirm');
      }
      $dealData = $this->setViewDealCheckoutData();
      $this->set('title_for_layout', 'Enter Your Payment Details - ' . $dealData['Deal']['product_name']);


      $billingAddress = $this->Order->BillingAddress->findMostRecentBillingAddress($userID);

      if ($this->request->is('post') || $this->request->is('put')) {
        Stripe::setApiKey("sk_08sMJifZ11GeVCl5SIvz6tuTYQGS9");
        $token = $this->request->data['stripe_token'];
        // create a Customer
        $customer = Stripe_Customer::create(array(
          "card" => $token,
          "description" => '',
          "email" => $this->Auth->user('email'))
        );
        $this->request->data['Billing']['card_type'] = $customer->active_card->type;
        $this->request->data['Billing']['user_id'] = $userID;
        $this->request->data['Billing']['stripe_customer_id'] = $customer->id;
        $this->request->data['Billing']['card_number_last_four'] = $customer->active_card->last4;
        $this->request->data['Billing']['address_id'] = $billingAddress['BillingAddress']['id'];
        if($this->Order->Billing->save($this->request->data)) {

          $this->redirect('/checkout/confirm');
        }
      } else {

        $this->request->data['BillingAddress'] = $billingAddress['BillingAddress'];
      }
    }


    public function confirm() {
      // set your secret key: remember to change this to your live secret key in production
      $userID = $this->Auth->user('id');
      $dealData = $this->setViewDealCheckoutData();
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
        Stripe::setApiKey("sk_08sMJifZ11GeVCl5SIvz6tuTYQGS9");
        $userID = $this->Auth->user('id');
        // create a Customer
      try {
        $stripeCharge = Stripe_Charge::create(array(
            "amount" => 1200, # $15.00 this time
            "currency" => "usd",
            "description" => $dealData['Deal']['id'] . ' - ' . $dealData['Deal']['product_name'],
            "customer" => $billingData['Billing']['stripe_customer_id'])
        );
      } catch (Exception $e) {
        // debug($e);
        // https://stripe.com/docs/api#errors
        // WHAT TO TEST https://stripe.com/docs/testing
        echo $e;
        // debug($e->json_body);
      }

        // var_dump($stripeCharge);
      } else {
        // $this->set();
      }
      // debug(var_dump($customer));

      // charge the Customer instead of the card
      // $return = Stripe_Charge::create(array(
      //   "amount" => 1000, # amount in cents, again
      //   "currency" => "usd",
      //   "customer" => 'cus_0DbXwlAYQwnvpS')
      // );

      // save the customer ID in your database so you can use it later
      // saveStripeCustomerId($user, $customer->id);

      // // later
      // $customerId = getStripeCustomerId($user);

      // Stripe_Charge::create(array(
      //     "amount" => 1500, # $15.00 this time
      //     "currency" => "usd",
      //     "customer" => $customerId)
      // );

    }

    private function setViewDealCheckoutData() {

      // if ($this->Session->read('Order.deal_id')) {
      //   $dealID = $this->Session->read('Order.deal_id');
      // } else if ($this->request->data['Deal']['id']) {
      //   $dealID = $this->request->data['Deal']['id'];
      // } else {}
        // $dealID = 
      // }
      // TODO GET WITHOUT SESSION - hidden
      // $dealId = ($this->Session->read('Order.deal_id') ? $this->Session->read('Order.deal_id') : $this->request->data['Deal']['id'];
      // if ($this->Session->check('Order.deal_id')) {
      //   $dealId = $this->Session->read('Order.deal_id');
      // } else {
      //   $dealID = $this->Order->Deal->getLiveDealID();
      // }
      // // if ($dealId = $this->Session->read('Order.deal_id')

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
