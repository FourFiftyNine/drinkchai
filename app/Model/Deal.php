
<?php
App::uses('Model', 'Model');
/**
 * Deal Model
 *
 * @property Business $Business
 * @property Order $Order
 */
class Deal extends Model {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Business' => array(
            'className' => 'Business',
            'foreignKey' => 'business_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'deal_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'Image' => array(
            'className' => 'Image',
            'foreignKey' => 'deal_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
	);

	public $validate = array(
        'name' => array(
            'rule' => 'notEmpty'
        ),
        'product_name' => array(
            'rule' => 'notEmpty'
        ),
        // 'tagline' => array(
        //     'rule' => 'notEmpty' //TODO MESSAGE
        // ),
        'price' => array(
            'rule' => 'notEmpty'//TODO MESSAGE
        ),
        'original_price' => array(
            'rule' => 'notEmpty'
        ),
        'minimum' => array(
            'rule' => 'notEmpty'
        ),
        'limit' => array(
            'rule' => 'notEmpty'
        ),
        'product_description' => array(
            'rule' => 'notEmpty'
        ),
        'discount' => array(
            'rule' => 'notEmpty'
        ),
        'start' => array(
            'rule' => 'notEmpty'
        ),
        'end' => array(
            'rule' => 'notEmpty'
        ),
        'product_detail_1' => array(
            'rule' => 'notEmpty'
        ),
        'product_detail_2' => array(
            'rule' => 'notEmpty'
        ),
        'product_detail_3' => array(
            'rule' => 'notEmpty'
        )
    );

    public function beforeSave() {
        // $this->data['Business']['slug']   = Inflector::slug($this->data['Business']['name']);
        $this->data['Deal']['slug'] = Inflector::slug($this->data['Deal']['product_name']);
        // debug($this->data);
        return true;
    }

    public function afterSave()
    {
        // $this->Auth->user()

    }

    public function saveDeal($data) {
        // debug($data);
        // $this->Business->id = $data['Business']['id'];
            $data['Business']['slug']   = Inflector::slug($data['Business']['name']);
            $data['Deal']['slug']       = Inflector::slug($data['Deal']['name']);
                
        // $this->Business->save(
        //     array('Business.name' => 
        //     $data['Business']['name']),
        //     array('Business.id' => '3')
        // );
            parent::saveAll($data);
        
        // $this->Business
        // parent::saveAll($data);
    }
    public function getDealBySlug($company_slug, $deal_slug) {
        return $this->find('first', array('conditions' => array('Business.slug' => $company_slug, 'Deal.slug' => $deal_slug)));
        
    }
    
    public function getDealById($deal_id) {
        return $this->find('first', array('conditions' => array('Deal.id' => $deal_id)));
    }

}
