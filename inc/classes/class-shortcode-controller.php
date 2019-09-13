<?php
/**
 * Rest controller
 *
 * @package Rest
 */

namespace My_Slider_Gallery;

use My_Slider_Gallery\Post_Factory;
use My_Slider_Gallery\Errors;

/**
 * Rest controller
 * GET /my-gallery/v1/post/{post_id}/ return object with shortcodes
 * PATCH /my-gallery/v1/post/{post_id}/ replace or add shortcodes to post
 *
 * PHP version 7.0
 *
 * @package Rest
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */
class Shortcode_Controller {

	/**
	 * Namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'my-gallery/v1';
	/**
	 * Name of resource.
	 *
	 * @var string
	 */
	protected $resource_name = 'post';
	/**
	 * Post factory
	 *
	 * @var Post_Factory
	 */
	protected $factory;
	/**
	 * Init function.
	 *
	 * @param Post_Factory $factory Factory for Post_model class.
	 */
	public function __construct( Post_Factory $factory ) {
		$this->factory = $factory;
		$this->init();
	}
	/**
	 * Initialization.Add action for rest function registration.
	 *
	 * @return void
	 */
	protected function init() {
		add_action( 'rest_api_init', array( $this, 'register_routs' ) );
	}
	/**
	 * Register routes.
	 *
	 * @return void
	 */
	public function register_routs() {

		register_rest_route(
			$this->namespace,
			$this->resource_name . '/(?P<id>[\d]+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_shortcodes' ),
				'permission_callback' => array( $this, 'check_permission' ),
				'schema'              => array( $this, 'get_schema' ),
			)
		);
		register_rest_route(
			$this->namespace,
			$this->resource_name . '/(?P<id>[\d]+)',
			array(
				'methods'             => 'PATCH',
				'callback'            => array( $this, 'save_shortcodes' ),
				'permission_callback' => array( $this, 'check_permission_post_update' ),
				'schema'              => array( $this, 'get_schema' ),
				'args'                => array(
					'id' => array(
						'validate_callback' => function ( $param ) {
							return is_numeric( $param );
						},
					),
				),
			)
		);
	}
	/**
	 * Check if user have rights to read posts.
	 *
	 * @return WP_Error|bool
	 */
	public function check_permission() {
		if ( ! current_user_can( 'read' ) ) {
			return new \WP_Error( 'rest_forbidden', Errors::text( 'NO_RIGHTS_TO_READ' ) );
		}

		return true;
	}
	/**
	 * Check if user have rights to update posts.
	 *
	 * @param \WP_REST_Request $request Instance contains info about request.
	 * @return WP_Error|bool
	 */
	public function check_permission_post_update( \WP_REST_Request $request ) {
		$post_id = (int) $request['id'];

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return new \WP_Error( 'rest_forbidden', Errors::text( 'NO_RIGHTS_TO_WRITE' ) );
		}

		return true;
	}
	/**
	 * Get sample schema for posts list.
	 *
	 * @return array
	 */
	public function get_schema() {
		$schema = array(
			'$schema'     => 'http://json-schema.org/draft-04/schema#',
			'title'       => 'Posts',
			'description' => 'List of posts with ids',
			'type'        => 'object',
			'items'       => array(
				'type'       => 'object',
				'properties' => array(
					'postId'     => array(
						'description' => \esc_html__( 'post id', MYGALLERY_PLUGIN_SHORTCODE ),
						'type'        => 'integer',
					),
					'status'     => array(
						'description' => \esc_html__( 'status of shortcode (saved|draft|deleted)', MYGALLERY_PLUGIN_SHORTCODE ),
						'type'        => 'integer',
					),
					'shortcodes' => array(
						'description' => \esc_html__( 'Array of shortcodes object', MYGALLERY_PLUGIN_SHORTCODE ),
						'type'        => 'array',
						'properties'  => array(
							'code'          => array(
								'type' => 'object',
							),
							'images'        => array(
								'type' => 'array',
							),
							'settings'      => array(
								'type' => 'object',
							),
							'_originalCode' => array(
								'type' => 'string',
							),
						),
					),
				),
			),
		);
		return $schema;
	}
	/**
	 * Function gets array of shotcode objects.
	 *
	 * @param \WP_REST_Request $request Instance contains info about request.
	 * @return array
	 */
	public function get_shortcodes( \WP_REST_Request $request ) {
		$id        = $request['id'];
		$post_data = $this->extract_shortcode_data( $id );

		$response = $this->prepare_response( $post_data );
		return $response;
	}
	/**
	 * Saves shortcode to the post body.
	 *
	 * @param \WP_REST_Request $request WP class that deals with REST requests.
	 * @return bool|int
	 */
	public function save_shortcodes( \WP_REST_Request $request ) {
		$body = $request->get_body_params();

		$post_id      = (int) $request['id'];
		$post         = $this->get_post( $post_id );
		$escaped_data = $this->escape_shortcodes_array( json_decode( $body['shortcodes'] ) );
		$response     = $post->update_post_shortcodes( $escaped_data );
		return $response;
	}
	/**
	 * Escaping received data
	 *
	 * @param array $shortcodes array of shortcode string and status.
	 * @return strClass
	 */
	protected function escape_shortcodes_array( array $shortcodes ) {
		$escaped_data = [];
		foreach ( $shortcodes as $shortcode ) {
			$escaped_data[] = (object) array(
				'status' => esc_html( $shortcode->status ),
				'code'   => esc_html( $shortcode->code ),
			);
		}
		return $escaped_data;
	}
	/**
	 * Get shortcode data from post body.
	 *
	 * @param integer $id Post id.
	 * @return object
	 */
	protected function extract_shortcode_data( int $id ) {
		$post     = $this->get_post( $id );
		$response = $post->get_shortcode();
		return $response;
	}
	/**
	 * Post Factory facade.
	 *
	 * @param integer $post_id Post id.
	 * @return My_Slider_Gallery\Post_Model
	 */
	protected function get_post( int $post_id ) {
		return $this->factory->get( $post_id );
	}
	/**
	 * Decode response to json.
	 *
	 * @param object|array|boolean $post_data Data that should be send to user.
	 * @return string json
	 */
	protected function prepare_response( $post_data ) {

		return \json_encode( $post_data );
	}
}
