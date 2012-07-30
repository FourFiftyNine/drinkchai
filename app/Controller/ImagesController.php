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
          'value' => array('gif', 'jpg', 'png', 'jpeg'),
          'error' => 'Filetype incorrect' // not working
          )
        ));
      $return = array();
      $uploadInput = ($this->request->data['Image']['file']) ? 'Image.file' : 'Image.logo';
      $isLogo = $this->request->data['Image']['logo'] ? true : false;

      if ($uploadedImateData = $this->Uploader->upload($uploadInput)) {

        if ($return = $this->Image->saveUploadedImage($uploadedImateData, $dealId, $businessId, $this->Uploader, $isLogo)) {

          // TODO CLEANUP?
          return json_encode($return);
          if( !isset($return['error'])) {
            return json;
          }

          $mergedArray = array_merge($return['Image'], $this->request->data['Image']['file']);
          $mergedArray = array_merge($return['Image'], $this->request->data['Image']['logo']);
          $cleanedArray = array_unique($mergedArray);


          return json_encode($cleanedArray);
        }
      }
      return json_encode(array(
        'error' => 'There was an error processing: <span class="filename">' . $this->request->data['Image']['file']['name'] . '</span><br>Please make sure it is a jpeg, jpg, or png file.'
        ));
    }
  }

  public function uploadLogo($dealId = null, $businessId = null) {
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false;
      $this->RequestHandler->respondAs('json');

      if( !$businessId ) {
        $businessId = $this->request->data['Business']['id'];
      }
      debug($this->request->data);

      if( !$dealId ) {
        $dealId = $this->request->data['Deal']['id'];
      }

      $this->Uploader = new Uploader(array(
        'overwrite' => false, 
        'extension'  => array(
          'value' => array('gif', 'jpg', 'png', 'jpeg'),
          'error' => 'Filetype incorrect' // not working
          )
        ));
      
      $return = array();
      if ($uploadedImateData = $this->Uploader->upload('Image.logo')) {

        if ($return = $this->Image->saveUploadedImage($uploadedImateData, $businessId, $this->Uploader)) {
          return json_encode($return);
          if( !isset($return['error'])) {
            return json;
          }

          $mergedArray = array_merge($return['Image'], $this->request->data['Image']['logo']);
          $cleanedArray = array_unique($mergedArray);

          // unset($this->request->data['Image']['file']);

          return json_encode($cleanedArray);
        }
      }
      return json_encode(array(
        'error' => 'There was an error processing: <span class="filename">' . $this->request->data['Image']['file']['name'] . '</span><br>Please make sure it is a jpeg, jpg, or png file.'
        ));
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
