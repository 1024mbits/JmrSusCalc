<?php 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
include_once 'pregnancy_language.php'; 
$go = $_POST["g"];
$check = $_POST['jmr_email'];
$check2 = $_POST['jmr_name'];
if ($go =="1" and $check !='' and $check2 !='') 
{ 
	setlocale(LC_ALL, 'es_ES');
	$sday = $_POST["jmr_day"];
	$smonth = $_POST["jmr_month"];
	$syear = $_POST["jmr_year"];
	$today = mktime(0,0,0,date("n"),date('j'),date("Y"));
	$last = mktime (0,0,0,$sday, $smonth, $syear) ;
	$gest = 24192000; // 9 months
	$due = $last + $gest; 
	$conception = $last + 1209600; // + 14 days
	$test = $last + ( 5 * 7 * 24 * 60 * 60 ); // + 5 weeks (5weeks*7days*24hours*60minutes*60seconds)
	$secondtrimester = $last + ( 12 * 7 * 24 * 60 * 60 ); // + 12 weeks (12weeks*7days*24hours*60minutes*60seconds)
	$firstmove = $last + ( 18 * 7 * 24 * 60 * 60 );
	$firstheartbeat = $last + ( 6 * 7 * 24 * 60 * 60 );
	$thirdtrimester = $last + ( 27 * 7 * 24 * 60 * 60 ); // + 27 weeks (27weeks*7days*24hours*60minutes*60seconds)
	$day = intval(date("d", $due));
	$month = intval(date("n", $due));
	$year = intval(date("Y", $due));
	$pregnancy_weeks = number_format((($today - $last)/60/60/24/7),0);
	if ($due<$today) { $pregnancy_weeks = 0; }
	if ($pregnancy_weeks==1) { 
		$weeks = $lang['RESULT_PREGNANCY_WEEK']; 
	} else {
		$weeks = $lang['RESULT_PREGNANCY_WEEKS']; 
	}
	if(($month==1 && $day>20)||($month==2 && $day<20)){
		$zodiac = $lang['RESULT_ZODIAC_AQUARIUS'];
	}else if(($month==2 && $day>18 )||($month==3 && $day<21)){
		$zodiac = $lang['RESULT_ZODIAC_PISCES'];
	}else if(($month==3 && $day>20)||($month==4 && $day<21)){
		$zodiac = $lang['RESULT_ZODIAC_ARIES'];
	}else if(($month==4 && $day>20)||($month==5 && $day<22)){
		$zodiac = $lang['RESULT_ZODIAC_TAURUS'];
	}else if(($month==5 && $day>21)||($month==6 && $day<22)){
		$zodiac = $lang['RESULT_ZODIAC_GEMINI'];
	}else if(($month==6 && $day>21)||($month==7 && $day<24)){
		$zodiac = $lang['RESULT_ZODIAC_CANCER'];
	}else if(($month==7 && $day>23)||($month==8 && $day<24)){
		$zodiac = $lang['RESULT_ZODIAC_LEO'];
	}else if(($month==8 && $day>23)||($month==9 && $day<24)){
		$zodiac = $lang['RESULT_ZODIAC_VIRGIN'];
	}else if(($month==9 && $day>23)||($month==10 && $day<24)){
		$zodiac = $lang['RESULT_ZODIAC_BALANCE'];
	}else if(($month==10 && $day>23)||($month==11 && $day<23)){
		$zodiac = $lang['RESULT_ZODIAC_SCORPION'];
	}else if(($month==11 && $day>22)||($month==12 && $day<23)){
		$zodiac = $lang['RESULT_ZODIAC_SAGITTARIUS'];
	}else if(($month==12 && $day>22)||($month==1 && $day<21)){
		$zodiac = $lang['RESULT_ZODIAC_CAPRICORN'];
	}
	$html .= '<div class="linea_respuesta">' .$lang['RESULT_LAST_CYCLE'].strftime("%d de %B de %Y", $last).'</div>';
	$html .= '<div class="linea_respuesta felicitaciones">' .$lang['RESULT_NEW_BORN'].strftime("%d de %B de %Y", $due).$lang['RESULT_ZODIAC'].$zodiac.'</div>';
	$html .= '<div class="linea_respuesta">' .$lang['RESULT_CONCEPTION'].strftime("%d de %B de %Y", $conception).$lang['RESULT_TEST'].strftime("%d de %B de %Y", $test).'</div>';
	$html .= '<div class="linea_respuesta info_extra"><strong>'.$lang['RESULT_EXTRA_INFO'].'</strong></div>';
	if ($pregnancy_weeks==0) {
		$html .= $lang['RESULT_PREGNANCY_NOT']."<br />";
		$html .= $lang['RESULT_FIRST_TRIM_END_OLD'].strftime("%d de %B de %Y", $secondtrimester).".<br />";
		$html .= $lang['RESULT_SECOND_TRIM_END_OLD'].strftime("%d de %B de %Y", $thirdtrimester).".<br />";
	} else {
		$html .= '<ul class="lista_calculadora">';
		$html .= '<li>' .$lang['RESULT_PREGNANCY'].$lang['RESULT_PREGNANCY_PREGNANT'].$pregnancy_weeks.$weeks."</li>";
		$html .= '<li>' .$lang['RESULT_FIRST_MOVE'].strftime("%d de %B de %Y", $firstmove).'.</li>';
		$html .= '<li>' .$lang['RESULT_HEART_BEAT'].strftime("%d de %B de %Y", $firstheartbeat).'.</li>';
		$html .= '<li>' .$lang['RESULT_FIRST_TRIM_END'].strftime("%d de %B de %Y", $secondtrimester).'.</li>';
		$html .= '<li>' .$lang['RESULT_SECOND_TRIM_END'].strftime("%d de %B de %Y", $thirdtrimester).'.</li>';
		$html .= '</ul>';
	}
	
	echo $html;
}
$go = $_POST["g"];
if ($go =="1")
{ 
	global $wpdb;

	$name = sanitize_text_field( $_POST['jmr_name'] );
	$email = sanitize_email( $_POST['jmr_email'] );
	$day = $_POST['jmr_day'];
	$month = $_POST['jmr_month'];
	$year = $_POST['jmr_year'];

	if ($email != '') {
		$exists = mysql_query("SELECT * FROM ".$wpdb->prefix."jmr where email like '".$wpdb->escape($email)."' limit 1");
		if (mysql_num_rows($exists) <1) {
			$wpdb->query("insert into ".$wpdb->prefix."jmr (name, email, day, month, year) values ('".$wpdb->escape($name)."', '".$wpdb->escape($email)."', '".$wpdb->escape($day)."', '".$wpdb->escape($month)."', '".$wpdb->escape($year)."')");
		}
	}
}
?>