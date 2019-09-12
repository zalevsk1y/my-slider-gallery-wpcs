<?php
namespace My_Slider_Gallery;

use My_Slider_Gallery\Shortcode_Factory;
use My_Slider_Gallery\Post_Model;

/**
 * Factory class creates instance of PostModel class
 *
 * PHP version 7.0
 *
 * @package  Factories
 * @author   Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license  MIT
 */

class Post_Factory
{   
    /**
     * Shortcode factory.
     *
     * @var Shortcode_Factory
     */
    protected $factory;
    /**
     * Init function.
     */
    public function __construct(Shortcode_Factory $factory){
        $this->factory=$factory;
    }
    /**
     * Getter for creating new instance.
     *
     * @param integer $post_id Id of post.
     * @return Post_Model
     */

    public function get($post_id)
    {
        return new Post_Model($post_id,$this->factory);
    }
}
