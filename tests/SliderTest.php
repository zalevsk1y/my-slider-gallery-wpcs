<?php
use MyGallery\View\Slider;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * Class SliderTest
 *
 * @package MyGallery
 */

class SliderForTest extends Slider{

    protected function createImageObject(array $imageIds,$size='thumbnail'){
        $images=[];
        for($i=1;$i<7;$i++){
            $images[]=(object)array(
                'id'=>$i,
                'url'=>(object)array(
                    'thumbnail'=>array('http://www.testMyPlugin.com/thumbnail-image'.$i.'jpg'),
                    'full'=>array(
                        'http://www.testMyPlugin.com/full-image'.$i.'jpg',
                        '1920',
                        '1080'
                    )
                )
                
            );
        }
        return $images;
    }   
}
Class SliderTest  extends \WP_UnitTestCase
{   use MatchesSnapshots;
    public function setUp()
    {

        parent::setUp();
        $this->templatePath = __DIR__ . '/../template/slider/content-slider.php';
        $this->postId=$this->factory()->attachment->create();
        $this->instance = new SliderForTest($this->templatePath);
        
       
    }
     /**
     * @dataProvider codeParsing
     */
    public function testCreateSlider($attr,$expected){
        $content=$this->instance->render($attr);
        $this->assertMatchesSnapshot($content);
        //$this->expectOutputString($content);
        //$snapshot=include $expected;
    }
    public function codeParsing()
    {
        return [
            [array('ids'=>'1,2,3,4,5,6,7','title'=>'Test Gallery','config'=>'1061'),'snapshot-1'],
            [array('ids'=>'1,2,3,4,5,6,7','title'=>'Test', 0=>'Gallery',1=>'1','config'=>'1061'),'snapshot-1'],
            [array('ids'=>'1,2,3,4,5,6,7'),'snapshot-2'],
            [array('ids'=>'1,2,3,4,5,6,7'),'snapshot-3'],
        ];
    }
}