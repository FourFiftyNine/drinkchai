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

/**
 * Session Component.
 *
 * Session handling from the controller.
 *
 * @package       Cake.Controller.Component
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/sessions.html
 * @link http://book.cakephp.org/2.0/en/development/sessions.html
 */
class DCEmailComponent extends Component {

    // public $components = array('Email');
    private $email;

    public function startup() {
        $this->email = new CakeEmail('gmail');
        $this->email->from(array('team@drinkchai.com' => 'DrinkChai.com'));
    }
    public function sendLaunchEmail($emailAddress) {
        $this->email->to($emailAddress)
            ->subject('🍵 Welcome to DrinkChai')
            ->send("DrinkChai.com is a place where you can ");
    }

    public function sendUserSignUpEmail($emailAddress) {
        $this->email->to($emailAddress)
            ->subject('🍵 Welcome to DrinkChai')
            ->send("DrinkChai.com is a place where you can ");
    }
   
}