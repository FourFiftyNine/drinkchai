<?php
App::uses('AppController', 'Controller');
/**
 * Images Controller
 *
 * @property Image $Image
 */
class ImagesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Image->recursive = 0;
		$this->set('images', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Image->id = $id;
		if (!$this->Image->exists()) {
			throw new NotFoundException(__('Invalid image'));
		}
		$this->set('image', $this->Image->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Image->create();
			if ($this->Image->save($this->request->data)) {
				$this->flash(__('Image saved.'), array('action' => 'index'));
			} else {
			}
		}
		$deals = $this->Image->Deal->find('list');
		$this->set(compact('deals'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Image->id = $id;
		if (!$this->Image->exists()) {
			throw new NotFoundException(__('Invalid image'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Image->save($this->request->data)) {
				$this->flash(__('The image has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$this->request->data = $this->Image->read(null, $id);
		}
		$deals = $this->Image->Deal->find('list');
		$this->set(compact('deals'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post') || !$this->RequestHandler->isAjax()) {
			throw new MethodNotAllowedException();
		}
		$this->Image->id = $id;

		if($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$this->RequestHandler->respondAs('json');
			$this->Image->set('deleted', true);
			if($return = $this->Image->save()) {
				return json_encode($return);
			} else {
				return json_encode(array('error' => 'Could not delete.'));
			}
			
		}

		if (!$this->Image->exists()) {
			throw new NotFoundException(__('Invalid image'));
		}

		if ($this->Image->delete()) {
			$this->flash(__('Image deleted'), array('action' => 'index'));
		}

		$this->flash(__('Image was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
