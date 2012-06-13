<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Vendor', 'facebook/facebook');
App::import('Model', 'Business');
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * This is a placeholder class.
 * Create the same file in app/Controller/AppController.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       Cake.Controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {
    public $facebook;

	public $components = array('Auth' => array(
        'authenticate' => array(
            'Form' => array(
                'fields' => array('username' => 'email')
            ),
        ),
        'authError' => 'Please login to view that page.'
    ), 'Session', 'RequestHandler', 'Cookie', 'DCAuth', 'DebugKit.Toolbar');

    public $helpers = array('Session', 'Form', 'Html', 'Js'=>array("Jquery"));
    // public $uses = array('User');
    
    public function beforeRender() {
    	if($this->name == 'CakeError') {
    		$this->layout = 'error';
    	}
        $user['User'] = $this->Auth->user();
        $this->set('user', $user);
        // debug($this->Auth->user()); exit;
        if ($this->Auth->user('user_type_id') == 2) {
            $this->Business = ClassRegistry::init('Business');

            $business = $this->Business->findByUserId($this->Auth->user('id'));
            $this->set('business', $business['Business']);
        }
    }

    public function beforeFilter() {
        $this->layout = 'generic';
        // $this->Auth->allow('display');
        if (stristr(env('HTTP_HOST'), '.dev')) { 
            $this->facebook = new Facebook(array(
                'appId'  => '259510874070364',
                'secret' => '78f1c9ae321ba10215d07e6a2176d6ee',
            ));
            Configure::write('debug', 2); 
        } else if (stristr(env('HTTP_HOST'), 'dc2.anthonysessa.net')) { 
            $this->facebook = new Facebook(array(
                'appId'  => '305067682888921',
                'secret' => 'ced3eed874557855df68aa74074b577a',
            ));
            Configure::write('debug', 2); 
        } else {
            Configure::write('debug', 2); 
        }
        $this->__checkFBStatus();
    }


    private function __checkFBStatus()
    { 
        // debug($this->facebook->getUser()); exit;
        // debug($this->Auth->user()); exit;
        if(!$this->Auth->user() && $this->facebook->getUser()) {
            try {
                $user_profile = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                // TODO LOG
                // echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
                // $user = null;
            }
            if(isset($user_profile)) {
                $return = ClassRegistry::init('User')->facebook_sign_in($user_profile);
            }
            if(isset($return)){
                // unset($return['User']['password']);
                // debug($return); exit;
                if ($this->Auth->login($return)) {
                    $this->Session->write('Business', $return['Business']);
                    return $this->redirect('/');
                } else {
                    $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
                }
            } else {
                // $this->redirect('/');
            }
            // try {
            //     // Proceed knowing you have a logged in user who's authenticated.
            //     // $user_profile = $facebook->api('/me');
            // } catch (FacebookApiException $e) {
            //     // TODO LOG
            //     // echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
            //     // $user = null;
            // }
        }
    }


    /**
     * Refreshes the Auth session
     * @param string $field
     * @param string $value
     * @return void 
     */
    function _refreshAuth($field = '', $value = '') {
        if (!empty($field) && !empty($value)) { 
            $this->Session->write($this->Auth->sessionKey .'.'. $field, $value);
        } else {
            if (isset($this->User)) {
                $this->Auth->login($this->User->read(false, $this->Auth->user('id')));
            } else {
                $this->Auth->login(ClassRegistry::init('User')->findById($this->Auth->user('id')));
            }
        }
    }

}
