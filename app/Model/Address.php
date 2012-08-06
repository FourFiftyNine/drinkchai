<?php
App::uses('Model', 'Model');
/**
 * Address Model
 *
 * @property Business $Business
 * @property User $User
 * @property User $User
 */
class Address extends Model {

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

/**
 * hasMany associations
 *
 * @var array
 */
	// public $hasMany = array(
	// 	'User' => array(
	// 		'className' => 'User',
	// 		'foreignKey' => 'address_id',
	// 		'dependent' => false,
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => '',
	// 		'limit' => '',
	// 		'offset' => '',
	// 		'exclusive' => '',
	// 		'finderQuery' => '',
	// 		'counterQuery' => ''
	// 	)
	// );


	public $validate = array(
		'zip' => array(
	        'notEmpty' => array(
	          'rule' => 'notEmpty',
	          'message' => 'This field cannot be left blank'
	        ),
	        'maxLength' => array(
	          'rule' => array('maxLength', 5),          
	          'message' => 'Must be no larger than 5 digits long.'
	        ),
	        'minLength' => array(
	          'rule' => array('minLength', 5),          
	          'message' => 'Must be 5 digits long.'
	        ),
	        'numeric' => array(        
	          'rule' => 'numeric',          
	          'message' => 'Only numbers allowed'
	        )
	      ),
		'user_id' => array(
		    'rule' => 'checkAuth',
		    'message' => 'Nice try buddy.',
		    'on' => 'update'
		)
	);
	
	function checkAuth() {
	    $authorized = true;
	    if(!$this->hasAny(array(
	            'Address.id'=>$this->data['Address']['id'], 
	            'Address.user_id' => $this->data['Address']['user_id']))) {
	        $authorized = false;         
	    }
	    return $authorized;
	}
}


