<?php

/**
 * Fired during plugin activation
 *
 * @link       https://tahir.codes/
 * @since      1.0.0
 *
 * @package    Idlkeys_management
 * @subpackage Idlkeys_management/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Idlkeys_management
 * @subpackage Idlkeys_management/includes
 * @author     tahir iqbal <tahir@gmail.com>
 */
class Idlkeys_management_Activator {

	public static function activate() {
		global $wpdb;
	    global $charset_collate;

		$tbl_floor = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."idl_keys` (
				`id` int(50) NOT NULL AUTO_INCREMENT,
				`title` varchar(50) NOT NULL,
				`key_color` varchar(50) NOT NULL,
				`location` varchar(50) NOT NULL,
				`employee` varchar(50) NOT NULL,
				`customer` varchar(50) NOT NULL,
				 PRIMARY KEY (`id`)
				) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

		$update_tbl_floor ="ALTER TABLE `".$wpdb->prefix."idl_keys`
					ADD `reminder_date` DATE NOT NULL";
					
		$wpdb->query($tbl_floor);
		$wpdb->query($update_tbl_floor);

	}

}
