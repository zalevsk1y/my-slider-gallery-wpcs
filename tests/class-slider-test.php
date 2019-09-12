<?php
use My_Slider_Gallery\Slider;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * Class Slider_For_Test
 *
 * @package MyGallery
 */

class Slider_For_Test extends Slider{

    protected function create_image_object(array $image_ids,$size='thumbnail'){
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
Class Slider_Test  extends \WP_UnitTestCase
{   use MatchesSnapshots;
    public function setUp()
    {

        parent::setUp();
        $this->template_path = __DIR__ . '/../template/slider/content-slider.php';
        $this->post_id=$this->factory()->attachment->create();
        $this->instance = new Slider_For_Test($this->template_path);
        
       
    }
     /**
     * @dataProvider code_parsing
     */
    public function test_create_slider($attr,$expected){
        $content=$this->instance->render($attr);
        $this->assertMatchesSnapshot($content);
        //$this->expectOutputString($content);
        //$snapshot=include $expected;
    }
    public function code_parsing()
    {
        return [
            [array('ids'=>'1,2,3,4,5,6,7','title'=>'Test Gallery','config'=>'1061'),'snapshot-1'],
            [array('ids'=>'1,2,3,4,5,6,7','title'=>'Test', 0=>'Gallery',1=>'1','config'=>'1061'),'snapshot-1'],
            [array('ids'=>'1,2,3,4,5,6,7'),'snapshot-2'],
            [array('ids'=>'1,2,3,4,5,6,7'),'snapshot-3'],
        ];
    }
}