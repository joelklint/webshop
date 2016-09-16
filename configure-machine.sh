#!/usr/bin/env bash

apt-get update
apt-get install -y apache2
apt-get install -y php5

# Link content dir 
if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant/src /var/www
fi

# Link config file
if ! [ -L /etc/apache2/apache2.conf ]; then
  rm -f /etc/apache2/apache2.conf
  ln -fs /vagrant/apache2.conf /etc/apache2/apache2.conf
fi
