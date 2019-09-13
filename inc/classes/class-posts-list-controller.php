<?php
/**
 * Rest controller
 *
 * @package Rest
 */

namespace My_Slider_Gallery;

use My_Slider_Gallery\Errors;

/**
 * Rest controller
 * GET /my-gallery/v1/post-list/{order_by}/{order} return list of posts (titles & post_id)
 *
 * PHP version 7.0
 *
 * @package Rest
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */
class Posts_List_Controller {

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
	protected $resource_name = 'posts-list';
	/**
	 * Init function.
	 */
	public function __construct() {
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
			$this->resource_name . '/(?P<order_by>[a-z]+)' . '/(?P<order>desc|asc)',
			array(
				'method'              => 'GET',
				'callback'            => array( $this, 'get_posts_list' ),
				'permission_callback' => array( $this, 'check_permission' ),
				'schema'              => array( $this, 'get_schema' ),
				'args'                => array(
					'id'    => array(
						'description'       => 'post id',
						'type'              => 'integer',
						'validate_callback' => function ( $param ) {
							return is_numeric( $param );
						},
					),
					'title' => array(
						'description' => 'post title',
						'type'        => 'string',
					),
				),
			)
		);
	}
	/**
	 * Check if user have rights to read posts.
	 *
	 * @return \WP_Error|bool
	 */
	public function check_permission() {

		if ( ! current_user_can( 'read' ) ) {
			return new \WP_Error( 'rest_forbidden', Errors::text( 'NO_RIGHTS_TO_READ' ) );
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
					'title' => array(
						'description' => 'post title',
						'type'        => 'string',
					),
					'id'    => array(
						'description' => 'post id',
						'type'        => 'integer',
					),
				),
			),
		);
		return $schema;
	}
	/**
	 * Get List of posts.
	 *
	 * @param \WP_REST_Request $request Instance contains info about request.
	 * @return int|bool
	 */
	public function get_posts_list( \WP_REST_Request $request ) {
		$order    = $request['order'];
		$order_by = $request['order_by'];

		$args = array(
			'author'         => get_current_user_id(),
			'orderby'        => $order_by,
			'order'          => $order,
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'pending', 'draft', 'future' ),

		);
		$posts    = get_posts( $args );
		$response = $this->prepare_response( $posts );
		return $response;
	}
	/**
	 * Prepare object of post titles.
	 *
	 * @param array $posts Array of WP_Post objects.
	 * @return string json
	 */
	protected function prepare_response( array $posts ) {
		$response = array();
		foreach ( $posts as $post ) {
			$response[] = array(
				'id'    => $post->ID,
				'title' => $post->post_title,
			);
		}
		return \json_encode( $response );
	}
}
