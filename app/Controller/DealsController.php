<?php
App::uses('AppController', 'Controller');
CakePlugin::load('Uploader');
App::import('Vendor', 'Uploader.Uploader');
 
/**
 * Deals Controller
 *
 * @property Deal $Deal
 */
class DealsController extends AppController {

    // public $helpers = array('Deal');

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('view', 'get_time_left');
        // $this->Auth->allow('index',  'view', 'delete', 'edit');
    }

/**
 * index method
 *
 * @return void
 */
    public function index(){
        $this->Deal->recursive = -1;
        $return = $this->Deal->findAllByUserId($this->Auth->user('id'));
        // debug($return);
        $this->set('deals', $return);
    }

    public function preview()
    {   
        $return = array();
        if ($this->DCAuth->businessOwnsDeal($this->params['id'])) {
            $return = $this->Deal->find('first', array('conditions' => array('Deal.id' => $this->params['id'])));
        }
        $this->Session->setFlash(__('This is a preview of your deal'), 'flash_preview');
   
        $timeArray = $this->dateDiff(time(), $return['Deal']['end_date'] . ' ' . $return['Deal']['end_time']);
        $logo = false;

        $this->setImages($return['Image']);
        // $offest = (250 - $return['Image']['height']) / 2;
        // $return['Image']
        // debug($this->getTimeRemainingLabel($timeArray));
        $return['Deal']['time_left'] = $this->getTimeRemainingLabel($timeArray);

        $this->set('data', $return);
        $this->render('view');
    }
/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function view() {
        // $return = $this->Deal->findByUserId($this->Auth->user('id'));
        // // $this->set('Business', $return['Business']);
        // // debug($this->params['deal']);
        // $this->set('title_for_layout', 'Find and Buy Tea');
        // debug($this->request);
        if(empty($this->params['company']) || empty($this->params['deal'])){
            $return = $this->Deal->find('first', array('conditions' => array('Deal.is_live' => true)));
            // debug($return); exit;
            if(empty($return)) {
                $this->redirect('/'); // might cause infinite redirect loop... 
            }

            $timeArray = $this->dateDiff(time(), $return['Deal']['end_date'] . ' ' . $return['Deal']['end_time']);

            // debug($this->getTimeRemainingLabel($timeArray));
            $return['Deal']['time_left'] = $this->getTimeRemainingLabel($timeArray);
            $logo = false;

            foreach($return['Image'] as $key => $image) {
                if ($image['deleted'] || $image['is_logo']) { 
                  if ($image['is_logo'] && !$image['deleted']) {
                    $logo = $image;
                  }
                  continue; 
                }
                $return['Image'][$key]['offset'] = 0;
                if($image['resized_height'] < 250) {
                    $return['Image'][$key]['offset'] = (250 - $image['resized_height']) / 2;
                }
            }
            $return['Image']['logo'] = $logo;
            $this->set('data', $return);
            // debug('/deals' . $currentDeal['Business']['slug'] . '/' . $currentDeal['Deal']['slug']); exit;
            // $this->redirect('/deals/' . $currentDeal['Business']['slug'] . '/' . $currentDeal['Deal']['slug']);
        } elseif ($return = $this->Deal->getDealBySlug($this->params['company'], $this->params['deal'])) {
            $timeArray = $this->dateDiff(time(), $return['Deal']['end_date'] . ' ' . $return['Deal']['end_time']);

            $logo = false;

            foreach($return['Image'] as $key => $image) {
                if ($image['deleted'] || $image['is_logo']) { 
                  if ($image['is_logo'] && !$image['deleted']) {
                    $logo = $image;
                  }
                  continue; 
                }
                $return['Image'][$key]['offset'] = 0;
                if($image['resized_height'] < 250) {
                    $return['Image'][$key]['offset'] = (250 - $image['resized_height']) / 2;
                }
            }
            $return['Image']['logo'] = $logo;
            // $offest = (250 - $return['Image']['height']) / 2;
            // $return['Image']
            // debug($this->getTimeRemainingLabel($timeArray));
            $return['Deal']['time_left'] = $this->getTimeRemainingLabel($timeArray);
            $this->set('data', $return);
     
        } else {
            throw new NotFoundException('Sorry, could not find that deal?');
        }
    }


/**
 * create method
 *
 * @return void
 */
    public function create() {
        // debug($this->_user['Business']['id']);
        // debug();
        $userId = $this->Auth->user('id');

        $this->Deal->Business->recursive = -1;
        $businessData = $this->Deal->Business->findByUserId($userId);

        $this->request->data['Deal']['user_id'] = $userId;
        $this->request->data['Business']['id'] = $businessData['Business']['id'];
        $this->request->data['Deal']['business_id'] = $businessData['Business']['id'];
        if ($this->request->is('post')) {
           
            // debug($this->request->data); exit;
            $this->Deal->create();



            // $this->request
            // $this->request
            // $this->Deal->Business->id = $this->_user['Business']['id'];


            // $this->request->data['Deal']['business_id'] = $this->_user['Business']['id'];
            unset($this->request->data['Image']);
            if ($this->Deal->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The deal has been saved'));
                // $this->_refreshAuth();
                $this->redirect(array('action' => 'index'));

                // debug($this->Deal->Business->find('first', array('conditions' => array('User.id' => $this->_user['User']['id'])))); exit;
            } else {
                $this->Session->setFlash(__('The deal could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data['Business'] = $businessData['Business'];
        }
        $this->render('edit');
    }

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
    public function edit($id = null) {
        if (!$this->DCAuth->businessOwnsDeal($id)) {
            $this->Session->setFlash('No way jose, not your deal.');
            $this->redirect('/' . $this->Session->read('Business.slug'));
        }
        $this->Deal->id = $id;
        // $this->Deal->Business->id = 
        // debug($this->Auth->user());
        if (!$this->Deal->exists()) {
            throw new NotFoundException(__('Invalid deal'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            // $this->request->data['Business']['id'] = $this->_user['Business']['id'];
            $userId = $this->Auth->user('id');
            // debug($this->request->data); exit;

            $this->Deal->Business->recursive = -1;
            $businessData = $this->Deal->Business->findByUserId($userId);
            // $this->Deal->recursive = -1;
            // $businessData = $this->Deal->findById($id);
            // $dealModelData = $businessData
            // debug($businessData); exit;
            $this->request->data['Deal']['user_id'] = $userId;
            $this->request->data['Deal']['business_id'] = $businessData['Business']['id'];
            $this->request->data['Business']['id'] = $businessData['Business']['id'];
            // debug($this->request->data); exit;
            // $this->Deal->Image->create();
            // debug($this->request->data); exit;
            unset($this->request->data['Image']);
            if ($ret = $this->Deal->saveAll($this->request->data)) {
                // $ret = $this->User->Business->find('first', array('conditions' => array('User.id' => $this->_user['User']['id'])));
                // $this->Session->write('Auth.User', $ret);

                $this->Session->setFlash(__('Your deal has been saved'));
            } else {
                $this->Session->setFlash(__('The deal could not be saved. Please, try again.'));
            }
            
            // debug($this->Deal->read()); exit;
            $this->request->data = $this->Deal->findById($id);
            // debug($this->request->data);
            $this->setImages($this->request->data['Image']);

        } else {
            // debug($this->Deal->read()); exit;
            $this->request->data = $this->Deal->read();
            // debug($this->request->data); exit;
            $this->setImages($this->request->data['Image']);

        }
        // $businesses = $this->Deal->Business->find('list');
        // $this->set(compact('businesses'));
    }

    private function setImages($imageData) {
        foreach ($imageData as $image) {
            if ($image['type'] == 'product') {
                $this->set('productImage', $image);
            }
            if ($image['type'] == 'logo') {
                $this->set('logo', $image);
            }
        }
    }
/**
 * delete method
 *
 * @param string $id
 * @return void
 */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $this->Deal->id = $id;


        if (!$this->Deal->exists()) {
            throw new NotFoundException(__('Invalid deal'));
        }

        $this->request->data['Deal']['status'] = 'deleted';

        if ($this->Deal->save($this->request->data)) {
            $this->Session->setFlash(__('Deal deleted'));
            $this->redirect('/account/deals');
        }
        $this->Session->setFlash(__('Deal was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function get_time_left() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }


        if($this->RequestHandler->isAjax()) {
            $this->autoRender = false;
            $this->RequestHandler->respondAs('json');
            // $this->Image->set('deleted', true);
            $this->Deal->recursive = -1;

            // debug();
            // return json_encode($this->request->data);
            $deal_id = $this->request->data['deal_id'];
            // return json_encode($deal_id);
            $return = $this->Deal->findById($deal_id);
            // if($return = $this->Image->save()) {
            //     return json_encode($return);
            // } else {
            //     return json_encode(array('error' => 'Could not delete.'));
            // }
            $time_array = $this->dateDiff(time(), $return['Deal']['end_date'] . ' ' . $return['Deal']['end_time']);
            $time_left = $this->getTimeRemainingLabel($time_array);
            return json_encode($time_left);
        }


    }
    // http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
    private function dateDiff($time1, $time2, $precision = 6) {
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

    private function getTimeRemainingLabel($timeArray) {
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