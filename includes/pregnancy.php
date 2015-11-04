<?php
require_once( ABSPATH . '/wp-load.php');
include dirname( __FILE__ ). '/pregnancy_language.php'; ?>
<script type='text/javascript'>

function getdetails(){
	var sname = $('#jmr_name').val();
	var smail = $('#jmr_email').val();
	var sday = $('#jmr_day').val();
	var smonth = $('#jmr_month').val();
	var syear = $('#jmr_year').val();
	var scheck = document.getElementById('jmr_check');

		// Date validation start
	if ((smonth==4 || smonth==6 || smonth==9 || smonth==11) && sday ==31) {
		$('#pregnancyContent').html('<?php echo $lang['HTML_WRONG_DATE']; ?>');
		return false;
	}
	else if (smonth == 2) {
		var checkYear = (syear % 4 == 0 && (syear % 100 != 0 || syear % 400 == 0));
		if (sday> 29 || (sday ==29 && !checkYear)) {
			alert('<?php echo $lang['HTML_WRONG_DATE']; ?>');
			return false;
		}
	}
	else if (syear == <?php echo date('Y'); ?> && smonth == <?php echo date('n'); ?> && sday > <?php echo date('j'); ?>) {
			alert('<?php echo $lang['HTML_WRONG_DATE_FAR']; ?>');
			return false;
	}
	else if (syear == <?php echo date('Y'); ?> && smonth > <?php echo date('n'); ?>) {
			alert('<?php echo $lang['HTML_WRONG_DATE_FAR']; ?>');
			return false;
	}
	else if (syear == '<?php echo $lang['HTML_SELECT_YEAR']; ?>'  ||  smonth == '<?php echo $lang['HTML_SELECT_MONTH']; ?>'  ||  sday == '<?php echo $lang['HTML_SELECT_DAY']; ?>') {
			alert('<?php echo $lang['HTML_WRONG_DATE_SELECT']; ?>');
			return false;
	}
	else if (sname == ''  ||  smail == '') {
			alert("Debe rellenar todos los campos por favor.");
			return false;
	}
	if (!scheck.checked ) {
			alert("Debe aceptar las condiciones de la matrona.");
			return false;
	}

	// Date validation end
	var go = $('#go').val();
	$.ajax({
		type: 'POST',
		url: '/wp-content/plugins/JmrSusCalc/includes/pregnancy_class.php',
		data: {jmr_day:sday, jmr_month:smonth, jmr_year:syear, g:go, jmr_name:sname, jmr_email:smail}
	}).done(function(pregnancy) {
		$('#pregnancyContent').html(pregnancy).slideDown('1000');
	});
}
</script>

<div class="calculadora">
		<div class="sep_contenedor_calculadora">
				<h2>Calcula tu embarazo</h2>
				<h4 style="text-align: center;">Una matrona te enviará consejos para tu embarazo (1 email cada mes)</h4>
			<div class="contenedor_calculadora">
				<div class="grid-box width33">
					<div class="jmr-o">
						<div class="img_calculadora">
							<img class="img_calculadora" src="/wp-content/plugins/JmrSusCalc/imagenes/embarazada.jpg" alt="">
						</div>
					</div>
				</div>
				<div class="grid-box width66">
					<div class="jmr-o">
						<div class="cont_seleccion">
							<h2>¿Cuándo fue el primer día de último período menstrual?</h2>
							<div class="cont_fecha">
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
								<input type="text" name="jmr_name" pattern="[a-zA-Z0-9 ]+" value="<?php ( isset( $_POST["jmr_name"] ) ? esc_attr( $_POST["jmr_name"] ) : '' ) ?>" size="40" id="jmr_name" placeholder="Tu Nombre" required />
								<input type="email" name="jmr_email" value="<?php ( isset( $_POST["jmr_email"] ) ? esc_attr( $_POST["jmr_email"] ) : '' ) ?>" size="40" id="jmr_email" placeholder="Tu Email" required />
							</div>
							<div class="boton_calcular">
								<input type="hidden" id="go" name="go" value="1" />
								<input type="submit" value="<?php echo $lang['HTML_CALCULATE']; ?>" onClick = "getdetails()" />
								<input type="checkbox" name="jmr_check" id="jmr_check" value="1" checked="checked" required ><p><a href="#" target="_blank"> He leído las condiciones</a> &nbsp; y acepto recibir correos de la matrona.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div id="pregnancyContent" style="display: block;"></div>
</div>
