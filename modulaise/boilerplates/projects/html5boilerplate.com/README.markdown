
Configuration
===============================================================================

These instructions cover how to set up the apache server to serve your new
project "__PROJECT_NEW_NAME__". 

Please note that if you are not on windows, or if you have installed your
Apache server in a different location, you have to customize the relevant
paths in the following.


1. Modify your hosts file
-------------------------------------------------------------------------------

Add the following line to your hosts file ``__FILE_HOSTS__``:

    127.0.0.1 __PROJECT_NEW_NAME__.localhost


2. Configure Apache server
-------------------------------------------------------------------------------

Add the following to your Apache configurations file ``__FILE_APACHE_CONFIGURATION__``:

    <VirtualHost 127.0.0.1:80>
      ServerAdmin webmaster@__PROJECT_NEW_NAME__.localhost
      DocumentRoot "__DIR_WORKSPACE__/__PROJECT_NEW_NAME__/WebContent"
      ServerName __PROJECT_NEW_NAME__.localhost
      ErrorLog "logs/__PROJECT_NEW_NAME__.localhost.log"
      CustomLog "logs/__PROJECT_NEW_NAME__.localhost-access.log" common
      DirectoryIndex modulaise.php index.php index.html
      <Directory />
        Options FollowSymLinks
        AllowOverride All
      </Directory>
      <Directory __DIR_WORKSPACE__/__PROJECT_NEW_NAME__/WebContent>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from All
      </Directory>
    </VirtualHost>


3. Restart Apache server
-------------------------------------------------------------------------------

Verify succes of installation by pointing your browser to: 

http://__PROJECT_NEW_NAME__.localhost


Revision History
-------------------------------------------------------------------------------

*   20101230, [Lars Jensen](mailto:lars.jensen@exenova.dk)
     
    Created the readme file