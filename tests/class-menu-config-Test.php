<?php
use My_Slider_Gallery\Menu_Config;

class Menu_Config_Test extends \WP_UnitTestCase
{
    protected $config_path = __DIR__ . '/mock/menu-config.php';
    public function test_wrong_path()
    {
        $wrong_path = __DIR__ . '/../menu-config-wrong.php';
        $this->expectException('Exception');
        $this->expectExceptionMessage('Cannot load template file ' . $wrong_path);
        new Menu_Config($wrong_path);
    }
    public function test_wrong_format()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Wrong main menu config file format.No needed keys in config file: 4.You need to add "template" parameter');
        new Menu_Config($this->config_path);
    }
}
