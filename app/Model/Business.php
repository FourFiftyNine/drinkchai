<?php
App::uses('Model', 'Model');
/**
 * Business Model
 *
 * @property User $User
 * @property Address $Address
 * @property Deal $Deal
 */
class Business extends Model {

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
		),
		// 'Deal' => array(
		// 	'className' => 'Deal',
		// 	'foreignKey' => 'user_id',
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => ''
		// )
	);

/**
 * hasMany associations
 *
 * @var array
 */

	// public $hasOne = array(
	// 	'Address' => array(
	// 		'className' => 'Address',
	// 		'foreignKey' => 'user_id',
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
	    'description' => array(
	      'rule' => 'notEmpty'
	    ),
	    'url_website' => array(
	    	'rule' => array('url'),
	    	'allowEmpty' => true,
	    	'message' => 'Please supply a valid url'
	    ),
	    'url_facebook' => array(
	    	'rule' => array('url'),
	    	'allowEmpty' => true,
	    	'message' => 'Please supply a valid url'
	    ),
	    'url_twitter' => array(
	    	'rule' => array('url'),
	    	'allowEmpty' => true,
	    	'message' => 'Please supply a valid url'
	    ),
	    'url_yelp' => array(
	    	'rule' => array('url'),
	    	'allowEmpty' => true,
	    	'message' => 'Please supply a valid url'
	    )
	  );

		public function beforeSave() {
		    if (!empty($this->data['Business']['url_website'])) {
		    	$this->data['Business']['url_website'] = str_replace('http://', '', $this->data['Business']['url_website']);
		    	$this->data['Business']['url_website'] = str_replace('https://', '', $this->data['Business']['url_website']);
		    }
		    if (!empty($this->data['Business']['url_facebook'])) {
		    	$this->data['Business']['url_facebook'] = str_replace('http://', '', $this->data['Business']['url_facebook']);
		    	$this->data['Business']['url_facebook'] = str_replace('https://', '', $this->data['Business']['url_facebook']);
		    }
		    if (!empty($this->data['Business']['url_twitter'])) {
		    	$this->data['Business']['url_twitter'] = str_replace('http://', '', $this->data['Business']['url_twitter']);
		    	$this->data['Business']['url_twitter'] = str_replace('https://', '', $this->data['Business']['url_twitter']);
		    }
		    if (!empty($this->data['Business']['url_yelp'])) {
		    	$this->data['Business']['url_yelp'] = str_replace('http://', '', $this->data['Business']['url_yelp']);
		    	$this->data['Business']['url_yelp'] = str_replace('https://', '', $this->data['Business']['url_yelp']);
		    }
		    return true;
		}



}
