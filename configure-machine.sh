#!/usr/bin/env bash

update-locale LC_ALL=en_US.UTF-8 LANGUAGE=en_US.UTF-8

apt-get update

apt-get install -y apache2

# Link Apache content dir
if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant/src /var/www
fi

# Link Apache config file
if ! [ -L /etc/apache2/apache2.conf ]; then
  rm -f /etc/apache2/apache2.conf
  ln -fs /vagrant/apache2.conf /etc/apache2/apache2.conf
fi

apt-get install -y php5
apt-get install -y sqlite3
apt-get install php5-sqlite

#Restart apache so all newly installed packages works
service apache2 restart
