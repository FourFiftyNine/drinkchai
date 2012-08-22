<?php
App::uses('AppModel', 'Model');
/**
 * Address Model
 *
 * @property User $User
 */
class Address extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'firstname' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lastname' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'address_one' => array(
			// 'alphanumeric' => array(
			// 	'rule' => array('alphanumeric'),
			// 	//'message' => 'Your custom message here',
			// 	//'allowEmpty' => false,
			// 	//'required' => false,
			// 	//'last' => false, // Stop validation after this rule
			// 	//'on' => 'create', // Limit validation to 'create' or 'update' operations
			// ),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'address_two' => array(
			// 'alphanumeric' => array(
			// 	'rule' => array('alphanumeric'),
			// 	//'message' => 'Your custom message here',
			// 	// 'allowEmpty' => true,
			// 	//'required' => false,
			// 	//'last' => false, // Stop validation after this rule
			// 	//'on' => 'create', // Limit validation to 'create' or 'update' operations
			// ),
		),
		'state' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'zip' => array(
			'postal' => array(
				'rule' => array('postal', null, 'us'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'city' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
		    'rule' => 'checkAuth',
		    'message' => 'Something went wrong. Please try again.',
		    'on' => 'update'
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'ShippingAddress' => array(
			'className' => 'Order',
			'foreignKey' => 'shipping_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BillingAddress' => array(
			'className' => 'Order',
			'foreignKey' => 'billing_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	// public $hasOne = array('State');
	public $hasOne = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function afterSave($created) {
		// if ($created) {
		// 	debug($this->data); exit;
		// }
	}
	function checkAuth() {
		// debug($this);
	    $authorized = true;
	    if(!$this->hasAny(array(
	           	$this->alias . '.id'=> $this->data[$this->alias]['id'], 
	            $this->alias . '.user_id' => $this->data[$this->alias]['user_id']))) {
	        $authorized = false;         
	    }
	    return $authorized;
	}

	public function beforeSave() {
		if (!empty($this->data['ShippingAddress'])) {
			$this->data['ShippingAddress']['type'] = 'shipping';
		}
		if (!empty($this->data['BillingAddress'])) {
			$this->data['BillingAddress']['type'] = 'billing';
		}
		return true;
	}
	
	public function findMostRecentBillingAddress($userID) {
		$this->recursive = -1;
		return $this->find('first', array('conditions' => array('BillingAddress.user_id' => $userID, 'BillingAddress.type' => 'billing'), 'order' => array('modified' => 'desc')));
	}

	public function findMostRecentShippingAddress($userID) {
		$this->recursive = -1;
		return $this->find('first', array('conditions' => array('ShippingAddress.user_id' => $userID, 'ShippingAddress.type' => 'shipping'), 'order' => array('modified' => 'desc')));
	}
}
