#About destroradius

destroradius is a web management system for freeradius made with laravel framework. its an open source system free to install and use to manage your hotspot customers even
under one radius server.

#Installing destroradius

destroradius is installed on the server.(together with freeradius server). 
its a php system therefore a linux machine(server) is prefered.
make sure apache is preinstalled and running php 7.* before running destroradius

#steps

1. download the zip file from github
>>wget https://codeload.github.com/destrotechs/destroradius/master/zip
2. unzip the downloaded file
>>unzip master
3. move the downloaded files to the apache folder so that they can be served.
>>mv destroradius-master /var/www/html/[your directory name]
4. change directory to the newly created folder
>>cd /var/www/html/[your directory name]
5.make sure composer is installed on the server, or install it via
>>apt-get install -y composer
6.with composer installed and on the directory above, install the whole project and its dependancies
>>composer install
7. after a successfull composer install, its time to change some few configuration to suit our environment
    
    #substeps
    7.1 create a .env file
    >>mv .env.example .env
    7.2 edit .env file to match your database settings
    >>nano .env (change database name,dbuser,password all under mysql) save exit
    7.3 generate application key
    >>php artisan key:generate
    7.4 import the application mysql database schema 
    >>mysql -u root -p databasename < database/radiusdb.sql
    7.5 change storage access mode
    >>chmod -R 777 storage
    7.6 enable routing override
    >>sudo a2enmod rewrite
    7.6.1 add script
    >>nano /etc/apache2/sites-available/000-default.conf
        <Directory /var/www/html>
            AllowOverride All
         </Directory>
         write and exit
    7.7 restart apache
    >>systemctl restart apache2.service
