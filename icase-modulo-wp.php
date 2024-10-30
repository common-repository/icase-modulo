<?php

/**
 *
 * @link              http://itargettecnologia.com.br
 * @since             1.1.0
 * @package           Icase_Modulo_Wp
 *
 * @wordpress-plugin
 * Plugin Name:       iCase - Módulo WordPress
 * Plugin URI:        http://itarget.com.br
 * Description:       Este módulo faz a integração entre o seu portal e o sistema iCase, promovendo o acesso restrito a usuários associados à sua entidade. Ele também oferece a Área do Associado, onde o usuário pode visualizar o seu perfil e outras informações.
 * Version:           1.1.0
 * Author:            Itarget Tecnologia
 * Author URI:        http://itargettecnologia.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       icase-modulo-wp
 * Domain Path:       /languages
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

//define( PLUGIN_VERSION, '1.1.0' );

function activate_icase_modulo_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-icase-modulo-wp-activator.php';
	Icase_Modulo_Wp_Activator::activate();
}

function deactivate_icase_modulo_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-icase-modulo-wp-deactivator.php';
	Icase_Modulo_Wp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_icase_modulo_wp' );
register_deactivation_hook( __FILE__, 'deactivate_icase_modulo_wp' );

require plugin_dir_path( __FILE__ ) . 'includes/class-icase-modulo-wp.php';

function session_header(){
	$options = get_option( 'icase_options' );
	session_start();

	if(isset($_POST['login'])){
		
		$dados_login = $_POST['login'];
		$object = new ItargetRequest();
		// URL para processar o login no iCase
		$object->setUrl('http://icase.' . $options[sigla] . '.itarget.com.br/estacao/index/login-site/');
		$object->setParams($dados_login);
		
		$dados = $object->getResposta();
	
		if ($dados['logado'] == true) {
			$object->montaSessao();
			// header('Location: espaco-do-associado/');
		}
		$_SESSION['mensagem_login'] = $mensagem = $dados['mensagen'];
	}
	
	if(isset($_GET['act']) && $_GET['act'] == 'logoff'){
		@session_start();
		session_destroy();	
		$url          = explode('?', $_SERVER['HTTP_REFERER']);
		$pag_referida = $url[0];
		header("Location: $pag_referida");
		exit;
	}
}
add_action('init', 'session_header');

function shortcode_restrito_init()
{
	function shortcode_restrito( $atts, $content = null ) {
		$atributos = shortcode_atts(
			array(
			   'bloquear_debito' => '',
			 ), 
			$atts
		);
		$options = get_option( 'icase_options' );
		if ($_SESSION['logado'] == 's' && $options['debito'] == 1 || $atributos['bloquear_debito'] =='s') {
			if($_SESSION['situacao_financeira'] == 'D') {
				$content = '<p><em>'. __('Conteúdo restrito. <br>', 'icase') . $options['debito_msg'] .'</em></p>';
				return $content;
			} else {
				$content = do_shortcode($content);
				return $content;
			}
		} elseif($_SESSION['logado'] == 's') {
			$content = do_shortcode($content);
			return $content;
		}
		else {
			$content = '<p><em>'. __('Conteúdo restrito. Necessário fazer login', 'icase') . '</em></p>';
			return $content;
		}
	}
	add_shortcode('restrito', 'shortcode_restrito');
}
add_action('init', 'shortcode_restrito_init');

function shortcode_espaco_associado_init() {
	function shortcode_espaco_associado( $atts, $content = null ) {
		$options = get_option( 'icase_options' );
		if (  $_SESSION['logado'] == 's'  ) {
			$content = '<div>';
			$content .=		'<p>'. __('Olá', 'icase') . ', <strong>' . $_SESSION['nome'] . '</strong>! (<a class="" href="'. get_bloginfo('url') .'?act=logoff" title="Sair">'. __('Sair', 'icase') . '</a>)</p>';
			$content .= 	'<p>'. __('Seja bem-vindo(a) ao espaço do associado.', 'icase') . '</br>';
			if($_SESSION['situacao_financeira'] == 'D') {
				$content .= 	'<b>'. $options[debito_msg] . '</b>';
			}
			$content .= 	'</p>';
			$content .= 	'<ul>';
			$content .= 		'<li><a href="https://icase.' . $options[sigla] . '.itarget.com.br/estacao/index/autenticar-hash/hash/' . $_SESSION['hash'] . '/link/' . base64_encode('estacao/meu-perfil') . '" target="_blank" title="'. __('Cadastro', 'icase') . '">Cadastro</a></li>';
			$content .= 		'<li><a href="https://icase.' . $options[sigla] . '.itarget.com.br/estacao/index/autenticar-hash/hash/' . $_SESSION['hash'] . '/link/' . base64_encode('estacao/inscricoes/index') .'"	target="_blank" title="Taxas">'. __('Taxas', 'icase') . '</a></li>';
			$content .= 	'</ul>';
			$content .= '</div>';
						
			return $content;
		}
		else {
			$content = '<p><em>'. __('Conteúdo restrito. Necessário fazer login.', 'icase') . '</em></p>';
			return $content;
		}
	}
	add_shortcode('espaco-do-associado', 'shortcode_espaco_associado');
}
add_action('init', 'shortcode_espaco_associado_init');


/**
 * @since    1.0.0
 */
function run_icase_modulo_wp() {

	$plugin = new Icase_Modulo_Wp();
	$plugin->run();

}
run_icase_modulo_wp();

