<?php
/**
 * Creates a parallax header widget for Elementor.
 *
 * @package seelos-center/inc/elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The widget class.
 */
class Parallax_Header extends \Elementor\Widget_Base {
	/**
	 * Set the widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'parallax-header';
	}

	/**
	 * Set the widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_title() {
		return __( 'Parallax Header', 'seelos-elementor' );
	}

	/**
	 * Set the widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_icon() {
		return 'fa fa-desktop';
	}

	/**
	 * Set the widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Define the controls (settings fields) for the widget
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'seelos-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'headline',
			[
				'label'       => __( 'Headline', 'seelos-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'placeholder' => __( 'Type your headline here.', 'seelos-center' ),
			]
		);

		$this->add_control(
			'background-image',
			[
				'label'   => __( 'Background Image', 'seelos-elementor' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings   = $this->get_settings_for_display();
		$background = $settings['background-image']['url'];
		?>
		<div class="parallax-hero">
			<div class="parallax-hero__background" style="background-image:url('<?php echo esc_url( $background ); ?>?>');"></div>
			<div class="parallax-hero__content">
				<h1 class="parallax-hero__headline"><?php echo esc_html( $settings['headline'] ); ?></h1>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the widget frontend for the page builder.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() { // phpcs:ignore
		?>
		<div class="parallax-hero-display" style="display: flex; align-items:center; justify-content:center; position: relative; min-height:500px; width: 100%;">
			<div class="background" style="background-image:url('{{{ settings['background-image'].url }}}');position: absolute; left: 0; right: 0; bottom: 0; top: 0; background-size: cover;"></div>
			<h1 style="position: relative;z-index:10;color: white;text-align:center;text-transform: none;">{{{ settings.headline }}}</h1>
		</div>
		<?php
	}

	/**
	 * Add text fields to be WPML compatible.
	 *
	 * @access public
	 * @since 1.0.0
	 * @param array $widgets the current translatable widgets.
	 * @return array
	 */
	public function setup_translateable_fields( $widgets ) {
		$widgets['parallax-header'] = [
			'conditions' => [ 'widgetType' => 'parallax-header' ],
			'fields'     => [
				[
					'field'       => 'headline',
					'type'        => __( 'Headline', 'seelos-elementor' ),
					'editor_type' => 'AREA',
				],
			],
		];

		return $widgets;
	}
}
