<?php
use MyGallery\Utils\MenuConfig;

class MenuConfigTest extends \WP_UnitTestCase
{
    protected $configPath = __DIR__ . '/mock/menu-config.php';
    public function testWrongPath()
    {
        $wrong_path = __DIR__ . '/../menu-config-wrong.php';
        $this->expectException('Exception');
        $this->expectExceptionMessage('Cannot load template file ' . $wrong_path);
        new MenuConfig($wrong_path);
    }
    public function testWrongFormat()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Wrong main menu config file format.No needed keys in config file: 4.You need to add "template" parameter');
        new MenuConfig($this->configPath);
    }
}
