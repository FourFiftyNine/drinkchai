<?php
/**
 * SessionComponent.  Provides access to Sessions from the Controller layer
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
 * @package       Cake.Controller.Component
 * @since         CakePHP(tm) v 0.10.0.1232
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
// App::uses('Component', 'Auth');
// App::uses('Component', 'Session');
/**
 * Session Component.
 *
 * Session handling from the controller.
 *
 * @package       Cake.Controller.Component
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/sessions.html
 * @link http://book.cakephp.org/2.0/en/development/sessions.html
 */
class DCComponent extends Component {

    public $components = array('Auth', 'Session');

    public function startup() {
        // $this->email = new CakeEmail('gmail');
        // $this->email->from(array('team@drinkchai.com' => 'DrinkChai.com'));
    }

    // SHOULD ONLY SET DATA
    // public function setUserData() {
    //     $userModel = ClassRegistry::init('User');

    //     if ($this->Auth->user('user_type') == 'business') {
    //       $userModel->Behaviors->attach('Containable', array('recursive' => false));
    //       $userModel->contain('Business');
    //     } else {
    //       $userModel->recursive = -1;
    //     }
    //     $user = $userModel->findById($this->Auth->user('id'));
    //     // debug($user);
    //     if ($user) {
    //         $this->set('user', $user);    
    //     } else {
    //         $this->Auth->logout();
    //     }
    // }
}