<?php

/*
Plugin Name: My Slider Gallery WPCS
Plugin URI: https://github.com/zalevsk1y/my-slider-gallery
Description: Plugin was renamed. MyGallery become MySliderGallery. Add slider and gallery to your post fast and easy.
Version: 2.0.3
Author: Evgeny S.Zalevskiy <2600@ukr.net>
Author URI: https://github.com/zalevsk1y/
License: MIT
 */
?>
<?php
namespace My_Slider_Gallery;

if (! defined('ABSPATH')) {
    exit;
}


define("MYGALLERY_PLUGIN_VERSION", "2.0.3");
define("MYGALLERY_PLUGIN_SLUG", "my-gallery");
define("MYGALLERY_PLUGIN_SHORTCODE", "my-gallery");
define("MYGALLERY_PLUGIN_NAMESPACE", __NAMESPACE__);
define("MYGALLERY_PLUGIN_URL", plugins_url("", __FILE__));
define("MYGALLERY_PLUGIN_DIR", plugin_dir_path(__FILE__));

require "autoload.php";
$default_gallery_settings=require MYGALLERY_PLUGIN_DIR.'defaultGallerySettings.php';
$slider_template_path=MYGALLERY_PLUGIN_DIR . "/template/slider/content-slider.php";
$media_buttons_template_path=MYGALLERY_PLUGIN_DIR . "/template/media-button/media-button.php";
$modules = [];

$modules['menu_config']=new Menu_Config(MYGALLERY_PLUGIN_DIR.'menu-config.php');
//---Factories
$modules['shortcode_model_factory']=new Shortcode_Factory($default_gallery_settings);
$modules['post_model_factory']=new Post_Factory($modules['shortcode_model_factory']);
//---Admin menu modules

$modules['menu_page'] = new Menu_Page($modules['menu_config']);
$modules["main"] = new Main($modules['menu_config']);
$modules["slider"] = new Slider($slider_template_path);
$modules['media_buttons']=new Media_Buttons($media_buttons_template_path);
$modules["rest_posts_list"] = new Posts_List_Controller();
$modules["rest_shortcodes_get"] = new Shortcode_Controller($modules['post_model_factory']);
