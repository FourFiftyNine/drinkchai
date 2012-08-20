<?php
App::uses('AppModel', 'Model');
/**
 * State Model
 *
 * @property Address $Address
 */
class State extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
