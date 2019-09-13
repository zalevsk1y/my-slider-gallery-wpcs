<?php
/**
 * Factory class creates instance of TemplateRender class
 *
 * @package Factories
 */

namespace My_Slider_Gallery;

use My_Slider_Gallery\Template_Render;

/**
 * Factory class creates instance of TemplateRender class
 *
 * PHP version 7.0
 *
 * @package  Factories
 * @author   Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license  MIT
 */
class Template_Factory {
	/**
	 * Getter for creating new instance
	 *
	 * @param string $template_path path to template file.
	 * @return Template_Render
	 */
	public static function get( string $template_path ) {
		return new Template_Render( $template_path );
	}
}
