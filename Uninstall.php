<?php
//Compruebo que sea Wordpress
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')){ 
	exit; 
}

register_uninstall_hook( __FILE__, 'jmr_unistall' );

// Función eliminar. Elimino las tablas creadas por el plugin de la BBDD

function jmr_uninstall() {
    global $wpdb;

    $removeTables = array(
        $wpdb->prefix . "jmr",
    );

    foreach($removeTables as $table){
        $wpdb->query("DROP TABLE IF EXISTS `" . $table . "`");
    }
}

// Borrar definitivemente el plugin

jmr_uninstall();

?>