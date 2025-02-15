# -*- mode: ruby -*-
# vi: set ft=ruby :
#	 _
#	|_) _ _  _ _|_. _ _					  	Copyright (C) 2012-2022
#	|  | (_|(_  | |(_(_) 				  	John F. Arroyave Gutiérrez
#	  www.practico.org					  	unix4you2@gmail.com
#                                            All rights reserved.
#    
#	 This program is free software: you can redistribute it and/or modify
#	 it under the terms of the GNU General Public License as published by
#	 the Free Software Foundation, either version 3 of the License, or
#	 (at your option) any later version.
#
#	 This program is distributed in the hope that it will be useful,
#	 but WITHOUT ANY WARRANTY; without even the implied warranty of
#	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#	 GNU General Public License for more details.
#
#	 You should have received a copy of the GNU General Public License
#	 along with this program.  If not, see <http://www.gnu.org/licenses/>
#	 
#	            --- TRADUCCION NO OFICIAL DE LA LICENCIA ---
#
#     Esta es una traducción no oficial de la Licencia Pública General de
#     GNU al español. No ha sido publicada por la Free Software Foundation
#     y no establece los términos jurídicos de distribución del software 
#     publicado bajo la GPL 3 de GNU, solo la GPL de GNU original en inglés
#     lo hace. De todos modos, esperamos que esta traducción ayude a los
#     hispanohablantes a comprender mejor la GPL de GNU:
#	 
#     Este programa es software libre: puede redistribuirlo y/o modificarlo
#     bajo los términos de la Licencia General Pública de GNU publicada por
#     la Free Software Foundation, ya sea la versión 3 de la Licencia, o 
#     (a su elección) cualquier versión posterior.
#
#     Este programa se distribuye con la esperanza de que sea útil pero SIN
#     NINGUNA GARANTÍA; incluso sin la garantía implícita de MERCANTIBILIDAD
#     o CALIFICADA PARA UN PROPÓSITO EN PARTICULAR. Vea la Licencia General
#     Pública de GNU para más detalles.
#
#     Usted ha debido de recibir una copia de la Licencia General Pública de
#     GNU junto con este programa. Si no, vea <http://www.gnu.org/licenses/>


############################################################################
#                         VAGRANT DE SUPERVIVENCIA
#
#  Tenga en cuenta: Vagrant esta destinado a levantar entornos de desarrollo
#                   y pruebas de manera automatizada.  Especialmente para
#     INTROITO      desarrolladores del Framework.  Si usted desea crear
#   EXCULPATORIO    aplicaciones o usar esto en produccion deberia ejecutar
#                   los comandos equivalentes sobre un servidor destinado
#                   para produccion, configurado para tal fin y con una
#                   version de instalador del Framework obtenida desde
#                   https://www.practico.org y no con una version desde Git
#
############################################################################
#
#  1) INSTALACION (comandos segun su plataforma) Ej:   apt install vagrant

#  2) DESCARGA el archivo de definicion sobre una carpeta limpia: 
#     Ej1: mkdir practico; cd practico; wget https://github.com/unix4you2/practico/raw/master/Vagrantfile
#     Ej2: mkdir practico; cd practico; curl -L -o Vagrantfile https://github.com/unix4you2/practico/raw/master/Vagrantfile

#  3) Levante la máquina virtual de pruebas que desee.  Ejs: 
#        vagrant up             (Levanta todas en paralelo)
#        vagrant up ubuntu
#        vagrant up centos
#        vagrant up openbsd
#        vagrant up freebsd
#        vagrant up alpine
#
#=============================================================================
# CAJAS    OS       APACHE   PHP      MotorBD          CREDENCIALES
#-----------------------------------------------------------------------------
# alpine   3.15.0   2.4.54   7.4.33   MariaDB 10.6.10  vagrant/vagrant
# centos   7.9      2.4.6    5.4.16   MariaDB 5.5.68   vagrant/vagrant
# ubuntu   22.04.1  2.4.52   7.4.33   MariaDB 10.6.7   vagrant/vagrant
# freebsd  13.1     2.4.54   7.4.33   MySQL 5.7.40     vagrant/vagrant
# openbsd  7.2               7.4.33
#-----------------------------------------------------------------------------




Vagrant.configure("2") do |config|

  $Encabezado_Aprovisionamiento = <<-SCRIPT
      echo "--------------------------------------------------- "
      echo "    /\\  _  _ _   . _. _  _  _  _ _ . _  _ _|_ _    "
      echo "   /~~\\|_)| (_)\\/|_\\|(_)| |(_|| | ||(/_| | | (_) "
      echo "       |                                            "
      echo "--------------------------------------------------- "
    SCRIPT
  config.vm.provision "shell", inline: $Encabezado_Aprovisionamiento
 

  config.vm.define "centos" do |centos|
	  centos.vm.box="generic/centos7"

	  centos.vm.provider "virtualbox" do |vm_detalles|
	    vm_detalles.cpus = "1"
	    vm_detalles.memory = "1024"
	    vm_detalles.customize ["modifyvm", :id, "--vram", "32"]
	    vm_detalles.gui = false
	  end

	  # Redireccion del puerto apache en la VM para su uso local en puerto del anfitrion
	    centos.vm.network :forwarded_port, host: 7171, guest: 22
	    centos.vm.network :forwarded_port, host: 8181, guest: 80
	    centos.vm.network :forwarded_port, host: 9191, guest: 443
	    
	  # ------------------- CONFIGURACIONES DE RED -------------------
	  # Red privada (host-only)
	  #  config.vm.network "private_network", ip: "192.168.56.100"
	  # Red en modo Bridge
	  #  config.vm.network "public_network"
	  #  config.vm.network "public_network", ip: "192.168.0.17"
	  # Carpetas compartidas adicionales
	  #  config.vm.synced_folder "../data", "/vagrant_data"


	  centos.vm.provision "shell", inline: $ScriptAprovisionamiento_CentOS
  end


  config.vm.define "ubuntu" do |ubuntu|
	  ubuntu.vm.box="generic/ubuntu2204"
    
      #Ajustes especificos para login y aprovisionamiento por SSH
      ubuntu.ssh.insert_key = false
      ubuntu.ssh.verify_host_key = false
      ubuntu.ssh.username = "vagrant"
      ubuntu.ssh.password = "vagrant"
      #ubuntu.ssh.ciphers = ["aes256-cbc", "3des-cbc", "blowfish-cbc", "cast128-cbc", "arcfour", "aes192-cbc", "aes128-cbc"]

	  ubuntu.vm.provider "virtualbox" do |vm_detalles|
	    vm_detalles.cpus = "2"
	    vm_detalles.memory = "2048"
	    vm_detalles.customize ["modifyvm", :id, "--vram", "128"]
	    vm_detalles.gui = false
	  end
	  
	  # Redireccion del puerto apache en la VM para su uso local en puerto del anfitrion
	    ubuntu.vm.network :forwarded_port, host: 6262, guest: 3389
	    ubuntu.vm.network :forwarded_port, host: 7272, guest: 22
	    ubuntu.vm.network :forwarded_port, host: 8282, guest: 80
	    ubuntu.vm.network :forwarded_port, host: 9292, guest: 443
	    
	  ubuntu.vm.provision "shell", inline: $ScriptAprovisionamiento_Ubuntu
  end


  config.vm.define "openbsd" do |openbsd|
	  openbsd.vm.box="generic/openbsd7"

      #Ajustes especificos para login y aprovisionamiento por SSH
      openbsd.ssh.insert_key = false
      openbsd.ssh.verify_host_key = false
      openbsd.ssh.username = "vagrant"
      openbsd.ssh.password = "vagrant"
      #openbsd.ssh.ciphers = ["aes256-cbc", "3des-cbc", "blowfish-cbc", "cast128-cbc", "arcfour", "aes192-cbc", "aes128-cbc"]

	  openbsd.vm.provider "virtualbox" do |vm_detalles|
	    vm_detalles.cpus = "1"
	    vm_detalles.memory = "512"
	    vm_detalles.customize ["modifyvm", :id, "--vram", "32"]
	    vm_detalles.gui = false
	  end
	  
	  # Redireccion del puerto apache en la VM para su uso local en puerto del anfitrion
	    openbsd.vm.network :forwarded_port, host: 7373, guest: 22
	    openbsd.vm.network :forwarded_port, host: 8383, guest: 80
	    openbsd.vm.network :forwarded_port, host: 9393, guest: 443
	    
	  openbsd.vm.provision "shell", inline: $ScriptAprovisionamiento_OpenBSD
  end


  config.vm.define "freebsd" do |freebsd|
	  freebsd.vm.box="generic/freebsd13"

	  freebsd.vm.provider "virtualbox" do |vm_detalles|
	    vm_detalles.cpus = "1"
	    vm_detalles.memory = "512"
	    vm_detalles.customize ["modifyvm", :id, "--vram", "32"]
	    vm_detalles.gui = false
	  end

	  # Redireccion del puerto apache en la VM para su uso local en puerto del anfitrion
	    freebsd.vm.network :forwarded_port, host: 7474, guest: 22
	    freebsd.vm.network :forwarded_port, host: 8484, guest: 80
	    freebsd.vm.network :forwarded_port, host: 9494, guest: 443
	    
	  freebsd.vm.provision "shell", inline: $ScriptAprovisionamiento_FreeBSD
  end


  config.vm.define "alpine" do |alpine|
	  alpine.vm.box="generic/alpine315"

      #Ajustes especificos para login y aprovisionamiento por SSH
      alpine.ssh.insert_key = false
      alpine.ssh.verify_host_key = false
      alpine.ssh.username = "vagrant"
      alpine.ssh.password = "vagrant"
      #alpine.ssh.ciphers = ["aes256-cbc", "3des-cbc", "blowfish-cbc", "cast128-cbc", "arcfour", "aes192-cbc", "aes128-cbc"]

	  alpine.vm.provider "virtualbox" do |vm_detalles|
	    vm_detalles.cpus = "1"
	    vm_detalles.memory = "512"
	    vm_detalles.customize ["modifyvm", :id, "--vram", "32"]
	    vm_detalles.gui = false
	  end
	  
	  # Redireccion del puerto apache en la VM para su uso local en puerto del anfitrion
	    alpine.vm.network :forwarded_port, host: 7575, guest: 22
	    alpine.vm.network :forwarded_port, host: 8585, guest: 80
	    alpine.vm.network :forwarded_port, host: 9595, guest: 443
	    
	  alpine.vm.provision "shell", inline: $ScriptAprovisionamiento_AlpineLinux
  end


end




############################################################################
#         SCRIPTS DE APROVISIONAMIENTO POR CADA SISTEMA OPERATIVO          #
############################################################################


#   ██████╗███████╗███╗   ██╗████████╗ ██████╗ ███████╗
#  ██╔════╝██╔════╝████╗  ██║╚══██╔══╝██╔═══██╗██╔════╝
#  ██║     █████╗  ██╔██╗ ██║   ██║   ██║   ██║███████╗
#  ██║     ██╔══╝  ██║╚██╗██║   ██║   ██║   ██║╚════██║
#  ╚██████╗███████╗██║ ╚████║   ██║   ╚██████╔╝███████║
#   ╚═════╝╚══════╝╚═╝  ╚═══╝   ╚═╝    ╚═════╝ ╚══════╝
	$ScriptAprovisionamiento_CentOS = <<-SCRIPT
	    #Instalacion de Apache
	    sudo yum -y update
	    sudo yum -y install httpd mod_ssl

	    #Instalacion de PHP y sus extensiones
	    sudo yum -y install php php-process php-mysql php-gd php-ldap php-odbc php-pear php-zip
	    sudo yum -y install php-xml php-xmlrpc php-mbstring php-snmp php-soap php-curl curl curl-devel

	    #Instalacion de MariaDB
	    sudo yum -y install mariadb-server mariadb

	    #Instalacion de herramientas basicas de desarrollo
	    sudo yum -y install git

	    #Habilita, enciende y apaga servicios
	    sudo systemctl disable firewalld.service
	    sudo systemctl stop firewalld.service
	    sudo systemctl enable httpd.service
	    sudo systemctl restart httpd.service
	    sudo systemctl start mariadb.service
	    sudo systemctl enable mariadb.service

	    #Instala repositorio directo sobre carpeta del servidor web y carpetas de pruebas
	    cd /var/www/html
	    rm -rf practico
	    mkdir practico_tests
	    git clone https://github.com/unix4you2/practico.git
	    chmod -R 777 *
	    rm -f index.html
	    cp practico/tmp/index.html index.html

	    #Instalacion de la base de datos
	    mysql --user=root -e "CREATE DATABASE IF NOT EXISTS practico;"	
	    mysql -h "localhost" --user=root --database=practico < "/var/www/html/practico/ins/sql/practico.mysql"
	    mysql --user=root -e "FLUSH PRIVILEGES;"		
	    mysql --user=root -e "SET PASSWORD FOR 'root'@'localhost' = PASSWORD('mypass');"

	    #Actualiza llaves en BD de usuarios segun valor del archivo configuracion y regenera elementos
	    cd /var/www/html/practico/ins
	    php paso_llave.php
	    php paso_regenerar.php

	    echo " "
	    echo "=============================================================="
	    echo "                 APROVISIONAMIENTO FINALIZADO"
	    echo "--------------------------------------------------------------"
	    echo "  Ingrese a  http://localhost:8181/practico  "
	    echo "             https://localhost:9191/practico  (Aceptando SSL)"
	    echo " "
	    echo "             USUARIO Y CONTRASENA:   admin / admin"
	    echo " "
	    echo "             ssh -l vagrant -p 7171 localhost (Acceso SSH)"
	    echo "--------------------------------------------------------------"
	  SCRIPT



#  ██╗   ██╗██████╗ ██╗   ██╗███╗   ██╗████████╗██╗   ██╗
#  ██║   ██║██╔══██╗██║   ██║████╗  ██║╚══██╔══╝██║   ██║
#  ██║   ██║██████╔╝██║   ██║██╔██╗ ██║   ██║   ██║   ██║
#  ██║   ██║██╔══██╗██║   ██║██║╚██╗██║   ██║   ██║   ██║
#  ╚██████╔╝██████╔╝╚██████╔╝██║ ╚████║   ██║   ╚██████╔╝
#   ╚═════╝ ╚═════╝  ╚═════╝ ╚═╝  ╚═══╝   ╚═╝    ╚═════╝ 
	$ScriptAprovisionamiento_Ubuntu = <<-SCRIPT
	    #Instalacion de Apache
	    sudo apt-get -y update
	    sudo apt-get -y install apache2
	    
	    #Instalacion de PHP y sus extensiones
	    sudo add-apt-repository ppa:ondrej/php --yes &> /dev/null
	    sudo apt-get -y install php7.4 php7.4-common php7.4-mysql php7.4-gd php7.4-ldap php7.4-odbc 
	    sudo apt-get -y install php7.4-xml php7.4-xmlrpc php7.4-mbstring php7.4-snmp php7.4-soap php-curl curl

	    #Instalacion de MariaDB
	    sudo apt-get -y install mariadb-server mariadb-client

	    #Instalacion de herramientas basicas de desarrollo
	    sudo apt-get -y install git
	    
	    #Habilita, enciende y apaga servicios
	    sudo ufw disable
	    sudo systemctl enable apache2.service
	    sudo systemctl restart apache2.service
	    sudo systemctl start mariadb.service
	    sudo systemctl enable mariadb.service

	    #Instala repositorio directo sobre carpeta del servidor web y carpetas de pruebas
	    cd /var/www/html
	    rm -rf practico
	    mkdir practico_tests
	    git clone https://github.com/unix4you2/practico.git
	    chmod -R 777 *
	    rm -f index.html
	    cp practico/tmp/index.html index.html

	    #Instalacion de la base de datos
	    mysql --user=root -e "CREATE DATABASE IF NOT EXISTS practico;"	
	    mysql -h "localhost" --user=root --database=practico < "/var/www/html/practico/ins/sql/practico.mysql"
	    mysql --user=root -e "FLUSH PRIVILEGES;"		
	    mysql --user=root -e "SET PASSWORD FOR 'root'@'localhost' = PASSWORD('mypass');"

	    #Actualiza llaves en BD de usuarios segun valor del archivo configuracion y regenera elementos
	    cd /var/www/html/practico/ins
	    php paso_llave.php
	    php paso_regenerar_nodel.php

	    #SOLO PARA UBUNTU - Instala y configura herramientas extra usadas por desarrollador principal
	    sudo apt-get -y install composer git-gui gitg geany mc unzip p7zip 
	    sudo apt-get -y install gcc golang-go default-jdk nodejs newlisp
	    sudo apt-get -y install xfce4 xfce4-goodies xorg dbus-x11 x11-xserver-utils nano
	    sudo apt-get -y install chromium-browser firefox
	    sudo apt-get -y install xrdp
	    sudo systemctl enable xrdp.service
	    sudo systemctl stop xrdp.service
	    sudo adduser xrdp ssl-cert
   	    echo 'exec startxfce4' >> /etc/xrdp/xrdp.ini
	    sudo systemctl start xrdp.service
    	    cd /var/www/html/
    	    sudo chown -R vagrant *

	    echo " "
	    echo "=============================================================="
	    echo "                 APROVISIONAMIENTO FINALIZADO"
	    echo "--------------------------------------------------------------"
	    echo "  Acceso WEB   (Practico Framework)"
	    echo "               http://localhost:8282/practico "
	    echo "               https://localhost:9292/practico (Aceptando SSL)"
	    echo " "
	    echo "               USUARIO Y CONTRASENA:   admin / admin"
	    echo " "
	    echo "--------------------------------------------------------------"
	    echo "  Acceso SSH   (Secure Shell)"
	    echo "               ssh -l vagrant -p 7272 localhost"
	    echo "               (puede requerir -o HostKeyAlgorithms=CIFRADO)"
	    echo " "
	    echo "  Acceso RDP   (Remote Desktop)"
	    echo "               rdesktop -u vagrant -p vagrant localhost:6262"
	    echo " "
	    echo "--------------------------------------------------------------"
	  SCRIPT



#  ███████╗██████╗ ███████╗███████╗   ██████╗ ███████╗██████╗ 
#  ██╔════╝██╔══██╗██╔════╝██╔════╝   ██╔══██╗██╔════╝██╔══██╗
#  █████╗  ██████╔╝█████╗  █████╗     ██████╔╝███████╗██║  ██║
#  ██╔══╝  ██╔══██╗██╔══╝  ██╔══╝     ██╔══██╗╚════██║██║  ██║
#  ██║     ██║  ██║███████╗███████╗   ██████╔╝███████║██████╔╝
#  ╚═╝     ╚═╝  ╚═╝╚══════╝╚══════╝   ╚═════╝ ╚══════╝╚═════╝ 
	$ScriptAprovisionamiento_FreeBSD = <<-SCRIPT
	    #Instalacion de Apache
	    sudo pkg install -y apache24

	    #Instalacion de PHP y sus extensiones
	    sudo pkg install -y php74 php74-session php74-hash php74-simplexml php74-xml php74-xmlrpc php74-pdo php74-gd php74-json
	    sudo pkg install -y php74-pdo_mysql php74-mysqli mod_php74 php74-mbstring php74-zlib php74-curl php74-zip
	    sudo cp /usr/local/etc/php.ini-production /usr/local/etc/php.ini
	    #sudo rehash
	    sudo touch /usr/local/etc/apache24/Includes/php.conf
	    echo '<IfModule dir_module>' 			>> /usr/local/etc/apache24/Includes/php.conf
	    echo 'DirectoryIndex index.php index.html' 		>> /usr/local/etc/apache24/Includes/php.conf
	    echo '<FilesMatch "\.php$">' 			>> /usr/local/etc/apache24/Includes/php.conf
	    echo 'SetHandler application/x-httpd-php' 		>> /usr/local/etc/apache24/Includes/php.conf
	    echo '</FilesMatch>' 				>> /usr/local/etc/apache24/Includes/php.conf
	    echo '<FilesMatch "\.phps$">' 			>> /usr/local/etc/apache24/Includes/php.conf
	    echo 'SetHandler application/x-httpd-php-source' 	>> /usr/local/etc/apache24/Includes/php.conf
	    echo '</FilesMatch>' 				>> /usr/local/etc/apache24/Includes/php.conf
	    echo '</IfModule>' 					>> /usr/local/etc/apache24/Includes/php.conf

	    #Instalacion de MySQL
	    #sudo pkg install -y mysql57-server mysql57-client
	    sudo pkg install -y mariadb103-server mariadb103-client

	    #Instalacion de herramientas basicas de desarrollo
	    sudo pkg install -y git

	    #Habilita, enciende y apaga servicios
	    sudo service apache24 enable
	    sudo service apache24 start
	    sudo service mysql-server enable
	    sudo service mysql-server start

	    #Instala repositorio directo sobre carpeta del servidor web y carpetas de pruebas
	    cd /usr/local/www/apache24/data
	    rm -rf practico
	    mkdir practico_tests
	    git clone https://github.com/unix4you2/practico.git
	    chmod -R 777 *
	    rm -f index.html
	    cp practico/tmp/index.html index.html

	    #Instalacion de la base de datos
	    	service mysql-server stop
	    	sysrc mysql_args="--skip-grant-tables"
	    	service mysql-server start
	    mysql --user=root -e "CREATE DATABASE IF NOT EXISTS practico;"	
	    mysql -h "localhost" --user=root --database=practico < "/usr/local/www/apache24/data/practico/ins/sql/practico.mysql"
	    mysql --user=root -e "update user set authentication_string=password('mypass') where user='root';" mysql
	    mysql --user=root -e "FLUSH PRIVILEGES;"
	    	service mysql-server stop
	    	sysrc -x mysql_args
	    	service mysql-server start

	    #Actualiza llaves en BD de usuarios segun valor del archivo configuracion y regenera elementos
	    cd /usr/local/www/apache24/data/practico/ins
	    php paso_llave.php
	    php paso_regenerar.php
	    
	    echo " "
	    echo "=============================================================="
	    echo "                 APROVISIONAMIENTO FINALIZADO"
	    echo "--------------------------------------------------------------"
	    echo "  Ingrese a  http://localhost:8484/practico "
	    echo "             https://localhost:9494/practico  (Aceptando SSL)"
	    echo " "
	    echo "             USUARIO Y CONTRASENA:   admin / admin"
	    echo " "
	    echo "             ssh -l vagrant -p 7474 localhost (Acceso SSH)"
	    echo "--------------------------------------------------------------"
	  SCRIPT
	  
	  

#   ██████╗ ██████╗ ███████╗███╗   ██╗   ██████╗ ███████╗██████╗ 
#  ██╔═══██╗██╔══██╗██╔════╝████╗  ██║   ██╔══██╗██╔════╝██╔══██╗
#  ██║   ██║██████╔╝█████╗  ██╔██╗ ██║   ██████╔╝███████╗██║  ██║
#  ██║   ██║██╔═══╝ ██╔══╝  ██║╚██╗██║   ██╔══██╗╚════██║██║  ██║
#  ╚██████╔╝██║     ███████╗██║ ╚████║   ██████╔╝███████║██████╔╝
#   ╚═════╝ ╚═╝     ╚══════╝╚═╝  ╚═══╝   ╚═════╝ ╚══════╝╚═════╝ 
	$ScriptAprovisionamiento_OpenBSD = <<-SCRIPT
	    echo " "
	    echo "=============================================================="
	    echo "                 APROVISIONAMIENTO FINALIZADO"
	    echo "--------------------------------------------------------------"
	    echo "  Ingrese a  http://localhost:8383/practico "
	    echo "             https://localhost:9393/practico  (Aceptando SSL)"
	    echo " "
	    echo "             USUARIO Y CONTRASENA:   admin / admin"
	    echo " "
	    echo "             ssh -l vagrant -p 7373 localhost (Acceso SSH)"
	    echo "--------------------------------------------------------------"
	  SCRIPT



#   █████╗ ██╗     ██████╗ ██╗███╗   ██╗███████╗
#  ██╔══██╗██║     ██╔══██╗██║████╗  ██║██╔════╝
#  ███████║██║     ██████╔╝██║██╔██╗ ██║█████╗  
#  ██╔══██║██║     ██╔═══╝ ██║██║╚██╗██║██╔══╝  
#  ██║  ██║███████╗██║     ██║██║ ╚████║███████╗
#  ╚═╝  ╚═╝╚══════╝╚═╝     ╚═╝╚═╝  ╚═══╝╚══════╝                                           
	$ScriptAprovisionamiento_AlpineLinux = <<-SCRIPT
	    #Instalacion de Apache
	    sudo apk add apache2

	    #Instalacion de PHP y sus extensiones
	    sudo apk add php7 php7-session php7-simplexml php7-xml php7-xmlrpc php7-pdo php7-gd php7-json php7-pdo_mysql php7-mysqli php7-mbstring php7-zlib php7-curl php7-zip php7-posix
	    sudo apk add php7-apache2

	    #Instalacion de MariaDB
	    sudo apk add mariadb mariadb-client
	    sudo /etc/init.d/mariadb setup

	    #Instalacion de herramientas basicas de desarrollo
	    sudo apk add git
	    
	    #Habilita, enciende y apaga servicios
	    sudo rc-update add apache2 default
	    sudo rc-service apache2 restart
	    sudo rc-update add mariadb default
	    sudo rc-service mariadb restart

	    #Instala repositorio directo sobre carpeta del servidor web y carpetas de pruebas
	    sudo chmod 777 /var/www/localhost/htdocs
	    cd /var/www/localhost/htdocs
	    rm -rf practico
	    mkdir practico_tests
	    git clone https://github.com/unix4you2/practico.git
	    sudo chmod -R 777 *
	    rm -f index.html
	    cp practico/tmp/index.html index.html

	    #Instalacion de la base de datos
	    sudo mysqladmin create practico
	    sudo mysqladmin -u root password mypass
	    sudo mysql -h "localhost" --user=root --database=practico < "/var/www/localhost/htdocs/practico/ins/sql/practico.mysql"

	    #Actualiza llaves en BD de usuarios segun valor del archivo configuracion y regenera elementos
	    cd /var/www/localhost/htdocs/practico/ins
	    php paso_llave.php
	    php paso_regenerar.php

	    echo " "
	    echo "=============================================================="
	    echo "                 APROVISIONAMIENTO FINALIZADO"
	    echo "--------------------------------------------------------------"
	    echo "  Acceso WEB   (Practico Framework)"
	    echo "               http://localhost:8585/practico "
	    echo "               https://localhost:9595/practico (Aceptando SSL)"
	    echo " "
	    echo "               USUARIO Y CONTRASENA:   admin / admin"
	    echo " "
	    echo "--------------------------------------------------------------"
	    echo "  Acceso SSH   (Secure Shell)"
	    echo "               ssh -l vagrant -p 7575 localhost"
	    echo "               (puede requerir -o HostKeyAlgorithms=CIFRADO)"
	    echo " "
	    echo "--------------------------------------------------------------"
	  SCRIPT