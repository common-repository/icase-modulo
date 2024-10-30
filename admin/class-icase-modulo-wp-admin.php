<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://itargettecnologia.com.br
 * @since      1.0.0
 *
 * @package    Icase_Modulo_Wp
 * @subpackage Icase_Modulo_Wp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Icase_Modulo_Wp
 * @subpackage Icase_Modulo_Wp/admin
 * @author     Itarget Tecnologia <contato@itarget.com.br>
 */
class Icase_Modulo_Wp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Icase_Modulo_Wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Icase_Modulo_Wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/icase-modulo-wp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Icase_Modulo_Wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Icase_Modulo_Wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/icase-modulo-wp-admin.js', array( 'jquery' ), $this->version, false );

	}

}
function enqueue_plugin_scripts($plugin_array)
{
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array["botao_acesso_restrito"] =  plugin_dir_url(__FILE__) . "js/icase-modulo-wp-admin.js";
    return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_plugin_scripts");
function register_buttons_editor($buttons)
{
    //register buttons with their id.
    array_push($buttons, "restrito");
    return $buttons;
}

add_filter("mce_buttons", "register_buttons_editor");





function icase_settings_init() {
	// register a new setting for "icase" page
	register_setting( 'icase', 'icase_options' );
	
	// register a new section in the "icase" page
	add_settings_section(
		'icase_section_settings',
	__( '', 'icase' ),
	'icase_section_settings_cb',
	'icase'
	);
	
	// register a new field in the "icase_section_settings" section, inside the "icase" page
	add_settings_field(	'sigla',
	__( 'Sigla do cliente', 'icase' ),
	'icase_field_sigla_cb',
	'icase',
	'icase_section_settings',array('label_for' => 'sigla','class' => 'icase_row','icase_custom_data' => 'sigla')
	);

	// register a new field in the "icase_section_settings" section, inside the "icase" page
	add_settings_field(	'debito',
	__( 'Bloquear usuários em débito', 'icase' ),
	'icase_field_debito_cb',
	'icase',
	'icase_section_settings',array('label_for' => 'debito','class' => 'icase_row','icase_custom_data' => 'debito')
	);

	// register a new field in the "icase_section_settings" section, inside the "icase" page
	add_settings_field(	'debito_msg',
	__( 'Mensagem para usuários em débito', 'icase' ),
	'icase_field_debito_msg_cb',
	'icase',
	'icase_section_settings',array('label_for' => 'debito_msg','class' => 'icase_row','icase_custom_data' => 'debito_msg')
	);

   }
	
   /**
	* register our icase_settings_init to the admin_init action hook
	*/
   add_action( 'admin_init', 'icase_settings_init' );
	
   /**
	* custom option and settings:
	* callback functions
	*/
	
   
   function icase_field_sigla_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'icase_options' );
	// output the field
	?>
		<input name="icase_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $options['sigla'] ?>" />
		<p class="description">
			<?php esc_html_e( __('A sigla é fornecida pela Itarget Tecnologia.', 'icase') ); ?>
		</p>
		<?php
   }

   function icase_field_debito_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'icase_options' );
	// output the field
	?>
		<input type="checkbox" name="icase_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="1" <?php echo ($options['debito'] == '1' ? 'checked':''); ?> />
		<?php
   }

   function icase_field_debito_msg_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
	$options = get_option( 'icase_options' );
	// output the field
	?>
		<textarea cols="80" rows="5" name="icase_options[<?php echo esc_attr( $args['label_for'] ); ?>]"  /><?php echo $options['debito_msg']; ?></textarea>
		<p class="description">
			<?php esc_html_e( __('A mensagem aparecerá tanto no Espaço do Associado quanto nas páginas restritas com bloqueio por débito.', 'icase') ); ?>
		</p>
		<?php
   }
	
   /**
	* top level menu
	*/
	function icase_options_page()
	{
		add_menu_page(
			'iCase - Módulo de integração',
			'iCase',
			'manage_options',
			'icase',
			'icase_options_page_html',
			plugin_dir_url(__FILE__) . 'images/icon_icase.png',
			20
		);
	}
	add_action('admin_menu', 'icase_options_page');
	
   /**
	* top level menu:
	* callback functions
	*/
function icase_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	// add error/update messages
	
	// check if the user have submitted the settings
	// wordpress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'icase_messages', 'icase_message', __( 'As modificações foram salvas.', 'icase' ), 'updated' );
	}
	
	// show error/update messages
	settings_errors( 'icase_messages' );
	?>
	<div class="wrap">
		<h1>
			<?php echo esc_html( get_admin_page_title() ); ?>
		</h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "icase"
			settings_fields( 'icase' );
			// output setting sections and their fields
			// (sections are registered for "icase", each field is registered to a specific section)
			do_settings_sections( 'icase' );
			// output save settings button
			submit_button( __('Salvar', 'icase') );
			?>
		</form>
	</div>
	<?php

}
