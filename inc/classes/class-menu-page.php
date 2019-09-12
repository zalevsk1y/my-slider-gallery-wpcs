<?php
namespace My_Slider_Gallery;

use My_Slider_Gallery\Interface_Menu_Page;
use My_Slider_Gallery\Menu_Config;
use My_Slider_Gallery\Trait_Template_Factory_Facade;

/**
 * Class renders menu page.
 *
 * PHP version 7.0
 *
 * @package Menu
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */

class Menu_Page implements Interface_Menu_Page
{
    /**
     * Trait adds get_template() method.
     */
    use Trait_Template_Factory_Facade;
    /**
     * Object of menu configuration class that holds menu configs.
     *
     * @var object
     */
    protected $config;
    /**
     * Init function.
     *
     * @param Menu_Config $config Object stdClass that holds menu configs.
     */
    public function __construct(Menu_Config $config)
    {
        $this->init($config);
    }
    /**
     * Initiate and add menu configuration file.
     *
     * @return void
     */
    public function init(Menu_Config $config)
    {
        $config_object=$config->get();
        if (!is_object($config_object)) {
            throw new Exception('Wrong config data format.Should be instance of stdClass');
        }
        $this->config = $config_object;
        \add_action('admin_menu', array($this, 'add_main_menu'));
    }
    /**
     * Callback for "admin_menu" action
     *
     * @return void
     */
    public function add_main_menu()
    {

        $menu = $this->config->menu;
        \add_menu_page($menu->page_title, $menu->menu_title, $menu->capability, $menu->menu_slug, '', $menu->icon);
        $this->add_sub_menus();
    }
  
    /**
     * Renders submenu
     *
     * @return void
     */
    public function add_sub_menus()
    {
        $sub_menu = $this->config->menu->subs;
        foreach ($sub_menu as $sub) {
            $template = $this->get_template($sub->template);
            \add_submenu_page($sub->parent_slug, $sub->page_title, $sub->menu_title, $sub->capability, $sub->menu_slug, array($template, 'render_with_echo'));
        }
    }
}
