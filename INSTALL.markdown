
Install
===============================================================================

This chapter will walk you through the installation of the Modulaise 
tools suite. 

Please notice, that the installation instructions are written for
windows machines, so wherever there is a specific windows path, you need
to correct it to suit whatever OS you are running.


Table of Contents
-------------------------------------------------------------------------------

*   [Requirements](#requirements)
*   [Install Java Virtual Machine](#install_java)
*   [Install Apache server](#install_apache)
*   [Install PHP](#install_php)    
*   [Install Eclipse](#install_eclipse)
    *   [Configure Eclipse using downloaded zip file (Recommended)](#config_zip)
    *   [Configure Eclipse with EGit (NOT recommended)](#config_git)
    *   [Add jar files to your Ant path](#config_eclipse_antpath)
*   [Configure Apache webserver](#config_apache)
*   [Test installation](#test_install)
*   [Revision History](#revision_history)


<a name="requirements"/>

Requirements 
-------------------------------------------------------------------------------

You will need to have the following in order to use the Modulaise tools 
suite, note that the suite should be OS independent. 

1.  A working Java Virtual Machine, version 1.6 or later

2.  Eclipse with Ant, Version 3.6.1 (Helios) or later

3.  Apache server with PHP support, PHP5 or later


<a name="install_java"/>

Install Java Virtual Machine
-------------------------------------------------------------------------------

Chances are that you already have a Java Virtual Machine installed on your
Operating System. To find out head to [http://www.java.com](http://www.java.com)
where you can obtain the latest JVM.


<a name="install_apache"/>

Install Apache server
-------------------------------------------------------------------------------

I recommend you start of with a fresh install of Apache server,
otherwise you may need to correct the paths in the following.

1.  Download the Apache server from 
    [http://httpd.apache.org](http://httpd.apache.org). For windows 
	choose the msi installer. 

2.  Install the apache for "All users". In the following I will assume
    that you installed the Apache server in this folder: 
	``C:\dev\Apache Software Foundation\Apache2.2\``

3.  Verify that the installation works by browsing to
    [http://localhost/](http://localhost/) 


<a name="install_php"/>

Install PHP
-------------------------------------------------------------------------------

In order for us to develop the site using Modulaise, we are going to use 
PHP for some of the behind the scenes magic. 

1.  Download PHP from [http://www.php.net](http://www.php.net).

    For windows choose to download the ``VC9 x86 Thread Safe`` zip file. 

2.  Unizip to ``C:\dev\php``, so there is a file
    ``c:/dev/php/php5apache2_2.dll``

3.  Add the following to the end of your Apache configuration file, 
    located at: 
    
    ``C:\dev\Apache Software Foundation\Apache2.2\conf\httpd.conf``

        # For PHP 5 do something like this:
        LoadModule php5_module "c:/dev/php/php5apache2_2.dll"
        AddType application/x-httpd-php .php
        AddType application/x-httpd-php .html

        # configure the path to php.ini
        PHPIniDir "C:/dev/php"

4.  Place the following contents into:

    ``C:\dev\Apache Software Foundation\Apache2.2\htdocs\info.php``

        <?php phpinfo(); > 

5.  Verify that PHP is working by browsing to:
    [http://localhost/info.php](http://localhost/info.php) 

Note that PHP is not used for running any of the code on the production 
site! Modulaise is only about producing HTML, CSS and JavaScript. 


<a name="install_eclipse"/>

Install Eclipse 
-------------------------------------------------------------------------------

1.  Download Eclipse IDE for Java EE Developers from 
    [http://www.eclipse.org/](http://www.eclipse.org/) 

2.  Extract Eclipse to ``C:\dev\eclipse\`` 

Note that it should be entirely possible to use these tools with 
[Netbeans](http://netbeans.org/) instead, however this may requure
different steps for installing Ant and setting the classpaths for Ant
correctly.

Also note that you are going to need this particular version of Eclipse, 
since the tools discussed here relies heavily on the Ant scripting 
platform, which I haven't seen included in the Eclipse for PHP 
developers or the plain vanilla Eclipse version. 


<a name="config_zip"/>

### Configure Eclipse using downloaded zip file (Recommended)

Choose this option if you don't plan on contributing, or getting the
latest bug fixes or features on a daily basis.

1.  Choose workspace
    
    Start your Eclipse and choose to use the workspace folder at 
    ``C:\dev\workspace\`` don't worry Eclipse will generate that folder
    if it does not exist.

2.  Create a new "Static Web Projects" called "modulaise".
    
    1.  Choose Eclipse menu: "File" -> "New" -> "Other..."
    2.  Choose "Static Web Project"
    3.  Name the project "modulaise" in small-caps
    
3.  Download the latest tagged version of the Modulaise tools suite from:
    
    [https://github.com/larjen/modulaise](https://github.com/larjen/modulaise)

4.  Extract files
    
    Extract the contents of the downloaded zip file into your modulaise
    project.
    
    Make sure the file "build.xml" is in the root folder of your project,
    all other files should then align roughly to:
    
        ${workspace_loc}/modulaise
                            /modulaise
                                /boilerplates
                                    /modules
                                    /pages
                                    /projects
                                /config-project
                                /docs
                                /lib
                                /scripts
                            /WebContent
                            .gitignore
                            build.xml
                            README.markdown


<a name="config_git"/>

### Configure Eclipse with EGit

Choose this method, if you would like to contribute or get the daily
bleeding edge version of the tools suite. This is only recommended for
advanced users or contributors.

1.  Choose workspace
    
    Start your Eclipse and choose to use the workspace folder at 
    ``C:\dev\workspace\`` don't worry Eclipse will generate the folder
    if it does not exist.

2.  Arm your Eclipse with EGit.
    
    1. Choose Eclipse menu: "Help" -> "Install New Software..." 
    2. Work with: [http://download.eclipse.org/egit/updates/](http://download.eclipse.org/egit/updates/)
    3. Pick Eclipse EGit and Eclipse JGit
    4. Install and restart Eclipse. 

3.  Fetch files from GitHub.
    
    1.  Choose Eclipse menu: "File" -> "Import..."
    2.  Choose: "Projects from Git"
    3.  Choose: "Clone..."
    4.  In the URI box paste ``git://github.com/larjen/modulaise.git``
    5.  Select the master branch and continue
    6.  In the last dialogue ensure that destination directory is set 
        to ``C:\dev\workspace\modulaise``
    7.  Click finish to fetch the project

4.  Create a new "Static Web Projects" called "modulaise".
    
    1.  Choose Eclipse menu: "File" -> "New" -> "Other..."
    2.  Choose "Static Web Project"
    3.  Name the project "modulaise" in small-caps
    4.  Right click on this project
    5.  Select: "Team" -> "Share Project..." -> "Git"
    
    From now on you can get the latest bug-fixes and features by right
    clicking and selecting Team -> Pull.


<a name="config_eclipse_antpath"/>

### Add jar files to your Ant path

In order for the Ant executable to minify, build and deploy your projects
you need to add these files to your Ant path:
    
    1.  Choose Eclipse menu: "Window" -> "Preferences" -> "Ant" -> "Runtime"
    2.  Add the following jar-files to the Ant Classpath Global Entries: 
            
            # List of jar-files to add to Ant Classpath: 
            ..\modulaise\lib\commons-net-2.0\commons-net-ftp-2.0.jar 
            ..\modulaise\lib\jsch-0.1.44\jsch-0.1.44.jar 


<a name="config_apache"/>

Configure Apache webserver 
-------------------------------------------------------------------------------

The last thing you need before complete configuration is configuring 
your Apache server to serve files from 
[http://modulaise.localhost](http://modulaise.localhost). 

1.  Add the following to your Apache configuration file:

    ``C:\dev\Apache Software Foundation\Apache2.2\conf\httpd.conf`` 

        # setup virtual hosts
        NameVirtualHost 127.0.0.1:80
        
        # modulaise virtual host
        <VirtualHost 127.0.0.1:80>
           ServerAdmin webmaster@modulaise.localhost
           DocumentRoot "c:/dev/workspace/modulaise/WebContent"
           ServerName modulaise.localhost
           ErrorLog "logs/modulaise.localhost.log"
           CustomLog "logs/modulaise.localhost-access.log" common
           DirectoryIndex modulaise.php index.php index.html
           <Directory />
               Options FollowSymLinks
               AllowOverride All
           </Directory>
           <Directory c:/dev/workspace/modulaise/WebContent>
               Options Indexes FollowSymLinks MultiViews
               AllowOverride All
               Order allow,deny
               allow from All
           </Directory>
        </VirtualHost>

2.  Add the following entry to your hosts file, mine is located at
    ``C:/Windows/System32/drivers/etc/hosts``:

        127.0.0.1 modulaise.localhost

3.  Verify that everything is working by going to 
    [http://modulaise.localhost/](http://modulaise.localhost/) 


<a name="test_install"/>

Test installation
-------------------------------------------------------------------------------

Now to verify that everything works as intended.

1.  In the modulaise root folder right click "build.xml" and choose Run As ->
    Ant Build...
    
2.  Checkmark the task "Build" and only the task "Build", and click run.

3.  Right click the "modulaise" folder in the Project Explorer pane, and choose Refresh.

4.  Verify that the project has been updated with a number of extra files:

    *   modulaise/WebContent/sc/_compiled/ -> concatinated and minified CSS and JS
    *   modulaise/WebContent/sc/index.html -> version history file
    *   modulaise/WebContent/modulaise/builds/buildname.zip -> zip file containing the entire build

If everything worked as expected, the configuration is complete and you are now ready 
to create and build projects.


<a name="revision_history"/>

Revision History
-------------------------------------------------------------------------------

*   20101230, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Created the documentation 
    
*   20110102, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Updated intallation instructions to correct minor details, and
    include a zip file installations instruction.

*   20110108, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Included table of contents, added install Java Virtual Machine chapter.

*   20110120, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Updated documentation to reflect new internal project structure.