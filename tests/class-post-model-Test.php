<?php
use My_Slider_Gallery\Post_Model;
use My_Slider_Gallery\Shortcode_Factory;

/**
 * Class PostModelTest
 *
 * @package MyGallery
 */

class Post_Model_Test extends \WP_UnitTestCase
{
    public $new_shortcode='[my-gallery ids=434,232,435 title="New test" config=11611]';
    public $shortcode='[my-gallery ids=434,232 title="Test" config=11111]';
    public function setUp()
    {
        parent::setUp();
        $this->settings = include 'mock/defaultGallerySettings.php';

    }
    public function test_get_shortcodes()
    {
        $shortcode = $this->get_new_post($this->shortcode)->get_shortcode();
        $this->assertCount(1, $shortcode);
        $this->assertInstanceOf(stdClass::class, $shortcode[0]);
    }
    /**
     * @dataProvider code_data
     */
    public function test_update_post_shortcodes($code,$expected)
    {

        $post_instance = 'draft'===$code->status?$this->get_new_post():$this->get_new_post($this->shortcode);

      
        $post_instance->update_post_shortcodes(array($code));
        $post = get_post($post_instance->post_id());

        $this->assertEquals($expected, $post->post_content);
    }
    public function code_data()
    {   $new_shortcode=$this->new_shortcode;
        $shortcode=$this->shortcode;
        return [
            [(object) array(
                'code' => $new_shortcode,
                'status' => 'changed',
            ), $new_shortcode],
            [(object) array(
                'code' => $new_shortcode,
                'status' => 'draft',
            ), '<!-- wp:shortcode -->' . PHP_EOL . $new_shortcode . PHP_EOL . '<!-- /wp:shortcode -->'],
            [(object) array(
                'code' => $shortcode,
                'status' => 'deleted',
            ), ''],
        ];
    }

    protected function get_new_post($post_content='')
    {
        $post_id = $this->factory()->post->create(['post_title' => 'Test post', 'post_content' => $post_content]);
        $shortcode_factory= new Shortcode_Factory(require MYGALLERY_PLUGIN_DIR.'defaultGallerySettings.php');
        return new Post_Model($post_id, $shortcode_factory);
    }
 
}
