<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *s
 * @property User $User
 */
class UsersController extends AppController {

/**
 * index method
 *
 * @return void
 */
 	public function beforeFilter() {
        parent::beforeFilter();
 		$this->Auth->allow('launch', 'logout', 'launch_submit', 'sign_up', 'login', 'ajax_login', 'businesses_sign_up');
 	}

    public function beforeRender() {
        parent::beforeRender();

    }

/**
 * index method
 *
 * @return void
 */
    public function index() {
        $this->set('title_for_layout', 'My Account - Make a deal, sell lots of Tea');
        $this->User->Address->recursive = -1;
        $addresses = $this->User->Address->findAllByUserId($this->Auth->user('id'));
        $this->set('addresses', $addresses);
    }	

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
    public function edit()
    {   
        $this->set('title_for_layout', 'Edit My Account - Make a deal, sell lots of Tea');

        $this->User->id = $this->Auth->user('id');

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['User']['id'] = $this->User->id;
            if ($this->User->saveAll($this->request->data)) {

                $this->Session->setFlash(__('Successfully Saved!'));
                $this->redirect(array('action' => 'index'));

            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            // debug($this->User->read(null, $this->User->id));
            $this->request->data = $this->User->read(null, $this->User->id);
            // debug($this->request->data);
        }
    }


	public function launch() {
        if($this->Auth->loggedIn() && $this->User->Deal->find('first', array('conditions' => array('Deal.is_live' => true)))){
            $this->redirect('/deals/view');
        }
        // $this->set('liveDeal')
		$this->layout = 'launch';
		$this->set('title_for_layout', 'Find and Buy Tea');
	}

	public function launch_submit() {
		$this->autoRender = false;
        sleep(.5);

        if (!empty($this->data)) {
            if (!$this->User->find('first', array('conditions' => array('User.email' => $this->data['User']['email'])))) {
                if ($this->User->save($this->data)) {
                	echo json_encode(array('success' => 'Thank You.'));
                } else {
                	$errors = $this->User->invalidFields();
                	echo json_encode(array('error' => $errors['email']));
                }
            } else {
                echo json_encode(array('success' => 'Thank You!'));
            }
        }
	}

    public function sign_up() {
    	if($this->Auth->loggedIn()){
			return $this->redirect($this->Auth->redirect());
		}

        $this->layout = 'stripped';
        if($this->RequestHandler->isPost()){
            if ($return = $this->User->saveAll($this->request->data)) {
                // debug($this->request->data); exit;
                // $email = new CakeEmail('gmail');
                // // $email->template('sign_up')
                // $email->from(array('team@drinkchai.com' => 'DrinkChai.com'))
                //     ->to($this->data['User']['email'])
                //     ->subject('Welcome to DrinkChai')
                //     ->send();
                $this->Auth->login();
                $this->redirect(array('controller' => 'deals', 'action' => 'view'));
            } else {
                // $errors = $this->User->invalidFields();
                // if($this->data['User']['password'] != $this->Auth->password($this->data['User']['password_confirm'])){
                //     $errors['password_confirm'] = "Passwords must match";
                // }
            }
        }
    }

    public function businesses_sign_up() {
        $this->set('title_for_layout', 'Make a deal, sell lots of Tea');
        $this->layout = 'stripped';

        if($this->request->is('post')) {
            $this->request->data['Business']['slug'] = strtolower(Inflector::slug($this->request->data['Business']['name']));
            $this->request->data['User']['user_type_id'] = 2;
            if($return = $this->User->saveAll($this->request->data)){
                // $email = new CakeEmail('gmail');
                // $email->from(array('me@example.com' => 'My Site'))
                //     ->to('sessa@drinkchai.com')
                //     ->subject('About')
                //     ->send('My message');

                $this->Auth->login();
                $this->redirect('/account');
            } else {
                
            }
        }
    }

	public function login() {
		if($this->Auth->loggedIn()){
			return $this->redirect('/deals/view');
		}

		$this->layout = 'stripped';
        $this->set('title_for_layout', 'Make a deal, sell lots of Tea');

		if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirect());
	        } else {
	            $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
	        }
	    }
    }

    function ajax_login() 
    { 
        $this->autoRender = false;
        if($this->RequestHandler->isAjax()){

            if($this->Auth->login()) {
                echo json_encode(array('url' => $this->Auth->redirect()));
            } else {
                $data = array('error' => $this->Auth->authError);
                echo json_encode($data);
            }
        }
    }

    public function logout() {
        // debug($this->facebook->getLogoutUrl()); exit;
        // $this->facebook = null;
        // $this->Auth->logout();
        // finally https://developers.facebook.com/docs/reference/php/facebook-getLogoutUrl/
        // $path = $this->Auth->logout();
        // $params = array('next'=> 'http//' . $_SERVER['HTTP_HOST'] . $path);
        // debug($params); 
        // $facebookLogout = $this->facebook->getLogoutUrl($params);
        // // debug($this->facebook->getLogoutUrl()); exit;
        // if ($facebookLogout) {
        //     $this->redirect($facebookLogout);
        // }
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }



// ADMINISTRATION ACTIONS

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$addresses = $this->User->Address->find('list');
		$this->set(compact('addresses'));
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
