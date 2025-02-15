<?php
/*
	 _
	|_) _ _  _ _|_. _ _					  	Copyright (C) 2012-2022
	|  | (_|(_  | |(_(_) 				  	John F. Arroyave Gutiérrez
	  www.practico.org					  	unix4you2@gmail.com
                                            All rights reserved.
    
	====================================
	   Set de pruebas: CodeQL y Otros
	====================================
	DESCRIPCION:    Archivo de ejecucion de script para generacion de base de datos sobre el servidor
	CODIGO QL:      php /var/www/html/practico/dev/test/ga_basedatos.php
	                curl http://localhost/practico/dev/test/ga_basedatos.php

*/

    //Define variables requeridas (en ejeucion normal recibidas desde paso 3 del asistente)
	global $mensaje_final;
	$mensaje_final="";
	$NombreCortoEmpresa="Practico";
	$NombreAplicacion="Framework";
	$VersionAplicacion="1.0";
	$PCOConnMotorBD="mysql";
	$NombreRAD="Practico";
	
	//Inclusiones de idioma basicos para resultados implicitos de framework
	include_once("../../inc/practico/idiomas/es.php");

	// Ejecuta los scripts de creacion de la BD si se requiere
	$hay_error=0;
	$total_ejecutadas=0;

			//include_once("../../core/configuracion.php");
			require("../../dev/test/ga_configuracion.php"); //Reemplaza configuracion estandar por el set de pruebas
			include_once("../../core/conexiones.php");
			include_once("../../core/comunes.php");
			
			//Abre el archivo con los queries dependiendo del motor
			$RutaScriptSQL="../../ins/sql/practico.mysql";
			
	echo ">>> Ejecutando SCRIPTS en ".$RutaScriptSQL;
			
			$archivo_consultas=fopen($RutaScriptSQL,"r");
			$total_consultas= fread($archivo_consultas,filesize($RutaScriptSQL));
			fclose($archivo_consultas);
 
    //echo ">>> Volcado de SCRIPTS: ".$total_consultas;  //En caso de desear un eco de todas las consultas a ejecutar sobre el CI

			$arreglo_consultas = PCO_SegmentarSQL($total_consultas);
			foreach($arreglo_consultas as $consulta)
				{
					try
						{
							//Cambia el prefijo predeterminado en caso que haya sido personalizado en la instalacion
							$consulta=str_replace("core_",$TablasCore,$consulta);
							//Cambia parametros iniciales de aplicacion
							$consulta=str_replace("PAR_NombreCortoEmpresa",$NombreCortoEmpresa,$consulta);
							$consulta=str_replace("PAR_NombreAplicacion",$NombreAplicacion,$consulta);
							$consulta=str_replace("PAR_VersionAplicacion",$VersionAplicacion,$consulta);

							//Ejecuta el query
							$consulta_enviar = $ConexionPDO->prepare($consulta);
							$consulta_enviar->execute();
							$total_ejecutadas++;
						}
					catch( PDOException $ErrorPDO)
						{
							echo "<hr><b><font color=red>".$MULTILANG_Atencion."!!!: </font>".$MULTILANG_ErrorScripts.". SQL: ".$consulta." ".$MULTILANG_Error.": ".$ErrorPDO->getMessage()."</b>";
							$hay_error=1; //usada globalmente durante el proceso de instalacion
						}
				}

			//Actualiza las llaves de paso de los usuarios insertados
			$LlaveEnMD5=hash("md5", $LlaveDePaso);
			$consulta="UPDATE ".$TablasCore."usuario SET llave_paso='".$LlaveEnMD5."' ";
			$consulta_enviar = $ConexionPDO->prepare($consulta);
			$consulta_enviar->execute();

    echo ">>> Total consultas ejecutadas: ".$total_ejecutadas;

/*
Script en transicion desde t_basedatos.php (Anteriormente Travis)

	// Definicion de variables para almacenar resultado
	$estado_final="0";
	include_once("dev/test/z_consola.php");
	include_once("core/comunes.php");
	$accion="";
	$hay_error=0;

    //Define un arreglo con los motores a probar
    $MotoresPruebas=array("mysql"); // Deprecated: "pgsql", "sqlite"

    //Recorre el arreglo de motores y ejecuta el script en cada uno
    foreach ($MotoresPruebas as $MotorEvaluado)
        {
            //Presenta estado sobre TravisCI
            PCOCLI_MensajeSimple(" Pruebas sobre motor ".$MotorEvaluado);
            if ($MotorEvaluado=="mysql")
                {
                    $ServidorBD='127.0.0.1';
                    $BaseDatos='practico';
                    $UsuarioBD='root';
                    $PasswordBD='';
                    $MotorBD=$MotorEvaluado;
                    $PuertoBD='';
                    $TablasCore='core_';
                    $TablasApp='app_';
                    $ConsultaVersionMotor="SELECT VERSION()";
                }
            if ($MotorEvaluado=="pgsql")
                {
                    $ServidorBD='127.0.0.1';
                    $BaseDatos='practico';
                    $UsuarioBD='postgres';
                    $PasswordBD='';
                    $MotorBD=$MotorEvaluado;
                    $PuertoBD='';
                    $TablasCore='core_';
                    $TablasApp='app_';
                    $ConsultaVersionMotor="SELECT version()";
                }
            if ($MotorEvaluado=="sqlite")
                {
                    //$ServidorBD='127.0.0.1';
                    $BaseDatos='practico.db';
                    //$UsuarioBD='root';
                    //$PasswordBD='';
                    $MotorBD=$MotorEvaluado;
                    //$PuertoBD='';
                    $TablasCore='core_';
                    $TablasApp='app_';
                    $ConsultaVersionMotor="select sqlite_version()";
                }            //Recarga archivo de conexiones para reescribir variables de conexion y redefine la misma justo despues segun el motor
            include_once("core/conexiones.php");
            $ConexionPDO=PCO_NuevaConexionBD($MotorBD,$PuertoBD,$BaseDatos,$ServidorBD,$UsuarioBD,$PasswordBD);

            $RegistroVersionMotor=PCO_EjecutarSQL($ConsultaVersionMotor)->fetch();
            echo "\n\r";
            echo "  VERSION: ".$RegistroVersionMotor[0];


        	//PASO 1: Agrega las tablas y ejecuta consultas iniciales sobre la base de datos
        		$total_ejecutadas=0;
        		//Abre el archivo con los queries dependiendo del motor
        		$RutaScriptSQL="ins/sql/practico.".$MotorEvaluado;
        		
        		$archivo_consultas=fopen($RutaScriptSQL,"r");
        		$total_consultas= fread($archivo_consultas,filesize($RutaScriptSQL));
        		fclose($archivo_consultas);
        		$arreglo_consultas = PCO_SegmentarSQL($total_consultas);
        		foreach($arreglo_consultas as $consulta)
        			{
        				try
        					{
        						//Ejecuta el query
        						$consulta_enviar = $ConexionPDO->prepare($consulta);
        						$consulta_enviar->execute();
        						$total_ejecutadas++;
        					}
        				catch( PDOException $ErrorPDO)
        					{
        					    PCOCLI_Mensaje("ERROR DURANTE EJECUCION SQL:");
        					    echo "\n\r";
        						echo "SQL EJECUTADO: ".$consulta." ==>> ".$ErrorPDO->getMessage();
        						$hay_error=1;
        					}
        			}
        
        	//PASO 2: Verifica las tablas creadas en la base de datos
                PCOCLI_Mensaje("RESUMEN DE OPERACIONES MOTOR: ".$MotorEvaluado);
        		$resultado=PCO_ConsultarTablas();
                $total_tablas=0;
        		while ($registro = $resultado->fetch())
        			{
        				$total_registros=PCO_ContarRegistrosTabla($registro["0"]);
        				echo "\n\r";
        				echo 'Tabla: '.$registro[0].'='.$total_registros.' registros. ';
                        $total_tablas++;
        			}
                echo '  TOTAL TABLAS: '.$total_tablas;
        
        	if (@$hay_error==1)
        		$estado_final=1;
        }



*/







































	if ($hay_error)
		{
            echo ">>> Se encontraron ERRORES al ejecutar: ";
            exit(1); //Finaliza con error
		}
	else
	    exit(0);
?>