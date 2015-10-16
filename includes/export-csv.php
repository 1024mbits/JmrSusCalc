<?php 
require_once '../../../../wp-load.php';
if (current_user_can('manage_options')) {
	header("Content-type: application/force-download"); 
	header('Content-Disposition: inline; filename="Suscriptores'.date('dmY').'.csv"');  
	$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."jmr");
	echo "Nombre, Email, Fecha de Embarazo\r\n";
	if (count($results))  {
		foreach($results as $row) {
			echo ''.esc_js(esc_html($row->name)).','.esc_js(esc_html($row->email)).','.esc_js(esc_html($row->day)).'/'.esc_js(esc_html($row->month)).'/'.esc_js(esc_html($row->year)).';';
		}
	}
}

?>