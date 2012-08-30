<?php
App::import('Vendor', 'Stripe/lib/Stripe');
// App::uses('CakeRequest', 'CakeRequest');

class StripeComponent extends Component {

    public $components = array('Auth', 'RequestHandler');

    // TODO make into robust with REQUEST DATA access
    // public function initialize(&$controller, $settings = array()) {
    //     $this->controller = $controller;
    //     $this->request = $this->controller->request;
    // }

    public function startup() {
        Stripe::setApiKey("sk_08sMJifZ11GeVCl5SIvz6tuTYQGS9");
        // saving the controller reference for later use        
    }

    public function createCustomer($cardToken, $description = null, $email = null) {
        if (!$description) {
            $description = $this->Auth->user('firstname') . ' ' . $this->Auth->user('lastname');
        }

        if (!$email) {
            $email = $this->Auth->user('email');
        }
        return Stripe_Customer::create(array(
                "card" => $cardToken,
                "description" => $description,
                "email" => $email)
            );
    }
    public function updateCustomer($customerID, $cardToken) {
        // debug($this->request); exit;
        $customer = Stripe_Customer::retrieve($customerID);
        $customer->card = $cardToken;
        $customer->save();
        return $customer;
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