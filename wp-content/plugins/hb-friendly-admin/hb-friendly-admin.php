<?php
/**
 * "Friendlier, Safer WordPress Admin Areas"
 * Presented by Cliff Seal at WordCamp Atlanta 2015
 * Slides: http://www.slideshare.net/cliffseal/wp-admin
 *
 * Plugin Name: Friendly Admin
 * Plugin URI: https://github.com/hoverboard88/hb-friendly-admin
 * Description: Cleans up and sanitizes the WordPress admin area (originally by Cliff Seal)
 * Version: 1.0
 * Author: Ryan Tvenge <ryan@hoverboardstudios.com>
 * Author URI: http://hoverboardstudios.com
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Turn off things that can screw things up.
 */

if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}
if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
	define( 'DISALLOW_FILE_MODS', true );
}

/**
 * Plugin class.
 */

class friendlier_safer_admin {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @const   string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'hb-friendlier-safer-admin';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		add_action( 'admin_menu', array( $this, 'hbfa_remove_tools' ), 999 );
		add_action( 'wp_before_admin_bar_render', array( $this, 'hbfa_remove_admin_bar_links' ) );
		add_action( 'admin_init', array( $this, 'hbfa_disable_dashboard_widgets' ) );
		add_action( 'admin_init', array( $this, 'hbfa_add_theme_caps' ) );
		add_action( 'customize_register', array( $this, 'hbfa_remove_gotdang_customizer_nags' ), 20 );
		add_action( 'init', array( $this, 'hbfa_remove_gotdang_nags' ) );
		add_filter( 'show_advanced_plugins', array( $this, 'hbfa_return_false' ) );
		add_filter( 'plugin_row_meta', array( $this, 'hbfa_hide_plugin_details' ), 10, 2 );
		add_filter( 'plugin_action_links_wordpress-seo/wp-seo.php', array( $this, 'hbfa_hide_plugin_links' ), 11 );
		add_filter( 'all_plugins', array( $this, 'hbfa_filter_plugins' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Return False for Basic Filters
	 *
	 * @since    1.0.0
	 */
	public function hbfa_return_false() {
		return false;
	}

	/**
	 * NOTE:  Remove Stupid Tools.php & Sensitive Plugins from View
	 *
	 * @since    1.0.1
	 */
	public function hbfa_remove_tools() {
		// remove_submenu_page( 'tools.php', 'tools.php' );
		// remove_menu_page( 'sucuriscan' );
		// remove_menu_page( 'w3tc_dashboard' );
		// remove_menu_page( 'amazon-web-services' );
		// remove_submenu_page( 'options-general.php', 'wpmandrill' );
		// remove_submenu_page( 'plugins.php', 'cloudflare' );
	}


	/**
	 * NOTE:  Hide Extraneous Plugin Options from the Menu Bar
	 *
	 * @since    1.0.0
	 */
	public function hbfa_remove_admin_bar_links() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('w3tc-faq');
		$wp_admin_bar->remove_menu('w3tc-support');
	}


	/**
	 * NOTE:  Hide WordPress News
	 *
	 * @since    1.0.0
	 */
	public function hbfa_disable_dashboard_widgets() {
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	}

	/**
	 * NOTE:  Allow Editors to Get to Widgets and Stuff
	 *
	 * @since    1.0.0
	 */
	public function hbfa_add_theme_caps() {
		$role_object = get_role( 'editor' );
		$role_object->add_cap( 'edit_theme_options' );
	}

	/**
	 * NOTE:  Remove Customizer Junk
	 *
	 * @since    1.0.0
	 */
	public function hbfa_remove_gotdang_customizer_nags() {
		global $wp_customize;
		$wp_customize->remove_section( get_template() . '_theme_info');
	}


	/**
	 * NOTE:  Remove NAGS (ohgodwhy)
	 *
	 * @since    1.0.0
	 */
	public function hbfa_remove_gotdang_nags() {
		remove_action( 'admin_notices', 'woothemes_updater_notice' );
	}


	/**
	 * NOTE:  Hide Plugin Details
	 *
	 * @since    1.0.0
	 */
	public function hbfa_hide_plugin_details( $links, $file ) {
		$links = array();
		return $links;
	}

	/**
	 * NOTE:  Hide Awkard Plugin Links
	 *
	 * @since    1.0.0
	 */
	public function hbfa_hide_plugin_links( $links ) {
		if ( !empty($links['deactivate']) ) {
			$links = array(
				'deactivate' => $links['deactivate']
			);
		}
		return $links;
	}

	/**
	 * NOTE:  Hide Sensitive Plugins from Plugins Listing
	 *
	 * @since    1.0.0
	 */
	public function hbfa_filter_plugins( $plugins ) {
		$hidden = array(
			'Sucuri Security - Auditing, Malware Scanner and Hardening',
			'W3 Total Cache',
			'Amazon S3 and CloudFront',
      'WP Migrate DB Pro',
      'WP Migrate DB Pro CLI',
      'WP Migrate DB Pro Media Files'
		);
		if ( !isset($_GET['seeplugins']) || $_GET['seeplugins'] !== 'rtvenge' || $_GET['seeplugins'] !== 'mbiersdo' ) {
			foreach ($plugins as $key => &$plugin ) {
				if ( in_array( $plugin["Name"], $hidden ) ) {
					unset($plugins[$key]);
				}
			}
		}
		return $plugins;
	}

}

friendlier_safer_admin::get_instance();
