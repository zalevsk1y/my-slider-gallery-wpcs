<?php
/**
 * Parsing config parameters from integer
 *
 * @package Traits
 */

namespace My_Slider_Gallery;

/**
 * Parsing config parameters from integer
 *
 * PHP version 7.0
 *
 * @package Traits
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */
trait Trait_Config_Parse {

	/**
	 * Create config object from parsed data.
	 *
	 * @param integer $config_code code of config params.
	 * @return object
	 */
	protected function set_config( int $config_code ) {

		$configs = preg_split( '//u', $config_code, null, PREG_SPLIT_NO_EMPTY );
		return (object) array(
			'galleryMode'  => (bool) $configs[0],
			'loop'         => (bool) $configs[1],
			'thumbsNumber' => $configs[2],
			'items'        => $configs[3],
		);
	}
}
