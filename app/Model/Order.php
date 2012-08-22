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
	);

	/**
	 * hasOne associations
	 *
	 * @var array
	 */
		public $hasOne = array(
			'Billing' => array(
				'className'  => 'Billing',
			)
		);



	// public function hasAddresses() {
	// 	$hasAddresses = true;
	// 	$this->ShippingAddress->hasAny(array())

	// }
	
}
