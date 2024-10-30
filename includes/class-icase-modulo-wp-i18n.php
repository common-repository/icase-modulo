<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://itargettecnologia.com.br
 * @since      1.0.0
 *
 * @package    Icase_Modulo_Wp
 * @subpackage Icase_Modulo_Wp/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Icase_Modulo_Wp
 * @subpackage Icase_Modulo_Wp/includes
 * @author     Itarget Tecnologia <contato@itarget.com.br>
 */
class Icase_Modulo_Wp_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'icase-modulo-wp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
