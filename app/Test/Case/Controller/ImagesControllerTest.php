<?php
App::uses('ImagesController', 'Controller');

/**
 * TestImagesController *
 */
class TestImagesController extends ImagesController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * ImagesController Test Case
 *
 */
class ImagesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.image', 'app.deal', 'app.user', 'app.business', 'app.address', 'app.order');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Images = new TestImagesController();
		$this->Images->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Images);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {

	}
/**
 * testView method
 *
 * @return void
 */
	public function testView() {

	}
/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}
/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {

	}
/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}
/**
 * testAccountIndex method
 *
 * @return void
 */
	public function testAccountIndex() {

	}
/**
 * testAccountView method
 *
 * @return void
 */
	public function testAccountView() {

	}
/**
 * testAccountAdd method
 *
 * @return void
 */
	public function testAccountAdd() {

	}
/**
 * testAccountEdit method
 *
 * @return void
 */
	public function testAccountEdit() {

	}
/**
 * testAccountDelete method
 *
 * @return void
 */
	public function testAccountDelete() {

	}
}
