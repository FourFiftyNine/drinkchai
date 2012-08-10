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
        // $url = "http://dc.vinyljudge.com/orders/relay_response";
        $time = time();
        // $url = true;
        $this->set('postUrl', AuthorizeNetDPM::SANDBOX_URL);
        // $AuthNetHiddenFields['post_url'] = AuthorizeNetDPM::SANDBOX_URL;
        $AuthNetHiddenFields['x_login'] = '3S7Ft9pr';
        // $AuthNetHiddenFields['transaction_key'] = '8beXX685kxz8Dp6k';
        // $AuthNetHiddenFields['md5_setting'] = '3S7Ft9pr';
        $AuthNetHiddenFields['x_amount'] = '5.99'; // TESTING
        $AuthNetHiddenFields['x_type'] = 'AUTH_ONLY'; // TESTING
        $AuthNetHiddenFields['x_fp_sequence'] = $time; // TESTING
        $AuthNetHiddenFields['x_fp_timestamp'] = $time; // TESTING
        $AuthNetHiddenFields['x_relay_response'] = "TRUE"; // TESTING
        $AuthNetHiddenFields['x_relay_url'] = 'http://dc.vinyljudge.com/orders/relay_response'; // TESTING

        $x_fp_hash = AuthorizeNetDPM::getFingerprint($AuthNetHiddenFields['x_login'], '8beXX685kxz8Dp6k', $AuthNetHiddenFields['x_amount'], $AuthNetHiddenFields['x_fp_sequence'], $time);

        $AuthNetHiddenFields['x_fp_hash'] = $x_fp_hash; // TESTING

        $this->set('AuthNetHiddenFields', $AuthNetHiddenFields);
        // debug($AuthNetHiddenFields);


        // AuthorizeNetDPM::directPostDemo($url, $api_login_id, $transaction_key, $amount, $md5_setting);
        // debug($this->request->data); exit;

    }

    public function relay_response() {
        // $redirect_url = "http://YOUR_DOMAIN.com/receipt_page.php";
        // $api_login_id = 'YOUR_API_LOGIN_ID';
        // $md5_setting = ""; // Your MD5 Setting
        // $response = new AuthorizeNetSIM($api_login_id, $md5_setting); if ($response->isAuthorizeNet())
        // {
        // if ($response->approved)
        //    {
        //        // Do your processing here.
        //        $redirect_url .= '?response_code=1&transaction_id=' .
        //        $response->transaction_id;
        // } else {
        // $redirect_url .= '?response_code='.$response->response_code .  '&response_reason_text=' . $response->response_reason_text;
        // }
        // // Send the Javascript back to AuthorizeNet, which will redirect user back to 
        //    echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
        // } else
        // {
        // echo "Error. Check your MD5 Setting.";
        // }
    }

    public function confirm() {
        // // $this->autoRender = false;
        // debug($_POST);
        // debug('confirm'); exit;
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
