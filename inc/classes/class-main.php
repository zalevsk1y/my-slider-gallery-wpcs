<?php

namespace My_Slider_Gallery;

use My_Slider_Gallery\Menu_Config;

/**
 * Initialize scripts and styles.
 *
 * PHP version 7.0
 *
 * @package Core
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT https://opensource.org/licenses/MIT
 */

class Main
{
    protected $config_menu;
    protected $original_shortcode;
    protected $template;

    /**
     * Function constructor
     *
     */
    public function __construct(Menu_Config $admin_config)
    {
        $this->config_menu = $admin_config->get();
        $this->register_actions();
    }

    /**
     * Add script to Post Edit section of admin menu.
     *
     * @param mixed $hook name of page passed by the hook
     *
     * @return void
     */
    public function enqueue_admin_scripts($hook)
    {
        wp_enqueue_style(MYGALLERY_PLUGIN_SLUG . '-main-style', MYGALLERY_PLUGIN_URL . '/public/css/my-gallery.css');
        if ('post.php' == $hook) {
            wp_enqueue_script(MYGALLERY_PLUGIN_SLUG . '-post-edit-script');
        }

        if ('post-new.php' == $hook) {
            wp_enqueue_script(MYGALLERY_PLUGIN_SLUG . '-post-new-script');
        }

        if (strrpos($hook, $this->config_menu->menu->subs[0]->menu_slug) !== false) {
            \wp_enqueue_style(MYGALLERY_PLUGIN_SLUG . '-add-gallery-style', MYGALLERY_PLUGIN_URL . '/public/css/add-gallery.css');
            \wp_enqueue_style(MYGALLERY_PLUGIN_SLUG . '-add-gallery-font', MYGALLERY_PLUGIN_URL . '/public/css/font.css');
            \wp_enqueue_style(MYGALLERY_PLUGIN_SLUG . '-bootstrap', MYGALLERY_PLUGIN_URL . '/public/css/bootstrap.css');
            $post_id = $this->get_custom_query_var('post');
            if ($post_id) {
                wp_enqueue_media(array('id' => $post_id));
            }
            wp_enqueue_script(MYGALLERY_PLUGIN_SLUG . '-add-gallery');
            $api_endpoints=array(
                'getPostsList'=>rest_url('/my-gallery/v1/posts-list/date/desc/'),
                'getPostData'=>rest_url('/my-gallery/v1/post/'),
                'patchPostData'=>rest_url('/my-gallery/v1/post/')
            );
            wp_localize_script(MYGALLERY_PLUGIN_SLUG . '-add-gallery', 'apiEndpoints', $api_endpoints);
        }
    }

    /**
     * Add slider and gallery scripts to the post page.
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(MYGALLERY_PLUGIN_SLUG . '-slider-script');
    }

    /**
     * Add styles for slider and gallery to the post page.
     *
     * @return void
     */
    public function enqueue_styles()
    {
        $default_style_path = MYGALLERY_PLUGIN_URL . '/public/css/my-gallery-slider.css';
        $style_path = apply_filters('my_gallery_style', $default_style_path);
        wp_enqueue_style(MYGALLERY_PLUGIN_SLUG . '-slider-style', MYGALLERY_PLUGIN_URL . '/public/css/slider.css');
        wp_enqueue_style(MYGALLERY_PLUGIN_SLUG . '-additional-slider-style', $style_path);
    }

    /**
     * Register scripts and their dependencies.
     *
     * @return void
     */
    public function register_scripts()
    {
        wp_register_script(MYGALLERY_PLUGIN_SLUG . '-post-edit-script', MYGALLERY_PLUGIN_URL . '/public/js/post-edit.bundle.js', array('react', 'react-dom', 'lodash', 'media-models'), MYGALLERY_PLUGIN_VERSION);
        wp_register_script(MYGALLERY_PLUGIN_SLUG . '-post-new-script', MYGALLERY_PLUGIN_URL . '/public/js/post-new.bundle.js', array('react', 'react-dom', 'lodash', 'media-models'), MYGALLERY_PLUGIN_VERSION);
        wp_register_script(MYGALLERY_PLUGIN_SLUG . '-add-gallery', MYGALLERY_PLUGIN_URL . '/public/js/add-gallery.bundle.js', array('react', 'react-dom', 'lodash', 'underscore', 'backbone', 'jquery', 'media-models'), MYGALLERY_PLUGIN_VERSION);
        wp_register_script(MYGALLERY_PLUGIN_SLUG . '-slider-script', MYGALLERY_PLUGIN_URL . '/public/js/slider.bundle.js', array('jquery'), MYGALLERY_PLUGIN_VERSION);
    }

    /**
     * Register actions and shortcode.
     *
     * @return void
     */
    private function register_actions()
    {
        add_action('wp_loaded', array($this, 'register_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    /**
     * Get query params
     *
     * @param string $var parameter name
     * @return boolean|int
     */
    public function get_custom_query_var(string $var)
    {
        switch ($var) {
            case 'post':
                if (isset($_GET['post'])) {
                    $post = $_GET['post'];
                    $filtered_post = preg_filter('/[\d]/', '$0', $post);
                    return (int) $filtered_post;
                }
                return false;
        }
    }
}