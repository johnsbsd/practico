<?php
	/*
	 _
	|_) _ _  _ _|_. _ _					  	Copyright (C) 2012-2022
	|  | (_|(_  | |(_(_) 				  	John F. Arroyave Gutiérrez
	  www.practico.org					  	unix4you2@gmail.com
                                            All rights reserved.
    
	 This program is free software: you can redistribute it and/or modify
	 it under the terms of the GNU General Public License as published by
	 the Free Software Foundation, either version 3 of the License, or
	 (at your option) any later version.

	 This program is distributed in the hope that it will be useful,
	 but WITHOUT ANY WARRANTY; without even the implied warranty of
	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 GNU General Public License for more details.

	 You should have received a copy of the GNU General Public License
	 along with this program.  If not, see <http://www.gnu.org/licenses/>
	 
	            --- TRADUCCION NO OFICIAL DE LA LICENCIA ---

     Esta es una traducción no oficial de la Licencia Pública General de
     GNU al español. No ha sido publicada por la Free Software Foundation
     y no establece los términos jurídicos de distribución del software 
     publicado bajo la GPL 3 de GNU, solo la GPL de GNU original en inglés
     lo hace. De todos modos, esperamos que esta traducción ayude a los
     hispanohablantes a comprender mejor la GPL de GNU:
	 
     Este programa es software libre: puede redistribuirlo y/o modificarlo
     bajo los términos de la Licencia General Pública de GNU publicada por
     la Free Software Foundation, ya sea la versión 3 de la Licencia, o 
     (a su elección) cualquier versión posterior.

     Este programa se distribuye con la esperanza de que sea útil pero SIN
     NINGUNA GARANTÍA; incluso sin la garantía implícita de MERCANTIBILIDAD
     o CALIFICADA PARA UN PROPÓSITO EN PARTICULAR. Vea la Licencia General
     Pública de GNU para más detalles.

     Usted ha debido de recibir una copia de la Licencia General Pública de
     GNU junto con este programa. Si no, vea <http://www.gnu.org/licenses/>
	*/

    // PREFERENCIAS
	
	PCODER_AbrirDialogoModal("myModalOPERARFS",$MULTILANG_PCODER_OperacionesFS); ?>

			<div class="row">
				<div id="cuadro_entrada_path_operacion_elemento">
					<div class="col-md-12">
						<label for="path_operacion_elemento"><?php echo $MULTILANG_PCODER_Ubicacion; ?>:</label><br>
						<div class="input-group">
						  <span class="input-group-addon"><i class="fa fa-hdd-o fa-fw"></i></span>
						  <input type="text" name="path_operacion_elemento" id="path_operacion_elemento" class="form-control btn-block input-mini btn-xs" readonly>
						</div>
						<br>					
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
						<div id="cuadro_entrada_marco_explorador">
							<label for="marco_explorador_creacionarchivo"><?php echo $MULTILANG_PCODER_Explorar; ?>:</label>					
							<div id="marco_explorador_creacionarchivo" class="explorador_archivos_mini"></div>
						</div>
				</div>
				<div class="col-md-6">
					
						<div id="cuadro_entrada_operacion_fs">
							<label for="operacion_fs"><?php echo $MULTILANG_PCODER_Operacion; ?>:</label>
							<select id="operacion_fs" size="1" class="form-control btn-primary">
								<option value="CrearArchivo"><?php echo $MULTILANG_PCODER_CrearArchivo; ?></option>
								<option value="CrearCarpeta"><?php echo $MULTILANG_PCODER_CrearCarpeta; ?></option>
								<option value="EditarPermisos"><?php echo $MULTILANG_PCODER_EditarPermisos; ?></option>
								<option value="SubirArchivo"><?php echo $MULTILANG_PCODER_SubirArchivo; ?></option>
								<option value="EliminarElemento"><?php echo $MULTILANG_PCODER_EliminarElemento; ?></option>
							</select>
						</div>

						<div id="cuadro_entrada_nombre_elemento">
							<label for="nombre_elemento"><?php echo $MULTILANG_PCODER_Nombre; ?>:</label>
							<input type="text" name="nombre_elemento" id="nombre_elemento" class="form-control btn-block input-mini btn-xs">
						</div>

						<div id="cuadro_entrada_permisos_elemento">
							<label for="permisos_elemento"><?php echo $MULTILANG_PCODER_Permisos; ?> (octal):</label>
							<input type="text" name="permisos_elemento" id="permisos_elemento" class="form-control btn-block input-mini btn-xs">
							<label for="propietario_elemento"><?php echo $MULTILANG_PCODER_Propietario; ?>:</label>
							<input type="text" name="propietario_elemento" id="propietario_elemento" class="form-control btn-block input-mini btn-xs">
						</div>

				</div>
			</div>

    <?php 
        $barra_herramientas_modal='
        <button OnClick="EjecutarOperacionFS();" type="button" class="btn btn-success"><i class="fa fa-check fa-fw"></i> '.$MULTILANG_PCODER_Aceptar.'</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> '.$MULTILANG_PCODER_Cancelar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>';
        PCODER_CerrarDialogoModal($barra_herramientas_modal);