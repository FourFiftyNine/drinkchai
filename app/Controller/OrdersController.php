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
        parent::beforeFilter();
        $this->Auth->allow('quicky');
        // define("AUTHORIZENET_API_LOGIN_ID", "7wUVfB38jfJ");
        // define("AUTHORIZENET_TRANSACTION_KEY", "624Ff3sfz77GNMGk");
        define("AUTHORIZENET_API_LOGIN_ID", "36BY7bqn");
        define("AUTHORIZENET_TRANSACTION_KEY", "8VuDVU2P3s4f55nU");
        define("AUTHORIZENET_SANDBOX", true);
      
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
