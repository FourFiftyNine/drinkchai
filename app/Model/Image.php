<?php 
App::uses('Model', 'Model');
// CakePlugin::load('Uploader');
// App::import('Vendor', 'Uploader.Uploader');

/**
 * Image Model
 *
 */
class Image extends Model {

  // public $actsAs = array( 
  //   'Uploader.Attachment' => array(
  //     'fileName' => array(
  //       'name'    => 'formatFileName',  // Name of the function to use to format filenames
  //       'baseDir' => '',      // See UploaderComponent::$baseDir
  //       'uploadDir' => '',      // See UploaderComponent::$uploadDir
  //       'dbColumn'  => 'filename',  // The database column name to save the path to
  //       'importFrom'  => '',      // Path or URL to import file
  //       'defaultPath' => '',      // Default file path if no upload present
  //       'maxNameLength' => 30,      // Max file name length
  //       'overwrite' => true,    // Overwrite file with same name if it exists
  //       'stopSave'  => true,    // Stop the model save() if upload fails
  //       'allowEmpty'  => true,    // Allow an empty file upload to continue
  //       'transforms'  => array(),   // What transformations to do on images: scale, resize, etc
  //       's3'    => array(),   // Array of Amazon S3 settings
  //       'metaColumns' => array(   // Mapping of meta data to database fields
  //         'ext' => '',
  //         'type' => '',
  //         'size' => '',
  //         'group' => '',
  //         'width' => '',
  //         'height' => '',
  //         'filesize' => ''
  //       )
  //     )
  //   )
  // );

  public $belongsTo = array(
    'Deal' => array(
      'className' => 'Deal',
      'foreignKey' => 'deal_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    )
  );

  // public function beforeSave() {
  //   debug('bs'); exit;
  // }


  public function saveUploadedImage($imageData, $dealId, $businessId, $Uploader, $isLogo) {
    // var $data = 
    // $data['Image']['deal_id'] = $dealId;
    $imageModelData = array();
    $imagePath = $imageData['path'];
    $imageExt = $Uploader::ext($imagePath);

    // return array('error' => true, 'ext' => $imageExt);
    // if ($imageData)

    $dimensions = $Uploader->dimensions($imagePath);

    if($dimensions['width'] > $dimensions['height']) {
        $resized_path = $Uploader->crop(array('width' => 330, 'height' => 250, 'quality' => 100));
        $thumb_path = $Uploader->resize(array('width' => 100, 'quality' => 100));
    } else {
        $resized_path = $Uploader->crop(array('height' => 250, 'width' => 330, 'quality' => 100));
        $thumb_path = $Uploader->resize(array('height' => 100, 'quality' => 100));
    }
    $resized_dimensions = $Uploader->dimensions($resized_path);

    $imageModelData['Image']['filename']       = $imageData['name'];
    $imageModelData['Image']['mimetype']       = $imageData['type'];
    $imageModelData['Image']['filesize']       = $imageData['filesize'];
    $imageModelData['Image']['path']           = $imagePath;
    $imageModelData['Image']['path_resized']   = $resized_path;
    $imageModelData['Image']['path_thumb']     = $thumb_path;
    $imageModelData['Image']['orig_width']     = $imageData['width'];
    $imageModelData['Image']['orig_height']    = $imageData['height'];
    $imageModelData['Image']['resized_width']  = $resized_dimensions['width'];
    $imageModelData['Image']['resized_height'] = $resized_dimensions['height'];
    
    $imageModelData['Image']['deal_id'] = $dealId;
    $imageModelData['Image']['business_id'] = $businessId;
    // DELETE OLD LOGOS
    $imageModelData['Image']['is_logo'] = $isLogo;
    
    return parent::save($imageModelData);

    // return $imageModelData;

  }
}
