<?php
use My_Slider_Gallery\Shortcode_Model;

/**
 * Class Shortcode_Model_Test
 *
 * @package MyGallery
 */
class Default_Settings
{
    protected static $settings;
    public static function get()
    {
        if (isset(self::$settings)) {
            return self::$settings;
        }
        self::$settings = include 'mock/defaultGallerySettings.php';
        return self::$settings;
    }
}
class Shortcode_Model_Test extends \WP_UnitTestCase
{
    protected $default_settings;
    public function setUp()
    {
        // before
        parent::setUp();
        $this->default_settings = Default_Settings::get();
        $this->factory()->attachment->create_many(5);

    }
    /**
     * @dataProvider code_ids_parsing
     */
    public function test_to_object_ids_parsing($code, $expected)
    {

        $instance = new Shortcode_Model($code, $this->default_settings);
        $result = $instance->to_object();
        $this->assertEquals($expected, $result->code->ids);
    }
    /**
     * @dataProvider code_title_parsing
     */
    public function test_to_object_title_parsing($code, $expected)
    {
        $instance = new Shortcode_Model($code, $this->default_settings);
        $result = $instance->to_object();
        $this->assertEquals($expected, $result->code->misc);
    }
    /**
     * @dataProvider code_config_parsing
     */
    public function test_to_object_config_parsing($code, $expected)
    {
        $instance = new Shortcode_Model($code, $this->default_settings);
        $result = $instance->to_object();
        $this->assertEquals($expected, $result->code->misc);
    }
 
    public function code_ids_parsing()
    {
        return [
            ['[my-gallery ids=3,3,4,5,4,1]', 'ids=3,3,4,5,4,1'],
            ['[my-gallery ids="3,1,12,1"]', 'ids=3,1,12,1'],
        ];
    }
    public function code_title_parsing()
    {
        return [
            ['[my-gallery ids=3,3,4,5,4,1 title="Test title" ]', 'title="Test title"'],
            ['[my-gallery ids="3,1,12,1" title=&quot;Test title&quot;]', 'title="Test title"'],
        ];
    }
    public function code_config_parsing()
    {
        return [
            ['[my-gallery ids=3,3,4,5,4,1 title="Test title" config=1161 ]', 'title="Test title" config=1161'],
            ['[my-gallery ids="3,1,12,1"  config=1161 title=&quot;Test title&quot;]', 'title="Test title" config=1161'],
        ];
    }
  

}
