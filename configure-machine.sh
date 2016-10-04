#!/usr/bin/env bash

update-locale LC_ALL=en_US.UTF-8 LANGUAGE=en_US.UTF-8

apt-get update

#install LAMP packages
apt-get install -y php5
apt-get install -y sqlite3
apt-get install php5-sqlite

#
# Install and configure Apache
#
apt-get install -y apache2

# Link Apache content dir
if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant/src /var/www
fi

# Link Apache config files
ln -fs /vagrant/config/apache/apache2.conf /etc/apache2/apache2.conf
ln -fs /vagrant/config/apache/conf-available/security.conf /etc/apache2/conf-available/security.conf

#Activate SSL connection
sudo a2enmod ssl

#Generate SSL cert
mkdir /etc/apache2/ssl
sudo openssl req \
    -new \
    -newkey rsa:2048 \
    -days 365 \
    -nodes \
    -x509 \
    -subj "/C=SE/ST=Skåne/L=Lund/O=Webshop/CN=localhost" \
    -keyout /etc/apache2/ssl/apache.key \
    -out /etc/apache2/ssl/apache.cert

#Insert custom virtual hosts config file
ln -fs /vagrant/config/apache/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
ln -fs /vagrant/config/apache/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

# Activate SSL virtual host
sudo a2ensite default-ssl.conf

#config php
ln -fs /vagrant/config/php/php.ini /etc/php5/apache2/php.ini

#Restart apache to activate all new packages and settings
service apache2 restart

# Copy database and make it writable
mkdir /db
cp -f /vagrant/db/database.db /db/database.db
chmod a+w /db
chmod a+w /db/database.db
