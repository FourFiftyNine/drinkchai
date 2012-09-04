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
        // $this->Deal->recursive = -1;
        // debug($this->Auth->user('id'));
        $return = $this->Deal->findAllByUserId($this->Auth->user('id'));
        $liveDeal       = array();
        $draftDeals     = array();
        $completedDeals = array();
        foreach($return as $deal) {
            if ($deal['Status']['status'] == 'live') {
                $liveDeal[] = $deal;
            } else if ($deal['Status']['status'] == 'draft') {
                $draftDeals[] = $deal;
            } else if ($deal['Status']['status'] == 'completed') {
                $completedDeals[] = $deal;
            }
        }
        $this->set('liveDeal', $liveDeal);
        $this->set('draftDeals', $draftDeals);
        $this->set('completedDeals', $completedDeals);
        // debug($return);
        // $this->set('deals', $return);
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
        $this->setDealData($dealData);
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
            $this->setDealData($return);
            $this->redirect('/deals/' . $return['Business']['slug'] . '/' . $return['Deal']['slug']);
        } elseif ($return = $this->Deal->getDealBySlug($this->params['company'], $this->params['deal'])) {
            $this->setDealData($return);
     
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

        $businessData = $this->setBusinessData();

        if ($this->request->is('post')) {
           
            $this->Deal->create();
            unset($this->request->data['Image']);
            $this->request->data['Deal']['status_id'] = 17;
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
}