<?php
use MyGallery\Models\PostModel;

/**
 * Class PostModelTest
 *
 * @package MyGallery
 */

class PostModelTest extends \WP_UnitTestCase
{
    public $newShortcode='[my-gallery ids=434,232,435 title="New test" config=11611]';
    public $shortcode='[my-gallery ids=434,232 title="Test" config=11111]';
    public function setUp()
    {
        parent::setUp();
        $this->settings = include 'mock/defaultGallerySettings.php';

    }
    public function testGetShortcodes()
    {
        $shortcode = $this->getNewPost($this->shortcode)->getShortcode();
        $this->assertCount(1, $shortcode);
        $this->assertInstanceOf(stdClass::class, $shortcode[0]);
    }
    /**
     * @dataProvider codeData
     */
    public function testUpdatePostShortcodes($code,$expected)
    {

        $postInstance = 'draft'===$code->status?$this->getNewPost():$this->getNewPost($this->shortcode);

      
        $postInstance->updatePostShortcodes(array($code));
        $post = get_post($postInstance->postId());

        $this->assertEquals($expected, $post->post_content);
    }
    public function codeData()
    {   $newShortcode=$this->newShortcode;
        $shortcode=$this->shortcode;
        return [
            [(object) array(
                'code' => $newShortcode,
                'status' => 'changed',
            ), $newShortcode],
            [(object) array(
                'code' => $newShortcode,
                'status' => 'draft',
            ), '<!-- wp:shortcode -->' . PHP_EOL . $newShortcode . PHP_EOL . '<!-- /wp:shortcode -->'],
            [(object) array(
                'code' => $shortcode,
                'status' => 'deleted',
            ), ''],
        ];
    }

    protected function getNewPost($post_content='')
    {
        $postId = $this->factory()->post->create(['post_title' => 'Test post', 'post_content' => $post_content]);
        return new PostModel($postId);
    }
    public function tearDown()
    {
        parent::tearDown();
    }
}
