<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://tahir.codes/
 * @since      1.0.0
 *
 * @package    Idlkeys_management
 * @subpackage Idlkeys_management/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Idlkeys_management
 * @subpackage Idlkeys_management/public
 * @author     tahir iqbal <tahir@gmail.com>
 */
class Idlkeys_management_Public {
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/idlkeys_management-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/idlkeys_management-public.js', array( 'jquery' ), $this->version, false );
	}

}
