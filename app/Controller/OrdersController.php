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

    public $api_login_id;
    public $transaction_key;
    public function beforeFilter() {
        // $this->layout
        $this->layout = 'stripped';
        parent::beforeFilter();
        $this->Auth->allow('relay_response');
        // $this->Auth->allow('quicky');
        // $this->Auth->allow('index');
        // define("AUTHORIZENET_API_LOGIN_ID", "7wUVfB38jfJ");
        // define("AUTHORIZENET_TRANSACTION_KEY", "624Ff3sfz77GNMGk");\

        //////four50nine2
        // 3S7Ft9pr $this->api_login_id
        // 8beXX685kxz8Dp6k
        $this->api_login_id = '3S7Ft9pr';
        $this->transaction_key = '8beXX685kxz8Dp6k';
        define("AUTHORIZENET_API_LOGIN_ID", "36BY7bqn");
        define("AUTHORIZENET_TRANSACTION_KEY", "8VuDVU2P3s4f55nU");
        define("AUTHORIZENET_SANDBOX", true);
      
    }

    public function index() {
        $this->Session->write('Order.deal_id', $this->request->data['Deal']['id']);
        if ($this->Auth->loggedIn()) {
            // debug($this->request->data); exit;
            $this->redirect('/checkout/review');
        } else {
            $this->render('/users/signup');
        }
    }

    public function review() {
        $dealId = $this->Session->read('Order.deal_id');
        $this->Order->Deal->Behaviors->attach('Containable', array('recursive' => false));
        $this->Order->Deal->contain('Image', 'Business.name');

        $dealData = $this->Order->Deal->findById($dealId);
        // debug($dealData);
        $this->setImages($dealData['Image']);
        $this->setDealData($dealData);
        $this->set('title_for_layout', 'Select Options - ' . $dealData['Deal']['product_name']);
        // $this->set('data', $dealData);

    }

    public function submit_review() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Session->write('Order.quantity', $this->request->data['Order']['quantity']);
            $this->redirect('/checkout/address');
        } else {
            $this->request->data = $this->User->read(null, $this->User->id);
        }
    }

    public function address() {

    }

    public function submitAddress() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Session->write('Order.quantity', $this->request->data['Order']['quantity']);
            $this->redirect('/checkout/address');
        } else {
            $this->redirect('/checkout/address');
        }
    }

    public function payment() {
        // debug($this->Session->read());
        // $url = "http://dc.vinyljudge.com/orders/relay_response";
        $time = time();
        // $url = true;
        $this->set('postUrl', AuthorizeNetDPM::SANDBOX_URL);
        $AuthNetHiddenFields['x_login'] = $this->api_login_id;
        $AuthNetHiddenFields['x_amount'] = '5.99';
        $AuthNetHiddenFields['x_type'] = 'AUTH_ONLY';
        $AuthNetHiddenFields['x_fp_sequence'] = $time; // TODO INVOICE #
        $AuthNetHiddenFields['x_fp_timestamp'] = $time;
        $AuthNetHiddenFields['x_relay_response'] = "TRUE";
        $AuthNetHiddenFields['x_relay_url'] = 'http://dc.vinyljudge.com/orders/relay_response';

        $x_fp_hash = AuthorizeNetDPM::getFingerprint($this->api_login_id, $this->transaction_key, $AuthNetHiddenFields['x_amount'], $AuthNetHiddenFields['x_fp_sequence'], $time);

        $AuthNetHiddenFields['x_fp_hash'] = $x_fp_hash;

        $this->set('AuthNetHiddenFields', $AuthNetHiddenFields);
    }

    public function relay_response() {
        $this->autoRender = false;
        $redirect_url = "http://dc.vinyljudge.com/orders/confirm";
        $api_login_id = $this->api_login_id;
        $md5_setting = $this->api_login_id; // Your MD5 Setting
        $response = new AuthorizeNetSIM($api_login_id, $md5_setting); 
        // debug($response); exit;
        // debug($response->isAuthorizeNet()); exit;
        if ($response->isAuthorizeNet())
        {
        if ($response->approved)
           {
               // Do your processing here.
               $redirect_url .= '?response_code=1&transaction_id=' .
               $response->transaction_id;
        } else {
        $redirect_url .= '?response_code='.$response->response_code . '&response_reason_text=' . $response->response_reason_text;
        }
        // Send the Javascript back to AuthorizeNet, which will redirect user back to 
           echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
        } else
        {
        echo "Error. Check your MD5 Setting.";
        }
    }

    public function confirm() {
      // set your secret key: remember to change this to your live secret key in production
      // see your keys here https://manage.stripe.com/account
      Stripe::setApiKey("sk_08sMJifZ11GeVCl5SIvz6tuTYQGS9");

      // get the credit card details submitted by the form
      $token = $_POST['stripeToken'];

      // create a Customer
      $customer = Stripe_Customer::create(array(
        "card" => $token,
        "description" => "payinguser@example.com")
      );

      // charge the Customer instead of the card
      // Stripe_Charge::create(array(
      //   "amount" => 1000, # amount in cents, again
      //   "currency" => "usd",
      //   "customer" => $customer->id)
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

    public function quicky() {
        $sale = new AuthorizeNetAIM;
        $sale->amount = "5.99";
        $sale->card_num = '6011000000000012';
        $sale->exp_date = '04/15';
        $response = $sale->authorizeAndCapture();
        if ($response->approved) {
            $transaction_id = $response->transaction_id;
        }

        debug($response);
        $this->autoRender = false;
    }
}
