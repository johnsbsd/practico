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

    // EXPLORADOR DE ARCHIVOS
	?>
		<div id="contenedor_explorador_archivos" style="margin-left:17px;">
			<select id="path_exploracion_archivos" size="1" class="form-control btn-primary btn-xs" onchange="ExplorarPath(1)">
				<option value="<?php echo $PCO_PCODER_RaizExploracionArchivos; ?>">     PATH: [<?php echo $PCO_PCODER_RaizExploracionArchivos; ?>] (<?php echo $MULTILANG_PCODER_Predeterminado; ?>)</option>
				<optgroup label="<?php echo $MULTILANG_PCODER_Comunes; ?>">
					<option value="/">[/] <?php echo $MULTILANG_PCODER_PathDisco; ?></option>
					<option value="<?php echo $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR; ?>">[<?php echo $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR; ?>] <?php echo $MULTILANG_PCODER_PathFull; ?></option>
				</optgroup>
			</select>
			
			<div id="contenedor_buscador_archivos" style="display: none;">
					<div class=" well-sm">
						<div align="center">
							<button OnClick="BuscadorArchivosVisible=1; PCODER_DesactivarPanelIzquierdo(); ActivarBuscadorArchivos();" class="btn btn-warning btn-xs"  data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_Cerrar; ?>"><i class="fa fa-times fa-fw" ></i> <b><?php echo $MULTILANG_PCODER_Cerrar; ?></b>: <?php echo $MULTILANG_PCODER_Buscar; ?> <?php echo $MULTILANG_PCODER_Archivo; ?></button>
						</div>
						<!-- FORMULARIO BUSCAR -->
						<form autocomplete="off" name="FormBuscadorArchivos" id="FormBuscadorArchivos" onsubmit="LanzarBusquedaArchivos(); return false;">
						<div class="checkbox">
						  <label style="color:#FFFFFF; font-size:11px;"><input name="SensibleMayuscula" id="SensibleMayuscula" type="checkbox"><?php echo $MULTILANG_PCODER_SensibleMayusculas; ?></label>
						</div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon" id="sizing-addon3">
								<i class="fa fa-search fa-fw"></i>
							</span>
							<input type="text" id="archivo_busqueda" name="archivo_busqueda" class="form-control input-mini btn-block btn-xs" placeholder="<?php echo $MULTILANG_PCODER_Nombre.' '.$MULTILANG_PCODER_Archivo; ?> (min 3 char)">
						</div>

						</form>
						<div id="resumen_buscador_archivo"></div>
						<ul  id="resultados_buscador_archivo" class=" jqueryFileTree buscador_archivos"></ul>
					</div>
			</div>


			<div id="marco_operaciones_archivos" class="row" style="margin-top:5px; margin-bottom:10px;">
				<div class="col-md-12" align="center">
					<button OnClick="ActivarBuscadorArchivos();" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_Buscar.' '.$MULTILANG_PCODER_Archivo; ?>"><i class="fa fa-search fa-fw"></i></button>
					<button OnClick="OperacionFS_CrearArchivo();" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_CrearArchivo; ?>"><i class="fa fa-file fa-fw"></i></button>
					<button OnClick="OperacionFS_CrearCarpeta();" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_CrearCarpeta; ?>"><i class="fa fa-folder fa-fw"></i></button>
					<button OnClick="OperacionFS_EditarPermisos();" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_EditarPermisos; ?>"><i class="fa fa-lock fa-fw"></i></button>
					<!--<button class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_SubirArchivo; ?>"><i class="fa fa-upload fa-fw"></i></button>-->
					<button OnClick="ExplorarPath();" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_RecargarExplorador; ?>"><i class="fa fa-refresh fa-fw"></i></button>
					<button OnClick="OperacionFS_EliminarElemento();" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_EliminarElemento; ?>"><i class="fa fa-trash fa-fw"></i></button>
				</div>
			</div>
			
			<div id="marco_explorador" class="explorador_archivos"></div>
		</div>