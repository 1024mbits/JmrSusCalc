<?php
/* 
Plugin Name: Suscripción y Calculadora de embarazo
Plugin URI: http://1024mbits.github.io/JmrSusCalc/
Description: Plugin personalizado para generar suscriptores al blog mediante calculadora de embarazo.
Version: 1.0
Author: Juan Manuel Rube
Author URI: http://www.1024mbits.com
License: Private
*/
// Instalación de las tablas en la BDD y activación del plugin
function jmr_install() {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	$table = $wpdb->prefix."jmr";

	$sql = "CREATE TABLE $table (
		id INT(9) NOT NULL AUTO_INCREMENT,
		name VARCHAR(200) NOT NULL,
		email VARCHAR(200) NOT NULL,
		day INT(200) NOT NULL,
		month INT(200) NOT NULL,
		year INT(200) NOT NULL,
		UNIQUE KEY id (id)
		) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}

register_activation_hook( __FILE__, 'jmr_install' );

// Desactivación del Plugin
function jmr_deactivation() {
}
	
register_deactivation_hook( __FILE__, 'jmr_deactivation' );

// Agrego el Menú al backend de Wordpress
function register_jmr_menu() {
	add_menu_page('Suscriptores', 'Suscriptores', 'add_users', dirname(__FILE__).'/AdminTemplate.php', '', 'dashicons-id', 30);
}
add_action('admin_menu', 'register_jmr_menu');

// Agrego los scripts y estilos css al plugin
add_action('wp_enqueue_scripts', 'jmr_script_calc');

function jmr_script_calc() {
	wp_register_style( 'jmr_style', plugins_url( '/css/jmr_style.css', __FILE__));
	wp_register_script( 'jmr_jquery', plugins_url( '/js/jquery-2-1-4.js', __FILE__), array( 'jquery' ), '2.1.4', true); 

	wp_enqueue_style( 'jmr_style' );
	wp_enqueue_script( 'jmr_jquery' );
}	

function crea_form_html() {
		
	echo '<iframe width="350" height="900" src="/wp-content/plugins/JmrSusCalc/includes/pregnancy.php"></iframe>';   
}
// Creo el Shortcode
add_shortcode('MostrarFormulario','crea_form_html');

// Habilito shortcodes en los widgets
add_filter('widget_text', 'do_shortcode', 11);
	
?>