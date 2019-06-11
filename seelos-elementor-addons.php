<?php // phpcs:ignore
/**
 * Plugin Name: Seelos Elementor Addons
 * Description: Custom elementor widgets for Seelos
 * Plugin URI: http://seelos.org/
 * Author: Studio Mundi
 * Author URI: https://studiomundi.com/
 * Version: 1.0.0
 * Text Domain: seelos-elementor
 *
 * @package seelos-elementor-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Elementor Plugin Class
 */
final class Seelos_Elementor_Addons {
	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Seelos_Elementor_Addons The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'seelos-elementor' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Only load the plugin after Elementor & other plugins are loaded
	 * Checks for basic plugin requirements
	 * If all checks have passed, files required to run the plugin are loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {
		// Check if Elementor is installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// add plugin actions.
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );
	}

	/**
	 * Admin notice
	 *
	 * Displays a warning when the site doesn't have Elementor installed or activated.
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'seelos-elementor' ),
			'<strong>' . esc_html__( 'Seelos Elementor Addons', 'seelos-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'seelos-elementor' ) . '</strong>'
		);

		sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) { // phpcs:ignore
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-test-extension' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		sprintf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {
		// Include Widget files.
		require_once __DIR__ . '/widgets/class-big-button.php';
		require_once __DIR__ . '/widgets/class-big-quote.php';
		require_once __DIR__ . '/widgets/class-parallax-header.php';

		// Register widget.
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Big_Button() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Big_Quote() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Parallax_Header() );
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
		$widgets['big-button'] = [
			'conditions' => [ 'widgetType' => 'big-button' ],
			'fields'     => [
				[
					'field'       => 'button-text',
					'type'        => __( 'Button Text', 'seelos-elementor' ),
					'editor_type' => 'AREA',
				],
				[
					'field'       => 'button-link',
					'type'        => __( 'Button Link', 'seelos-elementor' ),
					'editor_type' => 'LINE',
				],
			],
		];

		return $widgets;
	}
}

Seelos_Elementor_Addons::instance();
