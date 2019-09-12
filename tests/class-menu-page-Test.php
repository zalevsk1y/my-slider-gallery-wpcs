<?php
use My_Slider_Gallery\Menu_Page;
use My_Slider_Gallery\Menu_Config;

/**
 * class MenuPageTest
 *
 * @package MyGallery
 */

class Menu_Page_Test extends \WP_UnitTestCase
{
    protected $config_path;
    public function setUp()
    {

        parent::setUp();
        $this->config_path = __DIR__ . '/../menu-config.php';
        wp_set_current_user($this->factory->user->create([
            'role' => 'administrator',
        ]));


    }
    public function test_add_main_menu()
    {
        $menu_config = new Menu_Config($this->config_path);
        $instance = new Menu_Page($menu_config);
        $instance->add_main_menu();
        $menu_slug = MYGALLERY_PLUGIN_SLUG . '-main-menu';
        $this->assertNotEmpty(menu_page_url($menu_slug, false));

    }
}
