#!/usr/bin/env bash

echo "--- Updating packages list ---"
sudo apt-get update

echo "--- Installing base packages ---"
sudo apt-get install -y vim curl python-software-properties htop aptitude

echo "--- Updating packages list ---"
sudo add-apt-repository -y ppa:ondrej/php5
sudo apt-get update

echo "--- Installing MySQL ---"
installnoninteractive(){
  sudo bash -c "DEBIAN_FRONTEND=noninteractive aptitude install -q -y $*"
}
installnoninteractive mysql-server

echo "--- Installing PHP-specific packages ---"
sudo apt-get install -y php5 apache2 libapache2-mod-php5 php5-curl php5-gd php5-mcrypt php5-mysql git-core

echo "--- Installing and configuring Xdebug ---"
sudo apt-get install -y php5-xdebug

cat << EOF | sudo tee -a /etc/php5/mods-available/xdebug.ini
xdebug.scream=1
xdebug.cli_color=1
xdebug.show_local_vars=1
EOF

echo "--- Enabling mod-rewrite ---"
sudo a2enmod rewrite

echo "--- Setting document root ---"
sudo rm -rf /var/www
sudo ln -fs /vagrant/public /var/www
sed -i "s/DocumentRoot .*/DocumentRoot \/var\/www/" /etc/apache2/sites-enabled/000-default.conf

echo "--- Tweaking configs ---"
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini
sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

echo "--- Restarting Apache ---"
sudo service apache2 restart

echo "--- Installing and configuring Composer ---"
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

cat << EOF | sudo tee -a /home/vagrant/.bashrc

if [ -d "\$HOME/.composer/vendor/bin" ] ; then
    PATH="\$HOME/.composer/vendor/bin/:\$PATH"
fi
EOF

echo "--- Installing PHPUnit ---"
mkdir /home/vagrant/.composer; cd /home/vagrant/.composer
composer require 'phpunit/phpunit=3.7.*'
sudo chown -R vagrant:vagrant /home/vagrant/.composer

echo "--- Installing composer packages ---"
cd /vagrant
composer install --dev

echo "--- Preparing database ---"
echo "CREATE DATABASE IF NOT EXISTS pulse" | mysql
php artisan migrate

echo "--- All set to go! ---"
