<div class="wrap">
	<h2>Suscriptores</h2>
	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder columns-5">

			<div class="meta-box-sortables">
			                <div class="beforebox">
			                       <h3>Suscripción y Cálculo de Embarazo</h3>
								<div class="inside">
									<p>Plugin que permite mediante una <strong>calculadora de embarazo basada en el LMP</strong> (último período menstrual) generar una lista de suscriptores al blog para cualquier proposito.</p>										
									<p>En esta misma pantalla encontrará todos los usuarios que hayan utilizado la calculadora registrados con todos los datos necesarios para una campaña de mailing.</p>
									</br>
									<p style="text-align: right;">Plugin desarrollado por <a href="http://www.1024mbits.com" target="_blank"><img srcset="/wp-content/plugins/JmrSusCalc/imagenes/1024Mbits.png" alt="1024Mb IT Solution"></a>
								</div>
							</div>
			  		</div>
            <br class="clear">
		
			<!-- main content -->
			<div id="post-body-content">
				
			<form method="post" action="?page=<?php echo esc_js(esc_html($_GET['page'])); ?>">
            <input name="jmr_remove" value="1" type="hidden" />
            			<?php 
						if ($_SERVER['REQUEST_METHOD']=="POST" and $_POST['jmr_remove']) {
							if ($_GET['rem']) $_POST['rem'][] = $_GET['rem'];
							$count = 0;
							if (is_array($_POST['rem'])) {
								foreach ($_POST['rem'] as $id) { 
									$wpdb->query("delete from ".$wpdb->prefix."jmr where id = '".$wpdb->escape($id)."' limit 1"); 
									$count++; 
								}
								$message = $count." Los suscriptores han sido borrados.";
							}
						}

            			?>
					
	
						<table cellspacing="0" class="wp-list-table widefat fixed subscribers">
                          <thead>
                            <tr>
                                <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
                                <th style="" class="manage-column column-name" id="name" scope="col">Nombre<span class="sorting-indicator"></span></th>
                                <th style="" class="manage-column column-email" id="email" scope="col"><span>Email</span><span class="sorting-indicator"></span></th>
                                <th style="" class="manage-column column-day" id="day" scope="col"><span>Día</span><span class="sorting-indicator"></span></th>
                                <th style="" class="manage-column column-month" id="month" scope="col"><span>Mes</span><span class="sorting-indicator"></span></th>
                                <th style="" class="manage-column column-year" id="year" scope="col"><span>Año</span><span class="sorting-indicator"></span></th>
                            </thead>
                        
                            <tfoot>
                            <tr>
                                <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
                                <th style="" class="manage-column column-name" scope="col"><span>Nombre</span><span class="sorting-indicator"></span></th>
                                <th style="" class="manage-column column-email" scope="col"><span>Email</span><span class="sorting-indicator"></span></th>
                                <th style="" class="manage-column column-day" scope="col"><span>Día</span><span class="sorting-indicator"></span></th>
                                <th style="" class="manage-column column-month" scope="col"><span>Mes</span><span class="sorting-indicator"></span></th>
                                <th style="" class="manage-column column-year" scope="col"><span>Año</span><span class="sorting-indicator"></span></th>                               
                            </tfoot>
                        
                            <tbody id="the-list">
                            
                            <?php 
                            
								$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."jmr");
								if (count($results)<1) echo '<tr class="no-items"><td colspan="6" class="colspanchange">No hay suscriptores todavía.</td></tr>';
								else {
									foreach($results as $row) {
	
										echo '<tr>
													<th class="check-column" style="padding:5px 0 2px 0"><input type="checkbox" name="rem[]" value="'.esc_js(esc_html($row->id)).'"></th>
													<td>'.esc_js(esc_html($row->name)).'</td>
  													<td>'.esc_js(esc_html($row->email)).'</td>
  													<td>'.esc_js(esc_html($row->day)).'</td>
  													<td>'.esc_js(esc_html($row->month)).'</td>
  													<td>'.esc_js(esc_html($row->year)).'</td>
											  </tr>';
											  
											  
											  
	
									}
								}
							
							?>
                            
                                
                            </tbody>
                        </table>
                        <br class="clear">
						<input class="button" name="submit" type="submit" value="Remover seleccionados" /> <a class="button" href="<?php echo plugins_url( 'includes/export-csv.php', __FILE__ ); ?>">Exportar como CSV</a>
				</form>
				<br class="clear">
                
					<div class="meta-box-sortables">
			                <div class="postbox">
			                        <h3><span>Como configurar el Plugin</span></h3>
								<div class="inside">
									<p>Para suscribir a los lectores a cualquier servicio de mailing (MailChimp, MkDirector, etc). Sólo necesita exportar los suscriptores e importarlos a su conveniencia.</br>Para realizar la exportación de suscriptores debe hace click en <strong>Exportar como CSV</strong> y luego importar el archivo generado a su servicio de mailing preferido según las indicaciones de su proveedor.</p>										
									<p>Solo hay que agregar el shortcode <strong>[MostrarFormulario]</strong> a cualquier página o post donde se desee incluir.</p>
								</div>
							</div>
			  		</div>                
			</div> 
            <br class="clear">
	</div>
	
</div> 