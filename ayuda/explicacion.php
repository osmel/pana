Test
http://localhost/vmc/tools/inicio

Administracion
http://localhost/vmc/tools/admin




sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/pepsi.dev.com.conf
sudo gedit /etc/apache2/sites-available/pepsi.dev.com.conf

<VirtualHost *:80>
  DocumentRoot /var/www/html/pepsi
  ServerName pepsi.dev.com
  ServerAlias www.pepsi.dev.com
  <Directory /var/www/html/pepsi>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride all
    Order allow,deny
    Allow from all
  </Directory>
  ErrorLog ${APACHE_LOG_DIR}/error.log
  CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>


sudo a2ensite pepsi.dev.com.conf
sudo ls /etc/apache2/sites-available
sudo ls /etc/apache2/sites-enabled/
sudo a2enmod rewrite


sudo gedit /etc/apache2/apache2.conf

<Directory /var/www/html/>
  Options Indexes FollowSymLinks
  AllowOverride None
  Require all granted
</Directory>

<Directory /var/www/html/pepsi/>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>


sudo pico /etc/hosts

127.0.0.1 pepsi.dev.com