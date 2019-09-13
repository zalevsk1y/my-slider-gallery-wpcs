<?php
/**
 * Operates with WP post content.
 *
 * @package Models
 */

namespace My_Slider_Gallery;

use My_Slider_Gallery\My_Exception;
use My_Slider_Gallery\Shortcode_Factory;
use My_Slider_Gallery\Error;

/**
 * Operates with WP post content.
 *
 * PHP version 7.0
 *
 * @package Models
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */
class Post_Model {

	/**
	 * RegExp pattern to get shortcode name.
	 *
	 * @var string
	 */
	protected $shortcode_pattern = '/(?<shortcodes>\[my\-gallery.*\])/U';
	/**
	 * Id of post.
	 *
	 * @var int
	 */
	protected $post_id;
	/**
	 * WP_Post instance.
	 *
	 * @var object
	 */
	protected $post;
	/**
	 * Post body.
	 *
	 * @var string
	 */
	protected $post_body;
	/**
	 * Array of post shortcodes.
	 *
	 * @var array
	 */
	protected $shortcodes;
	/**
	 * Factory of shortcode classes.
	 *
	 * @var Shortcode_Factory
	 */
	protected $factory;
	/**
	 * Init function.
	 *
	 * @param integer           $post_id Id of post.
	 * @param Shortcode_Factory $factory Factory of shortcode classes.
	 */
	public function __construct( int $post_id, Shortcode_Factory $factory ) {
		$this->post_id = $post_id;
		$this->factory = $factory;
		$this->init();
	}
	/**
	 * Initialization
	 *
	 * @return void
	 * @throws My_Exception If there is no post with such id.
	 */
	protected function init() {
		$this->post = get_post( $this->post_id, 'OBJECT' );
		if ( is_null( $this->post ) ) {
			throw new My_Exception( Error::text( 'NO_SUCH_POST' ) );
		}

		$this->post_body  = $this->post->post_content;
		$this->shortcodes = $this->parse_shortcodes();
	}
	/**
	 * Getter for postId
	 *
	 * @return int
	 */
	public function post_id() {
		return $this->post_id;
	}
	/**
	 * Get array of shortcodes.
	 *
	 * @param integer $index Shortcode index in array.
	 * @return array
	 */
	public function get_shortcode( int $index = -1 ) {
		if ( 0 === count( $this->shortcodes ) ) {
			return array();
		}

		if ( -1 === $index ) {
			return $this->shortcodes;
		}

		return isset( $this->shortcodes[ $index ] ) ? array( $this->shortcodes[ $index ] ) : array();
	}
	/**
	 * Parse shorcodes from post content.Not using  do_shortcode( $content ) because
	 * it is not flexible no filters that allow to change regexp patterns.
	 *
	 * @return array
	 */
	protected function parse_shortcodes() {
		if ( ! isset( $this->post_body ) ) {
			return array();
		}

		preg_match_all( $this->shortcode_pattern, $this->post_body, $matches );
		if ( 0 === count( $matches['shortcodes'] ) ) {
			return array();
		}
		$shortcodes = array();
		foreach ( $matches['shortcodes'] as $item ) {
			$shortcode_item          = $this->get_shotcode_model( $item )->to_object();
			$shortcode_item->post_id = $this->post_id;
			$shortcode_item->status  = 'saved';
			$shortcodes[]            = $shortcode_item;
		}
		return $shortcodes;
	}
	/**
	 * Update post shortcodes.
	 *
	 * @param array $shortcodes Array of shortcodes object.
	 * @return integer post id
	 */
	public function update_post_shortcodes( array $shortcodes ) {
		preg_match_all( $this->shortcode_pattern, $this->post_body, $matches );
		foreach ( $shortcodes as $key => $shortcode ) {
			switch ( $shortcode->status ) {
				case 'changed':
					$this->post_body = str_replace( $matches['shortcodes'][ $key ], $shortcode->code, $this->post_body );
					break;
				case 'draft':
					$this->post_body .= '<!-- wp:shortcode -->' . PHP_EOL . $shortcode->code . PHP_EOL . '<!-- /wp:shortcode -->';
					break;
				case 'deleted':
					$this->post_body = str_replace( $matches['shortcodes'][ $key ], '', $this->post_body );
					$this->post_body = str_replace( '<!-- wp:shortcode -->' . PHP_EOL . PHP_EOL . '<!-- /wp:shortcode -->', '', $this->post_body );
					break;
			}
		}
		return $this->update_post();
	}
	/**
	 * Facade for wp_update_post function.
	 *
	 * @return integer|null
	 */
	protected function update_post() {
		$post_array = [
			'ID'           => $this->post_id,
			'post_content' => $this->post_body,
		];
		return \wp_update_post( $post_array );
	}
	/**
	 * ShortcodeFactory facade.
	 *
	 * @param string $code shortcode.
	 * @return My_Slider_Gallery\Shortcode_Model
	 */
	protected function get_shotcode_model( string $code ) {

		return $this->factory->get( $code );
	}
}
