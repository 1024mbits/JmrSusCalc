<?php 
include_once 'pregnancy_language.php'; ?>
<head>
<script type='text/javascript'>
function getdetails(){
	var sname = $('#jmr_name').val();
	var smail = $('#jmr_email').val();
	var sday = $('#jmr_day').val();
	var smonth = $('#jmr_month').val();
	var syear = $('#jmr_year').val();
		// Date validation start
	if ((smonth==4 || smonth==6 || smonth==9 || smonth==11) && sday ==31) {
		$('#pregnancyContent').html('<?php echo $lang['HTML_WRONG_DATE']; ?>');
		return false;
	}
	else if (smonth == 2) {
		var checkYear = (syear % 4 == 0 && (syear % 100 != 0 || syear % 400 == 0));
		if (sday> 29 || (sday ==29 && !checkYear)) {
			$('#pregnancyContent').html('<?php echo $lang['HTML_WRONG_DATE']; ?>');
			return false;
		}
	}
	else if (syear == <?php echo date('Y'); ?> && smonth == <?php echo date('n'); ?> && sday > <?php echo date('j'); ?>) {
			$('#pregnancyContent').html('<?php echo $lang['HTML_WRONG_DATE_FAR']; ?>');
			return false;
	}
	else if (syear == <?php echo date('Y'); ?> && smonth > <?php echo date('n'); ?>) {
			$('#pregnancyContent').html('<?php echo $lang['HTML_WRONG_DATE_FAR']; ?>');
			return false;
	}
	else if (syear == '<?php echo $lang['HTML_SELECT_YEAR']; ?>'  ||  smonth == '<?php echo $lang['HTML_SELECT_MONTH']; ?>'  ||  sday == '<?php echo $lang['HTML_SELECT_DAY']; ?>') {
			$('#pregnancyContent').html('<?php echo $lang['HTML_WRONG_DATE_SELECT']; ?>');
			return false;
	}
	// Date validation end
	var go = $('#go').val();
	$.ajax({
		type: 'POST',
		url: '/wp-content/plugins/JmrSusCalc/includes/pregnancy_class.php',
		data: {jmr_day:sday, jmr_month:smonth, jmr_year:syear, g:go, jmr_name:sname, jmr_email:smail}
	}).done(function(pregnancy) {
		$('#pregnancyContent').html(pregnancy);
	});
}
</script>
</head>
<div class="container">
<h1><?php echo $lang['HTML_TITLE']; ?></h1>
<p><?php echo $lang['HTML_INTRO']; ?></p>
<div class="remitente">
<p>Su Nombre (requerido)</br>
	<input type="text" name="jmr_name" pattern="[a-zA-Z0-9 ]+" value="<?php ( isset( $_POST["jmr_name"] ) ? esc_attr( $_POST["jmr_name"] ) : '' ) ?>" size="40" id="jmr_name" placeholder="Su Nombre aquí" required="required" /></p>
<p>Su Email (requerido)</br>
	<input type="email" name="jmr_email" value="<?php ( isset( $_POST["jmr_email"] ) ? esc_attr( $_POST["jmr_email"] ) : '' ) ?>" size="40" id="jmr_email" placeholder="Su Email aquí" required="required" /></p>
</div>
<div class="selector">
<select id="jmr_day" name="jmr_day">
	<option><?php echo $lang['HTML_SELECT_DAY']; ?></option>
	<?php for ($i=1;$i<=31;$i++) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
</select>
<select id="jmr_month" name="jmr_month">
	<option><?php echo $lang['HTML_SELECT_MONTH']; ?></option>
	<?php for ($i=1;$i<=12;$i++) { echo '<option value="'.$i.'">'.$lang['HTML_MONTH_'.$i].'</option>'; } ?>
</select>
<select id="jmr_year" name="jmr_year">
	<option><?php echo $lang['HTML_SELECT_YEAR']; ?></option>
	<?php for ($i=date("Y")-1;$i<=date("Y");$i++) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
</select>
<input type="hidden" id="go" name="go" value="1" />
<input type="submit" value="<?php echo $lang['HTML_CALCULATE']; ?>" onClick = "getdetails()" />
</div>
<div id="pregnancyContent"></div>
</div>
