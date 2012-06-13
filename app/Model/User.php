<?php
App::uses('Model', 'Model');
/**
 * User Model
 *
 * @property Address $Address
 * @property Address $Address
 * @property Business $Business
 * @property Order $Order
 */
class User extends Model {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	// public $belongsTo = array(
	// 	'Address' => array(
	// 		'className' => 'Address',
	// 		'foreignKey' => 'address_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	)
	// );

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'Deal' => array(
            'className' => 'Deal',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
	);

/**
 * hasOne associations
 *
 * @var array
 */
 	public $hasOne = array(
 		'Business' => array(
			'className' => 'Business',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    public $validate = array(
        'email'             => array(
            'notEmptyRule'      => array(
                'rule'              => 'notEmpty',
                'required'          => true,
                'message'           => 'This field cannot be left blanks'// TODO MESSAGE
            ),   
            'isUniqueRule'      => array(
                'rule'              => 'isUnique',
                'message'           => 'Email already in use.'
            ),
            'isEmail'           => array(
                'rule'              => 'email',
                'message'           => 'Please supply a valid email address.'
            ),
        ),
        'firstname'         => array(
            'rule'              => 'notEmpty' // TODO MESSAGE
        ),
        'lastname'          => array(
            'rule'              => 'notEmpty'// TODO MESSAGE
        ),
        'password'          => array(
            'notEmptyRule'      => array(
                'rule'              => 'notEmpty',
                'message'           => 'This field cannot be left blank'
            ),
            'lengthRule'        => array(
                  'rule' => array('minLength', 5),          
                  'message' => 'Must be 5 digits long.'
            )
        ),
        'password_confirm'  => array(
            'notEmptyRule'      => array(
                'rule'              => 'notEmpty',
                'message'           => 'This field cannot be left blank'
            ),
            'matchingPasswords' => array(
                'rule'              => array('matchingPasswords'),
                'message'           => 'Passwords must match'
            ),
        ),
    );

    public function beforeSave($options = array()) {
        if(isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }

    public function facebook_sign_in ($facebookUser){
        $existingUser = $this->find('first', array('conditions' => array('User.email' => $facebookUser['email'])));
        $this->id = $existingUser['User']['id'];
        if($return = $this->Business->find('first', array('conditions' => array('Business.user_id' => $existingUser['User']['id'])))){
            $return['User']['hasAccount'] = true;
            return $return;
        } elseif($existingUser){
            $this->updateFacebookUser($facebookUser);
            return $existingUser;
        } elseif(empty($facebookUser['id']) || empty($facebookUser['first_name']) || empty($facebookUser['last_name']) || empty($facebookUser['email'])){
            return false;
        } else {
            $data = $this->packageFacebookData($facebookUser);
            if($this->save($data, false)){
                $data['hasAccount'] = false;
                return $data;
            }
        }

    }
    
    public function updateFacebookUser($facebookUser){
        $data = $this->packageFacebookData($facebookUser);
        $this->set($data);
        $this->save($data, false);
    }
    
    private function packageFacebookData($facebookUser) {
        $data['User']['firstname']        = $facebookUser['first_name'];
        $data['User']['lastname']         = $facebookUser['last_name'];
        $data['User']['email']            = $facebookUser['email'];
        $data['User']['facebook_id']      = $facebookUser['id'];
        $data['User']['password']         = AuthComponent::password($this->generatePassword());
        return $data;
    }
    private function generatePassword ($length = 8){ 
        $password = ""; 
        $i = 0; 
        $possible = "0123456789bcdfghjkmnpqrstvwxyz";  

        while ($i < $length){ 
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1); 

            if (!strstr($password, $char)) {  
                $password .= $char; 
                $i++; 
            } 
        } 
        return $password; 
    }
    
    // public function notEmptyPassword ($check){
    //     debug($check);
    //     if(empty($check['password']){
    //         return false;
    //     } else {
    //         return true;
    //     }
    // }
    
    public function matchingPasswords ($check){
        if($this->data['User']['password'] == $check['password_confirm']){
            return true;
        } else {
            return false;
        }
    }
}