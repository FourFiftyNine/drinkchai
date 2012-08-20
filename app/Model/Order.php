<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
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

	public $hasMany = array(
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'shipping_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'billing_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
