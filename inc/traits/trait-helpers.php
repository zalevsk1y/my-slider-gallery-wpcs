<?php
/**
 * Class load menu config file.
 *
 * @package Utils
 */

namespace My_Slider_Gallery;

/**
 * Misc helpers function s
 *
 * PHP version 7.0
 *
 * @package Traits
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */
trait Trait_Helpers {

	/**
	 * Convert boolean to string.
	 *
	 * @param boolean $var Boolean variable that should be converted to string.
	 * @return string
	 */
	public function bool_to_string( bool $var ) {
		return $var ? 'true' : 'false';
	}
	/**
	 * Remove square brackets.
	 *
	 * @param string $text String that should be rid from brackets.
	 * @return string
	 */
	protected function remove_brackets( string $text ) {
		$left_bracket  = '\x5b';
		$right_bracket = '\x5d';
		$pattern       = '/(' . $left_bracket . ')*(' . $right_bracket . ')*/i';
		return preg_replace( $pattern, '', $text );
	}
	/**
	 * Remove symbols that confused regexp functions.
	 *
	 * @param string $text String that should be rid from problem symbols.
	 * @return string
	 */
	protected function remove_problem_symbols( string $text ) {
		$pattern = '/(&quot;)/i';
		return \preg_replace( $pattern, '', $text );
	}
}
