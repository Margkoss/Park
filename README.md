# Park
=====

*Park* is a school project. In this project we were called to make a website with basic features,
where a user could enter choose a place he wants to park and the system would provide a suggestion
according to the time of day. An admin can also tweak the system's data.

##Dependencies

All you need to setup *Park* is a basic AMP stack
####Apache:  
 
Apache is a free open source software which runs over 50% of the world’s web servers.To install:  
 
`sudo apt-get install apache2
 
####MySql  

MySQL is a powerful database management system used for organizing and retrieving data.  
To install MySQL, open terminal and type in these commands:

`sudo apt-get install mysql-server libapache2-mod-auth-mysql php5-mysql  

Once you have installed MySQL, we should activate it with this command:  

`sudo mysql_install_db

Finish up by running the MySQL set up script:  

`sudo /usr/bin/mysql_secure_installation

####PHP  

PHP is an open source web scripting language that is widely use to build dynamic webpages.  

To install PHP, open terminal and type in this command:  

`sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt

####After all of this
Restart apache so that all of the changes take effect:  

`sudo service apache2 restart

*And you're done!*Just place your Park files in the /var/www directory

====
#Setup
====
