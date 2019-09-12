<?php
namespace My_Slider_Gallery;

use My_Slider_Gallery\Config_Parse;
use My_Slider_Gallery\Helpers;
use My_Slider_Gallery\Images;

/**
 * Operates with shortcode object.
 *
 * PHP version 7.0
 *
 * @package Models
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT
 */

class Shortcode_Model
{
    /**
     * Add setConfig() method.
     */
    use Trait_Config_Parse;
    /**
     * Add createImageObject() method.
     */
    use Trait_Images;
    /**
     * Add removeBrackets() method.
     */
    use Trait_Helpers;
     /**
     * RegExp pattern to get shortcode name.
     *
     * @var string
     */
    protected $shortcode_name_pattern = '/(?P<name>my\-gallery)/i';
    /**
     * Not parsed shortcode string.
     *
     * @var string
     */
    protected $original_code;
    /**
     * Array of images ids.
     *
     * @var array
     */
    protected $images_ids = array();
    /**
     * Title of the gallery.
     *
     * @var string
     */
    protected $title = '';
    /**
     * Array of image urls.
     *
     * @var array
     */
    public $images;
    /**
     * Object with parsed parts of shortcode[ids,config,misc]
     * ids- ids of images [string]
     * config-gallery config [string]
     * misc-gallery title [string].
     *
     * @var \stdClass
     */
    public $code;
    /**
     * Gallery settings. If settings was not set than set to default.
     *
     * @var \stdClass
     */
    public $settings;
    /**
     * Init function
     *
     *  @param string $code
     *  @param \stdClass $default_settings
     */
    public function __construct($code, $default_settings)
    {
        $replace_quotes_code=preg_replace('/(&quot;)/i', '"', $code);
        $this->original_code = substr_replace($replace_quotes_code, ' ', -1, 0);
        $this->settings = $default_settings;
        $this->code = (object) array(
            'ids' => '',
            'config' => '',
            'misc' => '',
        );
        $this->init();
    }
    /**
     * Initialize.
     *
     * @return void
     */
    protected function init()
    {

        $this->parse_code();
    }
    /**
     * Creates shortcode object in proper format for front end
     *
     * @return object
     */
    public function to_object()
    {
        return (object) array(
            'code' => $this->code,
            'images' => $this->images,
            'settings' => $this->settings,
            '_originalCode' => $this->original_code,
        );
    }
    /**
     * Parse shortcode attributes with shortcode_parse_atts() wp function.
     *
     * @return void
     */
    protected function parse_code()
    {
       
        $attr = \shortcode_parse_atts($this->original_code);
         //parse image ids
        $this->parse_image_ids($attr);
        //parsing and escaping gallery title
        $this->parse_title($attr);
        //parsing gallery config
        $this->parse_config($attr);
    }
    /**
     * Parse gallery images ids and create array of image objects with image properties.
     *
     * @param array $attr Array of shortcode attribute.
     * @return array
     */
    protected function parse_image_ids(array $attr)
    {
        $ids='';
        if (isset($attr['ids'])) {
            $ids = $this->remove_brackets($attr['ids']);
            $this->images = $this->set_image(explode(',', $ids));
            $this->code->ids = 'ids=' . $ids;
        }

        return  explode(',', $ids);
    }
    /**
     * Parse gallery title.
     *
     * @param array $attr Array of shortcode attribute.
     * @return string
     */
    protected function parse_title(array $attr)
    {
        if (isset($attr['title'])) {
            $title = $this->remove_brackets($attr['title']);
            $this->title = esc_html($title);
            $this->settings->misc->title = $this->title;
            $this->code->misc .= 'title="' . $this->title . '"';
        }
        return $this->title;
    }
    /**
     * Parse gallery config.
     *
     * @param array $attr Array of shortcode attribute.
     * @return string
     */
    protected function parse_config(array $attr)
    {
        $config='';
        if (isset($attr['config'])) {
            $config = $this->remove_brackets($attr['config']);
            $this->settings->config = $this->set_config($config);
            $this->code->misc .= ' config=' . (int) $config;
        }
        return $config;
    }
    /**
     * Facade function for Images Trait function
     *
     * @param array $ids Image ids.
     * @return array
     */
    protected function set_image(array $ids)
    {

        return $this->create_image_object($ids);
    }

    /**
     * Set default structure for empty shortcode object.
     *
     * @return void
     */
    protected function set_empty_shortcode()
    {
        $this->images = array();
        $this->code = (object) array(
            'ids' => '',
            'config' => '',
            'misc' => '',
        );
    }
    /**
     * Check if shortcode has correct name.
     *
     * @return boolean
     */
    protected function check_shortcode_name()
    {
        preg_match($this->shortcode_nam_pattern, $this->original_code, $match);

        return isset($match['name']);
    }
}
