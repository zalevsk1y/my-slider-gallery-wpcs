<?php
/**
 * Render media button for classic editor.
 *
 * @package View
 */

namespace My_Slider_Gallery;

use My_Slider_Gallery\Trait_Template_Factory_Facade;

/**
 * Render media button for classic editor.
 *
 * PHP version 7.0
 *
 * @package View
 * @author  Evgeniy S.Zalevskiy <2600@ukr.net>
 * @license MIT https://opensource.org/licenses/MIT
 */
class Media_Buttons {

	/**
	 * Add get_template() method
	 */
	use Trait_Template_Factory_Facade;
	/**
	 * Instance of TemplateRender that renders from template with args.
	 *
	 * @var MyGallery\View\Template_Render;
	 */
	protected $template;
	/**
	 * Init function.
	 *
	 * @param string $template_path Path to  Media buttons template.
	 */
	public function __construct( string $template_path ) {
		$this->template = $this->get_template( $template_path );
		$this->register_filters();
	}
	/**
	 * Add filter to edit media buttons content.
	 *
	 * @return void
	 */
	protected function register_filters() {
		add_filter( 'media_buttons_context', array( $this, 'render_media_button' ) );
	}
	/**
	 * Render template of media button.
	 *
	 * @param string $buttons Content of media button.
	 * @return string
	 */
	public function render_media_button( string $buttons ) {
		$button = $this->template->render();
		return $buttons . $button;
	}
}
