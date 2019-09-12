<?php
namespace My_Slider_Gallery;

use My_Slider_Gallery\Template_Factory;
use My_Slider_Gallery\Template_Render;

/**
 * Trait for include facade method for Template Factory.
 *
 * PHP version 7.0
 *
 * @package  Traits
 * @author   Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license  MIT
 */

trait Trait_Template_Factory_Facade
{
    /**
     * Facade for Template_Factory return Template_Renderer class.
     *
     * @param string $template_path Path to template.
     * @return Template_Render
     */
    protected function get_template(string $template_path)
    {
        return Template_Factory::get($template_path);
    }
}
