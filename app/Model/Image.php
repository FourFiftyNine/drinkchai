<?php
App::uses('Model', 'Model');
CakePlugin::load('MeioUpload');
/**
 * Image Model
 *
 * @property Deal $Deal
 */
class Image extends Model {

  //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
  public $belongsTo = array(
    'Deal' => array(
      'className' => 'Deal',
      'foreignKey' => 'deal_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    )
  );
  var $name = 'Image';
  var $actsAs = array(
          'MeioUpload.MeioUpload' => array('filename' => array(
            'dir' => 'uploads/image/'

          ))
      );
}
