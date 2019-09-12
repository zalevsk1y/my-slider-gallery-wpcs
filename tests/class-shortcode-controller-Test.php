<?php

class Shortcode_Controller_Test extends \WP_UnitTestCase
{
    protected $server;
    protected $namespaced_route = '/my-gallery/v1';
    protected $post_id;
    public function setUp()
    {
        parent::setUp();

        global $wp_rest_server;
        wp_set_current_user($this->factory->user->create([
            'role' => 'administrator',
        ]));
        $this->server = $wp_rest_server = new \WP_REST_Server;
        do_action('rest_api_init');
        $this->post_id = $this->factory()->post->create(['post_title' => 'Test post', 'post_content' => '[my-gallery ids=434,232,435 title="New test" config=11611]']);

    }
    public function test_registered_routs()
    {
        $routes = $this->server->get_routes();

        $this->assertArrayHasKey($this->namespaced_route, $routes);
    }

    public function test_get_post_route()
    {
        $request = new WP_REST_Request('GET', '/my-gallery/v1/post/' . $this->post_id);
        $response = $this->server->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $data = json_decode($response->get_data(), true);
        $this->assertCount(1, $data);
        $this->assertArrayHasKey('post_id', $data[0]);
        $this->assertArrayHasKey('status', $data[0]);
        $this->assertArrayHasKey('code', $data[0]);
        $this->assertEquals($data[0]['post_id'], $this->post_id);
      
        $this->assertEquals($data[0]['status'], 'saved');
    }
    public function test_patch_post_route()
    {
        $request = new WP_REST_Request('PATCH','/my-gallery/v1/post/' . $this->post_id);
        $code='[my-gallery ids=1,2,3 title=&quot;New test1&quot; config=11611]';
        $encoded_shortcode=json_encode(array(array(
                        'status'=>'changed',
                        'code'=>$code
                    )));
        $body="shortcodes=".rawurlencode($encoded_shortcode);
            
        $request->set_body($body);
        $response = $this->server->dispatch($request);
        $this->assertEquals(200, $response->get_status());
        $post=get_post($this->post_id);
        $this->assertEquals($post->post_content,$code);
    }

}
