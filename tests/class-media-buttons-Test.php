<?php
use My_Slider_Gallery\Media_Buttons;
use Spatie\Snapshots\MatchesSnapshots;


Class Media_Buttons_Test  extends \WP_UnitTestCase
{   use MatchesSnapshots;

    public function test_render_media_button(){
        $template_path=__DIR__.'/../template/media-button/media-button.php';
        $instance=new Media_Buttons($template_path);
        $this->assertMatchesSnapshot($instance->render_media_button('testButton'));
    } 

}