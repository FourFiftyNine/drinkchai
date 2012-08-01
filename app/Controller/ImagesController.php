<?php
App::uses('AppController', 'Controller');
CakePlugin::load('Uploader');
App::import('Vendor', 'Uploader.Uploader');

/**
 * Images Controller
 *
 * @property Image $Image
 */
class ImagesController extends AppController {

  public function beforeFilter(){
      parent::beforeFilter();
      $this->Auth->allow('uploadify');
      // $this->Auth->allow('index',  'view', 'delete', 'edit');
  }
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

  public function uploader($dealId = null, $businessId = null) {
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false;
      $this->RequestHandler->respondAs('json');

      if( !$dealId ) {
        $dealId = $this->request->data['Deal']['id'];
      }
      if( !$businessId ) {
        $businessId = $this->request->data['Business']['id'];
      }

      $this->Uploader = new Uploader(array(
        'overwrite' => false, 
        'extension'  => array(
          'value' => array('gif', 'jpg', 'png', 'jpeg')
          )
        ));

      $return = array();
      $uploadInput = ($this->request->data['Image']['file']) ? 'Image.file' : 'Image.logo';
      $imageType = $this->request->data['Image']['logo'] ? 'logo' : 'product';

      if ($uploadedImageData = $this->Uploader->upload($uploadInput)) {
        $this->Image->deleteAll(array('Image.business_id' => $businessId, 'Image.type' => $imageType));

        if ($return = $this->Image->saveUploadedImage($uploadedImageData, $dealId, $businessId, $this->Uploader, $imageType)) {
          $this->Image->deleteAll(array('Image.business_id' => $businessId, 'Image.type' => $imageType, 'Image.id !=' => $return['Image']['id']));
          // TODO CLEANUP?
          return json_encode($return);
        } else {
          return json_encode(array(
            'error' => 'There was an error processing: <span class="filename">' . $uploadedImageData['name'] . '</span> Please make sure it is a jpeg, jpg, or png file.'
            ));
        }
      }

    }
  }

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
  public function feature($id = null) {
    if (!$this->request->is('post') || !$this->RequestHandler->isAjax()) {
      throw new MethodNotAllowedException();
    }

    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false;
      $this->RequestHandler->respondAs('json');
      $featuredImageData = $this->Image->findByFeatured(true);
      // debug($featuredImageData); exit;
      // return json_encode($featuredImageData);
      $this->Image->id = $featuredImageData['Image']['id'];
      $this->Image->set('featured', false);
      // $featuredImageData['Image']['featured'] = false;
      $this->Image->save();

      $this->Image->id = $id;
      $this->Image->set('featured', true);
      if($return = $this->Image->save()) {
        return json_encode($return);
      } else {
        return json_encode(array('error' => 'Could not feature'));
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

/**
 * manage method
 *
 * @param string $id
 * @return void
 */
  // public function manage($id = null) {
  //   if(!$id) {
  //     $this->redirect('/account/deals');
  //   }
  // }

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
