<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://acalebwilson.com
 * @since      1.0.0
 *
 * @package    Fhs_Stock_Updater
 * @subpackage Fhs_Stock_Updater/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Fhs_Stock_Updater
 * @subpackage Fhs_Stock_Updater/includes
 * @author     Caleb Wilson <caleb@natureslaboratory.co.uk>
 */
class Fhs_Stock_Updater_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fhs-stock-updater',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
