#!/bin/bash

BRANCH_NAME=$1
HOSTNAME=$2

MYSQL_ROOT_PASSWORD=C10PS3v1Ll4
MYSQL_CLOP_INS_PASSWORD=clop1ns3rT
MYSQL_CLOP_SEL_PASSWORD=clopS3l3cT

DPATH=/var/www/clop
SOURCES=/root/sources

mkdir -p $SOURCES

echo "********************************:q*****"
echo "***       Installing Git          ***"
echo "*************************************"
apt-get --yes install git-core

echo "***********************************"
echo "* Installing gcc *"
echo "***********************************"
apt-get --yes install gcc

echo "*************************************"
echo "***    Install local configs      ***"
echo "*************************************"
cp -R ./etc/* /etc/
hostname $HOSTNAME
echo "127.0.0.1 $HOSTNAME dbins.local.clopsevilla.com dbsel.local.clopsevilla.com" >> /etc/hosts

echo "*************************************"
echo "***    Users and permissions      ***"
echo "*************************************"
adduser --disabled-password --gecos "" clop
adduser clop www-data
chpasswd <<__END__
clop:pq3Cl0pS3vi114
__END__

echo "*************************************"
echo "***       Update sources          ***"
echo "*************************************"
apt-get --yes update && apt-get --yes upgrade

echo "*************************************"
echo "***            SUDO               ***"
echo "*************************************"
aptitude install sudo
echo "clop    ALL=(ALL) ALL" >> /etc/sudoers

echo "*************************************"
echo "***       Installing PHP          ***"
echo "*************************************"
apt-get --yes install php5 php5-common php5-intl php5-gd php-apc php5-imap php5-curl php5-mysql php5-sqlite php5-imagick php5-ffmpeg imagemagick

echo "*************************************"
echo "***     Installing apache         ***"
echo "*************************************"
apt-get --yes install apache2 apache2-utils

echo "*************************************"
echo "***      Installing MySQL         ***"
echo "*************************************"
DEBIAN_FRONTEND=noninteractive apt-get --yes -q install mysql-server

# change root password by default
mysqladmin -u root password $MYSQL_ROOT_PASSWORD
# add iventia_ins user
mysql -uroot -p$MYSQL_ROOT_PASSWORD -e "grant select,insert,update,delete,lock tables on clop.* to 'clop_ins'@'%' IDENTIFIED BY '$MYSQL_CLOP_INS_PASSWORD';"
# add iventia_sel user
mysql -uroot -p$MYSQL_ROOT_PASSWORD -e "grant select on clop.* to 'clop_sel'@'%' IDENTIFIED BY '$MYSQL_CLOP_SEL_PASSWORD';"

mysql -uroot -p$MYSQL_ROOT_PASSWORD -e "flush privileges;"
# mysql iventiajobs database
mysql -uroot -p$MYSQL_ROOT_PASSWORD -e 'create database clop character set = "utf8" collate "utf8_spanish_ci";'

sed -i 's/bind-address.*/bind-address            = 0.0.0.0/g' /etc/mysql/my.cnf
service mysql restart


echo "*************************************"
echo "***   Install Mail MTA            ***"
echo "*************************************"
DEBIAN_FRONTEND=noninteractive apt-get -y install postfix


echo "*************************************"
echo "***       Install lockrun         ***"
echo "*************************************"
wget http://www.unixwiz.net/tools/lockrun.c
gcc lockrun.c -o lockrun
cp lockrun /usr/local/bin/cd /hosts

echo -e '\E[01;32m*************************************'
echo -e '\E[01;32m***            DONE!              ***'
echo -e '\E[01;32m*************************************\033[00m'
uptime

