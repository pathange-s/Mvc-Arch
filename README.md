# Mvc-Arch

Library Management System on MVC architecture

## Start
* Clone the repository
* Get your LAMP setup . [a link](https://forum.manjaro.org/t/howto-install-apache-mariadb-mysql-php-lamp/13000)

## Setting up database
* Start mysql server

```bash
CREATE DATABASE USERS;
```
```bash
USE USERS;
```
```bash
CREATE TABLE USERS_DATA (Name VARCHAR(255),Email VARCHAR(255),Password VARCHAR(255));
```
```bash
CREATE TABLE Books (book_id INT AUTO_INCREMENT PRIMARY KEY,book_name VARCHAR(255),book_count VARCHAR(255));
```


```bash
CREATE TABLE Books_Status (Request_ID INT AUTO_INCREMENT PRIMARY KEY,User_Email VARCHAR(255),Book_ID INT, Status VARCHAR(255));
```

* Edit `sampleconfig.php` file with appropirate details in the `config` directory and rename it to `config.php`

* Database setup is done !


* In the project root directory setup composer by the commands 
```bash
composer install
composer dump-autoload
```

## Setting up Virtualhost

* Configure Vhost config file

* Make sure Vhost module is enabled in `sudo nano /etc/httpd/conf/httpd.conf` before proceding to the next step 

```bash
sudo nano /etc/httpd/conf/extra/httpd-vhosts.conf
```
* Paste the `lib.local.conf` (Make sure you give the correct public directory and error log addresses)

* Add the server domain in the hosts file

```bash
sudo nano /etc/hosts
```

* Add `127.0.0.1  lib.local` (or your domain name) in the hosts




## Run 

* Localhost : In the `public` directory, execute `php -S localhost:<PORT>` to start the server
* Vhost : Start server at your server name - `lib.local`
