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

App::uses('Component', 'Controller');
App::uses('Component', 'Auth');
App::uses('Component', 'Session');
App::import('Model', 'Deal');

/**
 * Session Component.
 *
 * Session handling from the controller.
 *
 * @package       Cake.Controller.Component
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/sessions.html
 * @link http://book.cakephp.org/2.0/en/development/sessions.html
 */
class DCAuthComponent extends Component {

    public $components = array('Auth', 'Session');

    public function businessLoggedIn() {
        if ($this->Auth->loggedIn()) {
            // $bUser = $this->Session->read('Business');
            if ($this->Auth->user('user_type') == 'business') {
                return true;
            }
        }
        return false;
    }

    public function businessOwnsDeal($dealId) {
        // debug($this->user('Deal')); exit;
        $Deal = new Deal();
        if ($this->Auth->loggedIn()) {
            $return = $Deal->findAllByUserId($this->Auth->user('id'));
            $deals = array();
            foreach ( $return as $item ) {
                $deals[] = $item['Deal'];
            }
            foreach ($deals as $deal) {
                if ($deal['id'] == $dealId) {
                    return true;
                }
            }
        }
        return false;
    }
}