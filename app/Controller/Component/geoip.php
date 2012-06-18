<?php
/**
 * GeoipComponent for CakePHP 1.x.
 *
 * @file .app/controllers/components/geoip.php
 */
class GeoIPComponent extends Object {
	// attributes

	var $gi = null; // object reference

	// callbacks

	function initialize() {
		$settings = array(
			'res' => APP . WEBROOT_DIR . DS . 'GeoIP.dat', // absolute path
			'src' => 'geoip.inc', // just the file name
		);
		App::import('Vendor', 'GeoIP', array('file' => $settings['src']));
		$this->gi = geoip_open($settings['res'], GEOIP_STANDARD);
	}

	function shutdown() {
		geoip_close($this->gi); // cleanup
	}

	// methods

	function countryCode($address = null) {
		return geoip_country_code_by_addr($this->gi, $address);
	}

	function countryName($address = null) {
		return geoip_country_name_by_addr($this->gi, $address);
	}
}
