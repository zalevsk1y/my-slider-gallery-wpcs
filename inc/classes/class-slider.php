<?php

namespace My_Slider_Gallery;

use My_Slider_Gallery\Shortcode_Factory;
use My_Slider_Gallery\Trait_Config_Parse;
use My_Slider_Gallery\Trait_Helpers;
use My_Slider_Gallery\Trait_Images;
use My_Slider_Gallery\Trait_Template_Factory_Facade;

/**
 * Render template for slider and gallery.
 *
 * PHP version 7.0
 *
 * @package View
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT https://opensource.org/licenses/MIT
 */

class Slider
{
    /**
     * Adds create_image_object() method.
     */
    use Trait_Images;
    /**
     * Adds set_config() method.
     */
    use Trait_Config_Parse;
    /**
     * Adds bool_to_string(),remove_brackets(),remove_problem_symbols() methods.
     */
    use Trait_Helpers;
    /**
     * Adds get_template() method.
     */
    use Trait_Template_Factory_Facade;
    /**
     * Class that renders template with args.
     *
     * @var Template_Render 
     */
    protected $template;
    /**
     * Init function.
     *
     * @param string $template_path Path to template file.
     */
    public function __construct(string $templatePath)
    {
        $this->template = $this->get_template($templatePath);
        $this->register_shortcode();
    }
    /**
     * Register shortcode.
     *
     * @return void
     */
    protected function register_shortcode()
    {
        add_shortcode('my-gallery', array($this, 'render'));
    }

    /**
     * Render html for slider from template.
     *
     * @param array $attr Parameters for slider render.
     *
     * @return string
     */
    public function render($attr)
    {
        if (count($attr) === 0 || !isset($attr['ids'])) {
            return '';
        }

        //there is no filter to get shortcode before it will be parsed and passed as array of $attr to
        //do_shortcode_tag() function. /wp-includes/shortcodes.php #199 do_shortcode()

        $attr = isset($attr[0]) ? $this->fix_parsing_problems($attr) : $attr;
        if (\is_wp_error($attr)) {
            return '';
        }

        $imageIds = explode(',', $attr['ids']);
        //Variables that need to be included in template.
        $args = array(
            'title' => $this->get_title($attr),
            'config' => $this->get_config($attr),
            'images' => $this->create_Image_object($imageIds, array('full', 'thumbnail')),
            'boolToString' => array($this, 'bool_to_string'),
        );
        
        $content = $this->template->add_arguments($args)->render();
        return $content;
    }
    /**
     * Get title from array of attributes.
     *
     * @param array $attr Array of shortcode attributes.
     * @return  string
     */
    protected function get_title(array $attr)
    {
        if (isset($attr['title'])) {
            return $attr['title'];
        } else {
            return '';
        }
    }
    /**
     * Get config from array of attributes.
     *
     * @param array $attr Array of shortcode attributes.
     * @return object Object of stdClass with default configs.
     */
    protected function get_config(array $attr)
    {
        if (isset($attr['config'])) {
            return $this->set_config((int) $attr['config']);
        } else {
            return (Shortcode_Factory::$default_settings)->config;
        }
    }
    /**
     * Solve problem with parsing shortcode parameters.
     * Some time shortcode was saved with &qoute; instead of quotes.It confuses WP regexp.
     * and $attr array instead param name contains parts of title with digital key.
     * This function solves this problem.It finds and glue params with keys == digits in one string.
     * Вo not throw Exceptions because this is not a critical error.
     * And Exceptions adversely affect performance.
     *
     * @param array $attr Array with parsed shortcode attributes.
     *
     * @return array
     */

    protected function fix_parsing_problems($attr)
    {
        $pattern = '/(?P<digit_key>[\d]+)/i';
        $new_attr = array();
        $counter = 0;
        $prop_value = '';
        $prop_name = null;
        foreach ($attr as $key => $item) {
            if ($key === 0 && $counter === 0) {
                return new \WP_Error('parsing_shortcode_error', 'Wrong shortcode format.');
            }

            preg_match_all($pattern, $key, $matches);
            if (count($matches['digit_key']) > 0) {
                $prop_value .= $item . ' ';
            } else {
                if ($counter > 0) {
                    $new_attr[$prop_name] = $this->remove_problem_symbols($prop_value);
                }

                $prop_value = $item . ' ';
                $prop_name = $key;
            }
            $counter++;
        }
        $new_attr[$prop_name] = $prop_value;
        return $new_attr;
    }
}
