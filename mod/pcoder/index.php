<?php
	/*
	Copyright (C) 2013  John F. Arroyave Gutiérrez
						unix4you2@gmail.com

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	*/	

	/*
		Title: PCODER - Practico CODe EditoR
		Ubicacion *[/mod/pcoder/index.php]*.  Archivo que contiene las funciones de enlace al modulo de Edicion de codigo
        
        Este modulo permite abrir archivos de codigo desde la web para editarlos directamente con las caracteristicas de cualquier editor de codigo

		Section: Modulos complementarios
	*/

	// Valida sesion activa de Practico
	@session_start();
	
    if (!isset($PCOSESS_SesionAbierta)) 
		{
			echo '<head><title>Error</title><style type="text/css"> body { background-color: #000000; color: #7f7f7f; font-family: sans-serif,helvetica; } </style></head><body><table width="100%" height="100%" border=0><tr><td align=center>&#9827; Acceso no autorizado !</td></tr></table></body>';
			die();
		}
    
	// Configuraciones basicas del modulo
	$PCODER_raiz_modulo = "mod/pcoder/";
	$PCODER_modelos = $PCODER_raiz_modulo."modelo/";
	$PCODER_vistas = $PCODER_raiz_modulo."vista/";
	$PCODER_controladores = $PCODER_raiz_modulo."controlador/";
	$PCODER_idiomas = $PCODER_raiz_modulo."idiomas/";

    //Llamar al controlador inicial de la aplicacion o modulo
    @require($PCODER_modelos.'modelo.php');
    @require($PCODER_vistas.'vista.php');
    @require($PCODER_controladores.'controlador.php');

    //Carga el archivo recibido, si no recibe nada carga un demo
    if (@$PCODER_archivo=="")
        $PCODER_archivo = "mod/pcoder/demo/archivo_demo.php";
    PCODER_cargar_archivo($PCODER_archivo);

    $PCODER_Mensajes=0;
    // Verifica que el archivo exista
    $existencia_ok=1;
    if (!file_exists($PCODER_archivo)) { $existencia_ok=0; $PCODER_Mensajes=1; } 
    
    // Verifica permisos de escritura
    $permisos_ok=1;
    $permisos_encontrados=@substr(sprintf('%o', fileperms($PCODER_archivo)), -4);
    if (!is_writable($PCODER_archivo) && $existencia_ok) { $permisos_ok=0; $PCODER_Mensajes=1; } 
    
    // Verifica si existe el directorio para el editor ACE
    $editor_ok=1;
    if (@!file_exists("inc/ace")) { $editor_ok=0; $PCODER_Mensajes=1; } 



/* ################################################################## */
/* ################################################################## */
/*
	Function: PCOMOD_GuardarArchivo
	Almacena un archivo previamente abierto con el PCODER

	Salida:
		Archivo para edicion en pantalla
*/
if ($PCO_Accion=="PCOMOD_GuardarArchivo") 
	{
        

	}


/* ################################################################## */
/* ################################################################## */
/*
	Function: PCOMOD_CargarPcoder
	Abre el Practico Code Editor y carga un archivo sobre el para su edicion

    Entradas:

        Normalmente los parametros son: ?PCO_Accion=cargar_pcoder&Presentar_FullScreen=1&Precarga_EstilosBS=1
        * Comando: javascript:PCO_VentanaPopup('index.php?PCO_Accion=PCOMOD_CargarPcoder&Presentar_FullScreen=1&Precarga_EstilosBS=1','Pcoder','toolbar=no, location=no, directories=0, directories=no, status=no, location=no, menubar=no ,scrollbars=no, resizable=yes, fullscreen=no, titlebar=no, width=800, height=600');

	Salida:
		Archivo para edicion en pantalla
*/
if ($PCO_Accion=="PCOMOD_CargarPcoder") 
	{
?>
<style type="text/css">
    html, body {
        margin: 0;
        padding: 0;
        /*height: 100%;*/
        /*min-height: 100%;*/
        width: 100%;
        background: #888888;  /* 002a36 | BFBFBF | 888888 */
        overflow-x: hidden;
        overflow-y: hidden;
    }
    #marco_editor_codigo { 
        margin-top:34px;
    }
    #editor_codigo { 
        width: 100%; 
        height: 600px;  /*Define el tamano segun resolucion*/
    }
</style>
<body>

<div id="contenedor_principal">

    <nav id="barra_superior" class="navbar navbar-default navbar-inverse navbar-fixed-top">
        <div class="container-fluid">

            <!-- LOGO PCODER -->
            <div class="navbar-header">
                <a class="navbar-brand" href=""><img src="img/pcoder.png"></a>
            </div>

            <!-- BARRA DE HERRAMIENTAS --> 
            <div class="navbar-form navbar-left">
                <a class="btn btn-warning btn-xs" OnClick="Guardar();"><i class="fa fa-save fa-fw"></i></a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn-default btn-xs" OnClick="Deshacer();"><i class="fa fa-undo"></i></a>
                <a class="btn btn-default btn-xs" OnClick="Rehacer();"><i class="fa fa-repeat"></i></a>
            </div>

            <!-- INFORMACION DEL ARCHIVO -->
            <ul class="nav navbar-nav navbar-form navbar-right">
                <li class="btn-default btn-xs btn-info">
                    &nbsp;<?php echo $MULTILANG_Tipo; ?> <span class="badge"><?php echo $PCODER_TipoElemento; ?></span>&nbsp;<br>
                    &nbsp;<?php echo $PCODER_FechaElemento; ?> <span class="badge"><?php echo $PCODER_TamanoElemento; ?> Kb</span>&nbsp;<br>
                </li>
            </ul>

        </div><!-- /.container-fluid -->
    </nav>

<div class="row">
<?php 
    if ($PCODER_Mensajes==1) echo '<br><br>';
    //Presenta mensajes de error o informacion
    if ($existencia_ok==0)
        mensaje('<i class="fa fa-warning text-info texto-blink"></i> '.$MULTILANG_Error.': '.$MULTILANG_ErrorExistencia.'. '.$MULTILANG_Cargando.'='.$PCODER_archivo, '', '', '', 'alert alert-danger alert-dismissible');
    if ($permisos_ok==0)
        mensaje('<i class="fa fa-warning text-info texto-blink"></i> '.$MULTILANG_Error.': '.$MULTILANG_ErrorRW.'. '.$MULTILANG_Estado.'='.$permisos_encontrados, '', '', '', 'alert alert-warning alert-dismissible');
    if ($editor_ok==0)
        {
            mensaje('<i class="fa fa-warning text-info texto-blink"></i> '.$MULTILANG_Error.': '.$MULTILANG_ErrorNoACE.': '.$PCODER_archivo, '', '', '', 'alert alert-danger alert-dismissible');
            //die();
        }
?>
</div>


<div id="marco_editor_codigo" class="row">
    <div class="row container-full">
        <div class="col-lg-12 container-full">
            <div class="form-group">
                <!-- Dispone el control de area de texto y el div donde se empotrara el editor -->
                
                <textarea id="area_texto" name="area_texto" style="visibility:hidden; display:none;"><?php echo $PCODERcontenido_archivo; ?></textarea>
                <input name="PCODER_TokenEdicion" type="hidden" value="<?php echo $PCODER_TokenEdicion; ?>">
                <div id="editor_codigo"></div>
            </div>
        </div>
    </div>
</div>


<nav id="barra_inferior" class="navbar navbar-default navbar-fixed-bottom">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav text-inverse">

        <li class="btn-xs">
            <label for="tamano_fuente">Tamano Fuente</label>
            <select id="tamano_fuente" size="1" class="form-control btn-xs" onchange="CambiarFuenteEditor(this.value)">
              <option value="10px">10px</option>
              <option value="11px">11px</option>
              <option value="12px">12px</option>
              <option value="13px">13px</option>
              <option value="14px" selected="selected">14px</option>
              <option value="16px">16px</option>
              <option value="18px">18px</option>
              <option value="20px">20px</option>
              <option value="24px">24px</option>
            </select>
        </li>

        <li class="btn-xs">
            <label for="tema_grafico">Apariencia</label>
            <select id="tema_grafico" size="1" class="form-control btn-xs btn-primary" onchange="CambiarTemaEditor(this.value)">
              <optgroup label="Brillantes / Bright">
                  <?php
                    //Presenta los temas claros disponibles
                    for ($i=0;$i<count($PCODER_TemasBrillantes);$i++)
                        echo '<option value="ace/theme/'.$PCODER_TemasBrillantes[$i]["Valor"].'">'.$PCODER_TemasBrillantes[$i]["Nombre"].'</option>';
                  ?>
              </optgroup>
              <optgroup label="Oscuros / Dark">
                  <?php
                    //Presenta los temas claros disponibles
                    for ($i=0;$i<count($PCODER_TemasOscuros);$i++)
                        echo '<option value="ace/theme/'.$PCODER_TemasOscuros[$i]["Valor"].'">'.$PCODER_TemasOscuros[$i]["Nombre"].'</option>';
                  ?>
              </optgroup>
            </select>
        </li>

        <li class="btn-xs">
            <label for="modo_archivo">Lenguaje</label>
            <select id="modo_archivo" size="1" class="form-control btn-xs btn-info" onchange="CambiarModoEditor(this.value)">
                  <?php
                    //Presenta los temas claros disponibles
                    for ($i=0;$i<count($PCODER_Modos);$i++)
                        {
                            //Determina si el lenguaje o modo de archivo actual es la opcion a desplegar
                            $modo_seleccion='';
                            if($PCODER_Modos[$i]["Nombre"]==$PCODER_ModoEditor)
                                $modo_seleccion='SELECTED';
                            //PResenta la opcion
                            echo '<option value="ace/mode/'.$PCODER_Modos[$i]["Nombre"].'" '.$modo_seleccion.' >'.$PCODER_Modos[$i]["Nombre"].'</option>';
                        }
                  ?>
            </select>
        </li>

        <li class="btn-xs">
            <label for="modo_invisibles">Ver caracteres invisibles</label>
            <select id="modo_invisibles" size="1" class="form-control btn-xs" onchange="CaracteresInvisiblesEditor(this.value)">
                <option value="0"><?php echo $MULTILANG_No; ?></option>
                <option value="1"><?php echo $MULTILANG_Si; ?></option>
            </select>
        </li>

      </ul>




      <ul class="nav navbar-nav navbar-right">
            <a class="btn btn-xs" onclick="AumentarEditor();"><i class="fa fa-plus-square fa-fw"></i></a>
            <br>
            <a class="btn btn-xs" onclick="DisminuirEditor();"><i class="fa fa-minus-square fa-fw"></i></a>
      </ul>

      <ul class="nav navbar-nav navbar-right">
            <input id="linea_salto" name="linea_salto" type="text" class="btn-xs btn-default" placeholder="<?php echo $MULTILANG_SaltarLinea; ?>">
            <button onClick="SaltarALinea();" class="btn btn-default btn-xs"><?php echo $MULTILANG_Ir; ?> <i class="fa fa-arrow-circle-right"></i></button>
      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


</div>








    <!-- jQuery -->
	<script type="text/javascript" src="inc/jquery/jquery-2.1.0.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="inc/bootstrap/js/bootstrap.min.js"></script>

    <script language="JavaScript">
        //Carga los tooltips programados en la hoja.  Por defecto todos los elementos con data-toggle=tootip
        $(function () {
          $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

    <script language="JavaScript">
        //Carga los popovers programados en la hoja.  Por defecto todos los elementos con data-toggle=popover
        $(function () {
          $('[data-toggle="popover"]').popover()
        })
    </script>

    <script src="inc/ace/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>


<script type="text/javascript">
        var alto_inicial_editor=0;
        function RedimensionarEditor()
            {
                var margen_correccion=3; //Pixeles
                var alto_pantalla=$(document).height();
                var alto_contenedor_principal=$(contenedor_principal).height();
                var alto_barra_superior=$(barra_superior).height();
                var alto_barra_inferior=$(barra_inferior).height();
                alto_editor = alto_pantalla - alto_barra_superior - alto_barra_inferior - margen_correccion;
                alto_inicial_editor=alto_editor;
                document.getElementById("editor_codigo").style.height=alto_editor+"px";
            }
        function DisminuirEditor()
            {
                var alto_actual=$(editor_codigo).height();
                alto_editor = alto_actual - 15;
                if (alto_editor<600)
                    alto_editor=alto_actual;
                document.getElementById("editor_codigo").style.height=alto_editor+"px";
            }
        function AumentarEditor()
            {
                var alto_actual=$(editor_codigo).height();
                alto_editor = alto_actual + 15;
                if (alto_editor>alto_inicial_editor)
                    alto_editor=alto_inicial_editor;
                document.getElementById("editor_codigo").style.height=alto_editor+"px";
            }
        function CambiarFuenteEditor(tamano)
            {
                //Cambia la fuente del editor al tamano recibido
                editor.setFontSize(tamano);
            }
        function CambiarTemaEditor(tema)
            {
                //Cambia la apariencia grafica del editor
                editor.setTheme(tema);
            }
        function CambiarModoEditor(modo)
            {
                var ModoFiltrado = modo.replace(/_/g, " ");
                ModoFiltrado = ModoFiltrado.toLowerCase();
                //Cambia el modo de sintaxis y errores resaltado por el editor
                editor.getSession().setMode(ModoFiltrado);
            }
        function CaracteresInvisiblesEditor(estado)
            {
                //Cambia el modo del editor para mostrar (true) u ocultar (false) los caracteres invisibles
                if (estado==0)
                    editor.setShowInvisibles(false);
                else
                    editor.setShowInvisibles(true);
            }
        function ActualizarTituloEditor(titulo)
            {
                //Cambia el titulo presentado en la ventada del editor
                document.title = titulo;
                $(document).attr('title',titulo);
            }
        function SaltarALinea()
            {
                var linea = document.getElementById("linea_salto").value;
                //Salta a una linea especifica del editor
                editor.gotoLine(linea, 1, true);
            }
        function Deshacer()
            {
                editor.undo();
            }
        function Rehacer()
            {
                editor.redo();
            }


        // Crea el editor
        editor = ace.edit("editor_codigo");
        
        //Actualiza el editor con el valor cargado inicialmente en el textarea
        editor.setValue(document.getElementById("area_texto").value);

        // Inicia el editor de codigo con las opciones predeterminadas
        ActualizarTituloEditor("<?php echo $PCODER_NombreArchivo.' {PCodEr}'; ?>");
        CambiarFuenteEditor("14px");
        CambiarTemaEditor("ace/theme/tomorrow_night");  //tomorrow_night|twilight|eclipse|ambiance|ETC
        CambiarModoEditor("ace/mode/<?php echo $PCODER_ModoEditor; ?>");
        CaracteresInvisiblesEditor(0);
        editor.clearSelection();
        
        //En cada evento de cambio actualiza el textarea
        editor.getSession().on('change', function(){
          document.getElementById("area_texto").value=editor.getSession().getValue();
        });
        
        //Ajusta tamano del editor al inicio y en cada cambio de tamano de la ventana
        RedimensionarEditor();
        $( window ).resize(function() {
          RedimensionarEditor();
        });

    </script>

    <?php
        // Estadisticas de uso anonimo con GABeacon
        $PrefijoGA='<img src="https://ga-beacon.appspot.com/';
        $PosfijoGA='/Practico/'.$PCO_Accion.'?pixel" border=0 ALT=""/>';
        // Este valor indica un ID generico de GA UA-847800-9 No edite esta linea sobre el codigo
        // Para validar que su ID es diferente al generico de seguimiento.  En lugar de esto cambie
        // su valor a traves del panel de configuracion de Practico con el entregado como ID de GoogleAnalytics
        $Infijo=base64_decode("VUEtODQ3ODAwLTk=");
        echo $PrefijoGA.$Infijo.$PosfijoGA;
        if(@$CodigoGoogleAnalytics!="")
            echo $PrefijoGA.$CodigoGoogleAnalytics.$PosfijoGA;	
    ?>
</body>
</html>
<?php
	}

