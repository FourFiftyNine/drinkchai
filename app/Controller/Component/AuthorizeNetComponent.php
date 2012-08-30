<?php
App::import('Vendor', 'AuthorizeNet/AuthorizeNet');
// App::uses('CakeRequest', 'CakeRequest');

class AuthorizeNetComponent extends Component {

    public $components = array('Auth', 'RequestHandler');

    // TODO make into robust with REQUEST DATA access
    // public function initialize(&$controller, $settings = array()) {
    //     $this->controller = $controller;
    //     $this->request = $this->controller->request;
    // }
    public function initialize(&$controller, $settings = array()) {
        // four50nine
        define("AUTHORIZENET_API_LOGIN_ID", "36BY7bqn");
        define("AUTHORIZENET_TRANSACTION_KEY", "487gvW3TwK9Q3H5f");
        $this->request = new AuthorizeNetCIM;
        // LIVE
        // define("AUTHORIZENET_API_LOGIN_ID", "7wUVfB38jfJ");
        // define("AUTHORIZENET_TRANSACTION_KEY", "3D2JpT629r463Gq7");
        // define("AUTHORIZENET_SANDBOX", false);

        // API Login ID 2XqQwJzf43X
        // LIVE 7wUVfB38jfJ

        // Transaction Key 25PcmXJxH26n63as
        // 3D2JpT629r463Gq7

    }

    public function startup() {
        // Stripe::setApiKey("sk_08sMJifZ11GeVCl5SIvz6tuTYQGS9");
        // saving the controller reference for later use        
    }    

    public function createCustomer() {
        
        // Create new customer profile
        $customerProfile                    = new AuthorizeNetCustomer;
        $customerProfile->description       = "Description of customer";
        $customerProfile->merchantCustomerId= time();
        $customerProfile->email             = "test@domain.com";
        $response = $this->request->createCustomerProfile($customerProfile);
        if ($response->isOk()) {
            $customerProfileId = $response->getCustomerProfileId();
        }
        // debug($response);
        return $customerProfileId;
        // debug($customerProfileId)
    }

    public function getProfilePageRequestToken($customerProfileID) {
        
        $settings=array(
            'hostedProfileIFrameCommunicatorUrl'=>'https://drinkchai.dev/IframeCommunicator.html', 
            'hostedProfilePageBorderVisible' => 'false',
            // 'hostedProfileHeadingBgColor' => '#9b693f',
            // 'hostedProfileHeadingColor' => '#9b693f'
        );

        $response = $this->request->getHostedProfilePageRequest($customerProfileID,$settings);
        $token=trim($response->xml->token);
        return $token;
    }
    // public function updateCustomer($customerID, $cardToken) {
    //     // debug($this->request); exit;
    //     $customer = Stripe_Customer::retrieve($customerID);
    //     $customer->card = $cardToken;
    //     $customer->save();
    //     return $customer;
    // }

    public function getCustomerProfile($customerProfileID) {
        
        $response = $this->request->getCustomerProfile($customerProfileID);
        // debug($response); exit;
    }

    public function getCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId) {

        $response = $this->request->getCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId);
        debug($response); exit;

    }

    public function createCustomerProfileTransaction($transaction = array(), $transactionType = 'AuthOnly') {
        $response = $this->request->createCustomerProfileTransaction($transactionType, $transaction, 'x_delim_char=|');
        return $response;
    }

    public function createCharge($customerID, $amount, $currency = 'usd', $description = null) {
        return Stripe_Charge::create(array(
            "amount"      => $amount,
            "currency"    => $currency,
            "customer"    => $customerID,
            "description" => $description
        ));
    }

}