<?php
use My_Slider_Gallery\Posts_List_Controller;

class Posts_List_Controller_Test extends \WP_UnitTestCase
{
protected $server;
protected $namespaced_route = '/my-gallery/v1';
public function setUp() {
    parent::setUp();
 
    global $wp_rest_server;
    wp_set_current_user($this->factory->user->create([
        'role' => 'administrator',
    ]));
    $this->server = $wp_rest_server = new \WP_REST_Server;
    do_action( 'rest_api_init' );
    $this->factory()->post->create_many(10);

}
public function test_registered_routs(){
    $routes=$this->server->get_routes();
    
    $this->assertArrayHasKey($this->namespaced_route,$routes);
}
public function test_end_points(){
    $the_route = $this->namespaced_route;
	$routes = $this->server->get_routes();
    foreach( $routes as $route => $route_config ) {
        if( 0 === strpos( $the_route, $route ) ) {
            $this->assertTrue( is_array( $route_config ) );
            foreach( $route_config as $i => $endpoint ) {
                
                $this->assertArrayHasKey( 'callback', $endpoint );
                $this->assertArrayHasKey( 0, $endpoint[ 'callback' ], get_class( $this ) );
                $this->assertArrayHasKey( 1, $endpoint[ 'callback' ], get_class( $this ) );
                $this->assertTrue( is_callable( array( $endpoint[ 'callback' ][0], $endpoint[ 'callback' ][1] ) ) );
                }
            }
        }
    }
    public function test_posts_list_route(){
        $request  = new WP_REST_Request( 'GET', '/my-gallery/v1/posts-list/date/desc' );
        $response = $this->server->dispatch( $request );
        $this->assertEquals( 200, $response->get_status() );
		$data = $response->get_data();
		$this->assertCount(10,json_decode($data));
    }
}