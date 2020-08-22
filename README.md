# Service Booking and Workshop Management System for Sriyani Motors

---

Instructions to setup and use the software.

## 0. Required third party software

-   Web server: Apache
-   DBMS: MariaDB (or MySQL)
-   Server-side Language: PHP (>= v7.2)
-   Client Web Browser: Latest version of Google Chrome or Firefox.
-   Package manager: Composer

## 1. Installing the host environment

Install a suitable LAMP stack of your choice that contains the above mentioned software. The system was developed on Ubuntu 18.04 using XAMPP therefore it is recommended to the prospective user as well. In addition LAMP stack the user should also install composer package manager for php.
(If you plan to host it elsewhere e.g. Heroku you may have to edit the `.htaccess` inside the `public/` directory.)

## 2. Unzip and copy contents to server

Unzip the compressed file in the `application/` directory to your machine. After extracting the root directory's name should be 'sbwms'
Copy the `sbwms/` directory to the server hosting directory. (e.g if XAMPP then copy the `bwms/` directory to the `htdocs/` directory where XAMPP is installed)

## 3. Install dependencies using composer

Navigate to the server directory where you copied the `sbwms/` directory to and open a command line prompt and type `'composer install'` without quotes. This will install all package dependencies. Note that you have to be on the root of project folder in the command line as shown below.

```sh
sbwms\$ composer install
```

## 4. Load database

The `database/` directory contains the database in the form of a SQL script. Import the script using a suitable tool e.g phpMyAdmin, Adminer, etc.

## 5. Access the system

If you have hosted the system locally then you can open a web browser and navigate to http://localhost/sbwms/public
Use the following credentials to gain access to the system.

-   Username: admin
-   Password: 1234

## 6. Third party software download links

The required third party software can be found in the following links.

-   [Composer](https://getcomposer.org/)
-   [XAMPP](https://www.apachefriends.org/index.html)
