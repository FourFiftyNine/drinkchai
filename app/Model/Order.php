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
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BillingAddress' => array(
			'className' => 'Address',
			'conditions' => '',
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
		)
	);
}
