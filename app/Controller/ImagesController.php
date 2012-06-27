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

  public function uploader($dealId = null) {
    if($this->RequestHandler->isAjax()) {
      $this->autoRender = false;
      $this->RequestHandler->respondAs('json');

      if( !$dealId ) {
        $dealId = $this->request->data['Deal']['id'];
      }
    $this->Uploader = new Uploader(array('overwrite' => false));
    // $data['success'] = false;
    if ($uploadedImateData = $this->Uploader->upload('Image.file')) {
      // debug('here');
      // $data['success'] = true;

      if ($return = $this->Image->saveUploadedImage($uploadedImateData, $dealId, $this->Uploader)) {
        // unset($this->request->data['Image']['file']);
        $mergedArray = array_merge($return['Image'], $this->request->data['Image']['file']);
        $cleanedArray = array_unique($mergedArray);

        // $return = $this->request->data['Image']['file'];
        return json_encode($cleanedArray);
        // return json_encode($this->request->data['Image']['file']);
      }

      // $dimensions = $this->Uploader->dimensions($data['path']);

      // if($dimensions['width'] > $dimensions['height']) {
      //     $resized_path = $this->Uploader->resize(array('width' => 330, 'quality' => 100));
      //     $thumb_path = $this->Uploader->resize(array('width' => 100, 'quality' => 100));
      // } else {
      //     $resized_path = $this->Uploader->resize(array('height' => 250, 'quality' => 100));
      //     $thumb_path = $this->Uploader->resize(array('height' => 100, 'quality' => 100));
      // }
      // $resized_dimensions = $this->Uploader->dimensions($resized_path);

      // // debug($resized_path);
      // // $this->request->data['Image'][0]['filename']       = $data['name'];
      // // $this->request->data['Image'][0]['mimetype']       = $data['type'];
      // // $this->request->data['Image'][0]['filesize']       = $data['filesize'];
      // // $this->request->data['Image'][0]['path']           = $data['path'];
      // // $this->request->data['Image'][0]['path_resized']   = $resized_path;
      // // $this->request->data['Image'][0]['path_thumb']     = $thumb_path;
      // // $this->request->data['Image'][0]['orig_width']     = $data['width'];
      // // $this->request->data['Image'][0]['orig_height']    = $data['height'];
      // // $this->request->data['Image'][0]['resized_width']  = $resized_dimensions['width'];
      // // $this->request->data['Image'][0]['resized_height'] = $resized_dimensions['height'];

      // $imageModelData['Image'][0]['filename']       = $data['name'];
      // $imageModelData['Image'][0]['mimetype']       = $data['type'];
      // $imageModelData['Image'][0]['filesize']       = $data['filesize'];
      // $imageModelData['Image'][0]['path']           = $data['path'];
      // $imageModelData['Image'][0]['path_resized']   = $resized_path;
      // $imageModelData['Image'][0]['path_thumb']     = $thumb_path;
      // $imageModelData['Image'][0]['orig_width']     = $data['width'];
      // $imageModelData['Image'][0]['orig_height']    = $data['height'];
      // $imageModelData['Image'][0]['resized_width']  = $resized_dimensions['width'];
      // $imageModelData['Image'][0]['resized_height'] = $resized_dimensions['height'];
   

      
    }
    $data['success'] = false;
    return json_encode($data);
    // debug('here 2');
    // $data['result'] = true;
    
    }
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
