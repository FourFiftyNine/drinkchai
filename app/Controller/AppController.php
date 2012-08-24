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
App::import('Vendor', 'facebook/src/facebook');
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

	public $components = array(
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email')
                )
            ),
            'authError' => 'Please login to view that page.',
        ),
        'Session', 'RequestHandler', 'Cookie', 'DCAuth', 'DebugKit.Toolbar');

    public $helpers = array('Session', 'Form', 'Html' => array('className' => 'MyHtml'), 'Js'=>array("Jquery"));
    // public $uses = array('User');
    
    public function beforeRender() {
    	if($this->name == 'CakeError') {
    		$this->layout = 'error';
    	}
        $this->setUserData();
    }

    public function beforeFilter() {
        
        // FORCE SSL on all except live deals

        if (stristr(env('HTTP_HOST'), '.dev')) { 
            $this->facebook = new Facebook(array(
                'appId'  => '259510874070364',
                'secret' => '78f1c9ae321ba10215d07e6a2176d6ee',
            ));
            // $this->Security = $this->Components->load('Security');
            // if ($this->request->params['controller'] != 'deals' && $this->request->params['action'] != 'view') {
            //     // $this->Security->requireSecure();
            //     $this->Security->blackHoleCallback = 'forceSSL';
            // }
            Configure::write('debug', 2); 
        } else if (stristr(env('HTTP_HOST'), 'dc.vinyljudge.com')) { 
            $this->facebook = new Facebook(array(
                'appId'  => '305067682888921',
                'secret' => 'ced3eed874557855df68aa74074b577a',
            ));
            Configure::write('debug', 2); 
        } else {
            Configure::write('debug', 2); 
        }
        if($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
        }
        $this->__checkFBStatus();

    }


    public function forceSSL() {
        $this->redirect('https://' . env('SERVER_NAME') . $this->here);
    }

    public function removeSSL() {
        $this->redirect('http://' . env('SERVER_NAME') . $this->here);
    }

    private function __checkFBStatus()
    { 
        // debug($this->facebook->getUser()); exit;
        // debug($this->Auth->user()); exit;
        // BaseFacebook::$CURL_OPTS[CURLOPT_CONNECTTIMEOUT] = 30;
        // debug(BaseFacebook::$CURL_OPTS); exit;
        if(!$this->Auth->user() && $this->facebook->getUser()) {

            try {
                $user_profile = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                // TODO LOG
                // echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
                $user_profile = null;
            }

            if(isset($user_profile)) {
                $return = ClassRegistry::init('User')->facebook_sign_in($user_profile);
            }
            if(isset($return)){
                // unset($return['User']['password']);
                // debug($return); exit;
                if ($this->Auth->login($return['User'])) {
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
        } else {
            // $this->Auth->logout();
        }
    }


    /**
     * Refreshes the Auth session
     * @param string $field
     * @param string $value
     * @return void 
     */
    private function _refreshAuth($field = '', $value = '') {
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

    protected function setUserData() {
        $userModel = ClassRegistry::init('User');


        if ($this->Auth->user('user_type') == 'business') {
          $userModel->Behaviors->attach('Containable', array('recursive' => false));
          $userModel->contain('Business');
        } else {
          $userModel->recursive = -1;
        }
        $user = $userModel->findById($this->Auth->user('id'));
        // debug($user);
        if ($user) {
            $this->set('user', $user);    
        } else {
            $this->Auth->logout();
        }
    }

    protected function setImages($imageData) {
        foreach ($imageData as $image) {
            if ($image['type'] == 'product') {
                $this->set('productImage', $image);
            }
            if ($image['type'] == 'logo') {
                $this->set('logo', $image);
            }
        }
    }

    protected function setDealData($data) {
        $timeArray = $this->dateDiff(time(), $data['Deal']['end_date'] . ' ' . $data['Deal']['end_time']);

        $data['Deal']['time_left'] = $this->getTimeRemainingLabel($timeArray);
        // TODO move this into specific actions
        $this->set('title_for_layout', $data['Deal']['product_name']);
        $this->setImages($data['Image']);

        $this->set('data', $data);
    }

      // http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
    protected function dateDiff($time1, $time2, $precision = 6) {
          // If not numeric then convert texts to unix timestamps
          if (!is_int($time1)) {
            $time1 = strtotime($time1);
          }
          if (!is_int($time2)) {
            $time2 = strtotime($time2);
          }
       
          // If time1 is bigger than time2
          // Then swap time1 and time2
          if ($time1 > $time2) {

              return false;
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
          }
       
          // Set up intervals and diffs arrays
          $intervals = array('year','month','day','hour','minute','second');
          $diffs = array();
       
          // Loop thru all intervals
          foreach ($intervals as $interval) {
            // Set default diff to 0
            $diffs[$interval] = 0;
            // Create temp time from time1 and interval
            $ttime = strtotime("+1 " . $interval, $time1);
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
          $time1 = $ttime;
          $diffs[$interval]++;
          // Create new temp time from time1 and interval
          $ttime = strtotime("+1 " . $interval, $time1);
            }
          }
       
          $count = 0;
          $times = array();
          // Loop thru all diffs
          foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
          break;
            }
            // Add value and interval 
            // if value is bigger than 0
            //  if ($value > 0) {
          // Add s if value is not 1
          // if ($value != 1) {
          //   $interval .= "s";
          // }
              $interval .= 's';
              // if($value < 10 && $interval != 'days') {
              //     // debug($value);
              //     $value = '0' . $value;
              // }
          // Add value and interval to times array
          $times[$interval] = $value;
          $count++;
            // }
          }
          // Return string with times
          return $times;
          // return implode(", ", $times);
    }

    protected function getTimeRemainingLabel($timeArray) {
        if(is_array($timeArray)) {
            $timeLeft = '';
            if($timeArray['days']) {
                $timeLeft .= $timeArray['days'] . ' day';
                $timeArray['days'] = $timeArray['days'] . ' day';
                if($timeArray['days']!= 1) {
                    $timeLeft .= 's ';
                    $timeArray['days'] .= 's ';
                }
            }
            $timeLeft .= $timeArray['hours'] . ':' . $timeArray['minutes'] . ':' . $timeArray['seconds'];
            // if(isset($timeArray['hours'])) {
            //     $timeLeft .= $timeArray['hours'] . ':' . $timeArray['minutes'] . ':' . $timeArray['seconds'];
            // }

            // return $timeLeft;
            return $timeArray;

        } else {
            return false;
        }
    }

}
