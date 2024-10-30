<?php

/**
 * Fired during plugin activation
 *
 * @link       http://itargettecnologia.com.br
 * @since      1.0.0
 *
 * @package    Icase_Modulo_Wp
 * @subpackage Icase_Modulo_Wp/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Icase_Modulo_Wp
 * @subpackage Icase_Modulo_Wp/includes
 * @author     Itarget Tecnologia <contato@itarget.com.br>
 */
class Icase_Modulo_Wp_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	// Create post object
		$espaco_associado = array(
		'post_title'    => wp_strip_all_tags( 'Espaço do associado' ),
		'post_content'  => '[espaco-do-associado]',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_type'     => 'page',
		);

		// Insert the post into the database
		wp_insert_post( $espaco_associado );
	}
}
register_activation_hook(__FILE__, 'activate');