<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://tahir.codes/
 * @since      1.0.0
 *
 * @package    Idlkeys_management
 * @subpackage Idlkeys_management/includes
 */

class Idlkeys_management {

	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'IDLKEYS_MANAGEMENT_VERSION' ) ) {
			$this->version = IDLKEYS_MANAGEMENT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'idlkeys_management';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-idlkeys_management-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-idlkeys_management-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-idlkeys_management-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-idlkeys_management-public.php';
		$this->loader = new Idlkeys_management_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Idlkeys_management_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Idlkeys_management_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'idl_key_manage_menu' );


		//$this->loader->add_action( 'wp_ajax_nopriv_get_keys', $plugin_admin , 'get_keys' );
		$this->loader->add_action( 'wp_ajax_get_keys', $plugin_admin , 'get_keys' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_keys', $plugin_admin , 'get_keys' );
		$this->loader->add_action( 'wp_ajax_key_update', $plugin_admin , 'update_key' );
		$this->loader->add_action( 'wp_ajax_nopriv_key_update', $plugin_admin , 'update_key' );
		$this->loader->add_action( 'wp_ajax_addkey', $plugin_admin , 'addkey' );
		$this->loader->add_action( 'wp_ajax_nopriv_addkey', $plugin_admin , 'addkey' );
		$this->loader->add_action( 'wp_ajax_getcustomer_emp', $plugin_admin , 'getcustomer_emp' );
		$this->loader->add_action( 'wp_ajax_nopriv_getcustomer_emp', $plugin_admin , 'getcustomer_emp' );
		$this->loader->add_action( 'wp_ajax_send_cus_mail', $plugin_admin , 'send_cus_mail' );
   		$this->loader->add_action( 'wp_ajax_nopriv_send_cus_mail', $plugin_admin , 'send_cus_mail' );
   		$this->loader->add_action( 'wp_ajax_delete_key', $plugin_admin , 'delete_key' );
   		$this->loader->add_action( 'wp_ajax_nopriv_delete_key', $plugin_admin , 'delete_key' );
   		$this->loader->add_action( 'admin_init', $plugin_admin, 'idl_keys_configuration_settings');
	}

	private function define_public_hooks() {
		$plugin_public = new Idlkeys_management_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
