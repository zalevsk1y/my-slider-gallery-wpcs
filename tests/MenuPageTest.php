<?php
use MyGallery\Menu\Admin\MenuPage;
use MyGallery\Utils\MenuConfig;

/**
 * class MenuPageTest
 *
 * @package MyGallery
 */

class MenuPageTest extends \WP_UnitTestCase
{
    protected $configPath;
    public function setUp()
    {

        parent::setUp();
        $this->configPath = __DIR__ . '/../menu-config.php';
        wp_set_current_user($this->factory->user->create([
            'role' => 'administrator',
        ]));


    }
    public function testAddMainMenu()
    {
        $menu_config = new MenuConfig($this->configPath);
        $instance = new MenuPage($menu_config);
        $instance->addMainMenu();
        $menu_slug = MYGALLERY_PLUGIN_SLUG . '-main-menu';
        $this->assertNotEmpty(menu_page_url($menu_slug, false));

    }
}
