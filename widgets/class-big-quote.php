<?php
/**
 * Creates a big quote widget for Elementor.
 *
 * @package seelos-center/inc/elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The widget class.
 */
class Big_Quote extends \Elementor\Widget_Base {
	/**
	 * Set the widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'big-quote';
	}

	/**
	 * Set the widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_title() {
		return __( 'Big Quote', 'seelos-elementor' );
	}

	/**
	 * Set the widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_icon() {
		return 'fa fa-quote-left';
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
			'quote',
			[
				'label' => __( 'Quote', 'seelos-elementor' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
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
		$settings = $this->get_settings_for_display();
		?>
		<div class="big-quote">
			<blockquote>
				<p><?php echo esc_html( $settings['quote'] ); ?></p>
			</blockquote>
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
		<p style="font-size:1.8rem;font-style:italic;font-family:serif;color:#A45625;">{{{settings.quote}}}</p>
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
	public function setup_translateable_field( $widgets ) {
		$widgets['big-quote'] = [
			'conditions' => [ 'widgetType' => 'big-quote' ],
			'fields'     => [
				[
					'field'       => 'quote',
					'type'        => __( 'Quote', 'seelos-elementor' ),
					'editor_type' => 'AREA',
				],
			],
		];

		return $widgets;
	}
}
