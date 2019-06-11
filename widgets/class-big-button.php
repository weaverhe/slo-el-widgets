<?php
/**
 * Creates a big button widget for Elementor.
 *
 * @package seelos-center/inc/elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The widget class.
 */
class Big_Button extends \Elementor\Widget_Base {
	/**
	 * Set the widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'big-button';
	}

	/**
	 * Set the widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_title() {
		return __( 'Big Button', 'seelos-elementor' );
	}

	/**
	 * Set the widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_icon() {
		return 'fa fa-hand-pointer-o';
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
			'button-text',
			[
				'label' => __( 'Button Text', 'seelos-elementor' ),
				'type'  => \Elementor\Controls_Manager::CODE,
				'raw'   => __( 'Line one <br />Line two', 'seelos-elementor' ),
			]
		);

		$this->add_control(
			'button-link',
			[
				'label' => __( 'Button Link', 'seelos-elementor' ),
				'type'  => \Elementor\Controls_Manager::URL,
			]
		);

		$this->add_control(
			'background-color',
			[
				'label'   => __( 'Button Color', 'seelos-elementor' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => 'hex',
				'alpha'   => 'false',
			]
		);

		$this->add_control(
			'border-color',
			[
				'label'   => __( 'Border Color', 'seelos-elementor' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => 'hex',
				'alpha'   => 'false',
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'       => __( 'Background Opacity', 'seelos-elementor' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 'hex',
				'description' => 'A percentage value for background opacity.',
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
		<a
			href="<?php echo esc_url( $settings['button-link'] ); ?>"
			class="big-button"
		>
			<div
				class="big-button__background"
				style="background-color:<?php echo esc_html( $settings['background-color'] ); ?>; border-color:<?php echo esc_html( $settings['border-color'] ); ?>;opacity:<?php echo esc_html( $settings['opacity'] / 100 ); ?>;"
			>
			</div>
			<span class="big-button__text">
				<?php echo wp_kses_post( $settings['button-text'] ); ?>
			</span>
		</a>
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
		<div style="padding:15px;background-color:{{{settings['background-color']}}};border:1px solid {{{settings['border-color']}}}">
			<p style="color:#f2efe2 !important;text-align:center;text-transform:uppercase;font-family:serif;font-size:1.9rem;">{{{settings['button-text']}}}</p>	
		</div>
		<?php
	}
}
