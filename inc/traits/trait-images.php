<?php
/**
 * Get image urls and creates object
 *
 * @package Traits
 */

namespace My_Slider_Gallery;

/**
 * Get image urls and creates object
 *
 * PHP version 7.0
 *
 * @package Traits
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */
trait Trait_Images {

	/**
	 * Creates object with image ids and urls.
	 *
	 * @param array        $image_ids Array of image ids.
	 * @param string|array $size Size of images could be a string or array.
	 * @return object
	 */
	protected function create_image_object( array $image_ids, $size = 'thumbnail' ) {
		$image = array();
		foreach ( $image_ids as $image_id ) {
			$image_url = $this->get_image_url( (int) $image_id, $size );
			if ( $image_url ) {
				$image[] = (object) array(
					'id'  => $image_id,
					'url' => $image_url,
				);
			}
		}
		return $image;
	}
	/**
	 * Get image url using wp_get_attachment_image_src() function.
	 *
	 * @param integer      $id Id of image.
	 * @param string|array $size Size of images could be a string or array.
	 * @return object|boolean
	 */
	protected function get_image_url( int $id, $size = 'thumbnail' ) {
		$image = array();
		if ( 'string' === gettype( $size ) ) {
			$image_url = wp_get_attachment_image_src( $id, $size );
			return $image_url[0];
		} elseif ( 'array' === gettype( $size ) ) {
			foreach ( $size as $size_name ) {
				$image[ $size_name ] = wp_get_attachment_image_src( $id, $size_name );
			}
			return (object) $image;
		}
		return false;
	}
}
