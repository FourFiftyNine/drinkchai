<?php
App::uses('AppController', 'Controller');
/**
 * Deals Controller
 *
 * @property Deal $Deal
 */
class DealsController extends AppController {

    // public $helpers = array('Deal');

    public function beforeFilter(){
        parent::beforeFilter();
        // $this->Auth->allow('index',  'view', 'delete', 'edit');
    }

/**
 * index method
 *
 * @return void
 */
    public function index(){
        // if (!$this->DCAuth->businessLoggedIn()) {
        //     $this->redirect('/users/login');
        // }
        
        // if($this->Auth->user('user_id_type'))
        $this->Deal->recursive = -1;
        $return = $this->Deal->findAllByUserId($this->Auth->user('id'));
        $this->set('deals', $return);
        // debug($return); exit;
        // if (!strstr($this->params->url, $this->Session->read('Business.slug'))) {
        //     $this->redirect('/' . $this->Session->read('Business.slug'), array('status' => '302'));
        // }
    }

    public function preview()
    {   
        $previewDeal = array();
        if ($this->DCAuth->businessOwnsDeal($this->params['id'])) {
            $previewDeal = $this->Deal->find('first', array('conditions' => array('Deal.id' => $this->params['id'])));
        }
        $this->Session->setFlash(__('This is a preview of your deal'), 'flash_preview');

        $this->set('data', $previewDeal);
        $this->render('view');
    }
/**
 * view method
 *
 * @param string $id
 * @return void
 */
    public function view() {
        $return = $this->Deal->findByUserId($this->Auth->user('id'));
        // $this->set('Business', $return['Business']);
        // debug($this->params['deal']);
        $this->set('title_for_layout', 'Find and Buy Tea');
        // debug($this->params['deal']);
        if(empty($this->params['company']) || empty($this->params['deal'])){
            $currentDeal = $this->Deal->find('first', array('conditions' => array('Deal.is_live' => true)));
            if(empty($currentDeal)) {
                $this->redirect('/');
            }
            // debug($currentDeal); exit;
            debug('/deals' . $currentDeal['Business']['slug'] . '/' . $currentDeal['Deal']['slug']); exit;
            $this->redirect('/deals/' . $currentDeal['Business']['slug'] . '/' . $currentDeal['Deal']['slug']);
        } elseif ($return = $this->Deal->getDealBySlug($this->params['company'], $this->params['deal'])) {
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
        if ($this->request->is('post')) {
           

            $this->Deal->create();

            $userId = $this->Auth->user('id');

            $this->Deal->Business->recursive = -1;
            $businessData = $this->Deal->Business->findByUserId($userId);

            $this->request->data['Deal']['user_id'] = $userId;
            $this->request->data['Deal']['business_id'] = $businessData['Business']['id'];

            // $this->request
            // $this->request
            // $this->Deal->Business->id = $this->_user['Business']['id'];


            // $this->request->data['Deal']['business_id'] = $this->_user['Business']['id'];
            if ($this->Deal->save($this->request->data)) {
                $this->Session->setFlash(__('The deal has been saved'));
                // $this->_refreshAuth();
                $this->redirect(array('action' => 'index'));

                // debug($this->Deal->Business->find('first', array('conditions' => array('User.id' => $this->_user['User']['id'])))); exit;
            } else {
                $this->Session->setFlash(__('The deal could not be saved. Please, try again.'));
            }
        }

    }

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
    public function edit($id = null) {
        if (!$this->DCAuth->businessOwnsDeal($this->params->id)) {
            $this->Session->setFlash('No way jose, not your deal.');
            $this->redirect('/' . $this->Session->read('Business.slug'));
        }
        $this->Deal->id = $this->params->id;
        // $this->Deal->Business->id = 
        // debug($this->Auth->user());

        if (!$this->Deal->exists()) {
            throw new NotFoundException(__('Invalid deal'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Business']['id'] = $this->_user['Business']['id'];
            if ($ret = $this->Deal->saveAll($this->request->data)) {
                $ret = $this->User->Business->find('first', array('conditions' => array('User.id' => $this->_user['User']['id'])));
                $this->Session->write('Auth.User', $ret);
                $this->request->data = $this->Deal->read(null, $this->params->id);
                $this->Session->setFlash(__('Your deal has been saved'));
            } else {
                $this->Session->setFlash(__('The deal could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Deal->read();
            // debug($this->request->data); exit;
            // debug($this->request->data);
        }
        // $businesses = $this->Deal->Business->find('list');
        // $this->set(compact('businesses'));
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
        if ($this->Deal->delete()) {
            $this->Session->setFlash(__('Deal deleted'));
            $this->redirect(array('/accounts/deals'));
        }
        $this->Session->setFlash(__('Deal was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}