<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'AuthorizeNet/AuthorizeNet');

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

    public function beforeFilter() {
        // $this->layout
        $this->layout = 'stripped';
        parent::beforeFilter();
        // $this->Auth->allow('quicky');
        // $this->Auth->allow('index');
        // define("AUTHORIZENET_API_LOGIN_ID", "7wUVfB38jfJ");
        // define("AUTHORIZENET_TRANSACTION_KEY", "624Ff3sfz77GNMGk");\

        //////four50nine2
        // 3S7Ft9pr 
        // 8beXX685kxz8Dp6k
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

    public function payment() {
        // debug($this->Session->read());
        $url = "http://dc.vinyljudge.com/checkout/confirm";
        // $url = true;
        $api_login_id = '3S7Ft9pr';
        $transaction_key = '8beXX685kxz8Dp6k';
        $md5_setting = '3S7Ft9pr'; // Your MD5 Setting
        // x+veX3taxqErvWRS+2NgW0
        $amount = "5.99";
        AuthorizeNetDPM::directPostDemo($url, $api_login_id, $transaction_key, $amount, $md5_setting);
        debug($this->request->data); exit;

    }

    public function confirm() {
        $this->autoRender = false;
        debug($_POST);
        debug('confirm'); exit;
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
