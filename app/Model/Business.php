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


}
