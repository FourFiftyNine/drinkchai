<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 * @property ShippingAddress $ShippingAddress
 * @property BillingAddress $BillingAddress
 * @property Deal $Deal
 * @property User $User
 */
class Order extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShippingAddress' => array(
			'className' => 'Address',
			'conditions' => array('ShippingAddress.type' => 'shipping'),
			'fields' => '',
			'order' => ''
		),
		'BillingAddress' => array(
			'className' => 'Address',
			'conditions' => array('BillingAddress.type' => 'billing'),
			'fields' => '',
			'order' => ''
		),
		'Deal' => array(
			'className' => 'Deal',
			'foreignKey' => 'deal_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Business' => array(
			'className' => 'Business',
			'foreignKey' => 'business_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Billing' => array(
			'className' => 'Billing',
			'foreignKey' => 'billing_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	/**
	 * hasOne associations
	 *
	 * @var array
	 */
		// public $hasOne = array(
		// 	'Billing' => array(
		// 		'className'  => 'Billing',
		// 	)
		// );


	public function hasBillingAddress($userID) {
		return $this->BillingAddress->hasAny(array('BillingAddress.user_id' => $userID));
	}

	public function hasShippingAddress($userID) {
		return $this->ShippingAddress->hasAny(array('ShippingAddress.user_id' => $userID));
	}

	public function findOrderList($userID) {
	    // $this->recursive = -1;
	    $this->Behaviors->attach('Containable', array('recursive' => false));
	    $this->contain('Deal.product_name', 'Deal.price', 'Status');
	    return $this->find('all', array('conditions' => array('Order.user_id' => $userID), 'order' => array('modified' => 'desc')));
	}

	// public function 

	// public function hasAddresses() {
	// 	$hasAddresses = true;
	// 	$this->ShippingAddress->hasAny(array())

	// }
	
}
