<?php
/**
 * Factory class creates instance of PostModel class.
 *
 * @package Factories
 */

namespace My_Slider_Gallery;

use My_Slider_Gallery\Shortcode_Model;

/**
 * Factory class creates instance of Shortcode_Model class
 *
 * PHP version 7.0
 *
 * @package  Factories
 * @author   Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license  MIT
 */
class Shortcode_Factory {
	/**
	 * Default settings for gallery.
	 *
	 * @var \stdClass
	 */
	public static $default_settings;
	/**
	 * Init function.Set default settings for shortcode parameters.
	 *
	 * @param \stdClass $settings default settings for gallery.
	 */
	public function __construct( \stdClass $settings ) {
		self::$default_settings = $settings;
	}
	/**
	 * Getter for creating new instance.
	 *
	 * @param string $code shortcode.
	 * @return Shortcode_Model
	 */
	public function get( string $code ) {
		if ( self::$default_settings ) {
			return new Shortcode_Model( $code, self::$default_settings );
		}
	}
}
