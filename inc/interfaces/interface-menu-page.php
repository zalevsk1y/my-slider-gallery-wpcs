<?php
namespace My_Slider_Gallery;

use My_Slider_Gallery\Menu_Config;

/**
 * Interface for Menu pages class.
 *
 * PHP version 7.0
 *
 * @package  Interfaces
 * @author   Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license  MIT
 */
interface Interface_Menu_Page
{
    /**
     * Init menu method.
     *
     * @param Menu_Config $config Instance of Menu_Config that provides menu config data.
     * @return void
     */
    public function init(Menu_Config $config);
}
