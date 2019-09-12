<?php
use MyGallery\View\MediaButtons;
use Spatie\Snapshots\MatchesSnapshots;


Class MediaButtonsTest  extends \WP_UnitTestCase
{   use MatchesSnapshots;

    public function testRenderMediaButton(){
        $template_path=__DIR__.'/../template/media-button/media-button.php';
        $instance=new MediaButtons($template_path);
        $this->assertMatchesSnapshot($instance->renderMediaButton('testButton'));
    } 

}