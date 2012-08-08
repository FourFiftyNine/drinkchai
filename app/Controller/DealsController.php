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

    public function preview($id = null)
    {   
        $this->Deal->id = $id;
        $dealData = $this->Deal->read();
        if (!$this->DCAuth->businessOwnsDeal($dealData)) {
            $this->Session->setFlash('No way jose, not your deal.');
            $this->redirect('/account/deals');
        }
        $this->Session->setFlash(__('This is a preview of your deal'), 'flash_preview');
        $this->setupDealData($dealData);
        $this->render('view');
    }
/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function view() {
        if(empty($this->params['company']) || empty($this->params['deal'])){
            $return = $this->Deal->find('first', array('conditions' => array('Deal.is_live' => true)));
            // debug($return); exit;
            if(empty($return)) {
                $this->redirect('/'); // might cause infinite redirect loop... 
            }
            $this->setupDealData($return);
            $this->redirect('/deals/' . $return['Business']['slug'] . '/' . $return['Deal']['slug']);
        } elseif ($return = $this->Deal->getDealBySlug($this->params['company'], $this->params['deal'])) {
            $this->setupDealData($return);
     
        } else {
            throw new NotFoundException('Sorry, could not find that deal?');
        }
    }

    private function setupDealData($data) {
        $timeArray = $this->dateDiff(time(), $data['Deal']['end_date'] . ' ' . $data['Deal']['end_time']);

        $data['Deal']['time_left'] = $this->getTimeRemainingLabel($timeArray);
        $this->set('title_for_layout', $data['Deal']['product_name']);
        $this->setImages($data['Image']);

        $this->set('data', $data);
    }
/**
 * create method
 *
 * @return void
 */
    public function create() {

        $businessData = $this->setBusinessData();

        if ($this->request->is('post')) {
           
            $this->Deal->create();
            unset($this->request->data['Image']);
            if ($this->Deal->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The deal has been saved'));
                $this->redirect(array('action' => 'index'));
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
        $this->Deal->id = $id;
        $dealData = $this->Deal->read();
        // debug($dealData);
        if (!$this->DCAuth->businessOwnsDeal($dealData)) {
            $this->Session->setFlash('No way jose, not your deal.');
            $this->redirect('/account/deals');
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->setBusinessData($dealData);
            unset($this->request->data['Image']);
            if ($ret = $this->Deal->saveAll($this->request->data)) {
                $this->Session->setFlash(__('Your deal has been saved'));
            } else {
                $this->Session->setFlash(__('The deal could not be saved. Please, try again.'));
            }
            // TODO Use $ret?
            $this->request->data = $this->Deal->read();

        } else {
            $this->request->data = $dealData;
        }
        $this->setImages($this->request->data['Image']);

    }

    private function setBusinessData($dealData = null) {

        $userId = $this->Auth->user('id');
        $businessData['Business'] = $dealData['Business'];
        // debug($dealData);
        if(!$dealData) {
            $this->Deal->Business->recursive = -1;
            $businessData = $this->Deal->Business->findByUserId($userId);
        }

        $this->request->data['Deal']['user_id'] = $userId;
        $this->request->data['Business']['id'] = $businessData['Business']['id'];
        $this->request->data['Deal']['business_id'] = $businessData['Business']['id'];

        return $businessData;
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