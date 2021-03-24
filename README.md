# Blog-PHP
Professional blog

## PREREQUISITE

You need a server with PHP7 and MySQL DBMS
Versions used in this project:
- Apache 2.4.46
- PHP 7.3.21
- MySQL 5.7.31

You also need an access to a SMTP server.

## DOWNLOAD

Download zip or clone project via github.

## INSTALLATION

### Configure environment variables:
1.  Open the ".env.example" file
2.  Replace the example values with your own values (Database, SMTP, and default Admin info)
3.  Rename the file ".env"

### Crate the database
1. Create a new MySQL Database
2. Import my_blog.sql file in your DB administrator

NB: 'roles' and 'status' tables contains French labels by default. You can update them as you wish in any language.
-> users [0 => STATUS_DRAFT, 1 => STATUS_SUBMITTED, 2 => STATUS_APPROVED, 3 => STATUS_REJECTED]
-> roles [0 => ROLE_DEFAULT, 1 => ROLE_ADMIN, 2 => ROLE_AUTHOR]

### Install Composer and needed libraries
Install Composer by following [the official instructions](https://getcomposer.org/download/).
Install [Symfony/Dotenv](https://github.com/symfony/dotenv) via composer :
```
$ composer require symfony/dotenv
```
Install [Cocur/Slugify](https://github.com/cocur/slugify) via composer:
```
$ composer require cocur/slugify
```
Install [Swiftmailer/Swiftmailer](https://github.com/swiftmailer/swiftmailer) via composer:
```
$ composer require "swiftmailer/swiftmailer:^6.2"
```

## USAGE

### Visit the site
Open public/index.php file in your favorite browser. This is your home page!

### Create your admin profile
1. Register you as a new user via registration form (public/index.php?page=register)
2. Update your user profile in the database to set status to 2 (=approved) and role to 1 (=admin):
UPDATE `users` SET `status` = '2', `role` = '1' WHERE `users`.`id` = 1 
(if your user ID is not 1, replace with the right user ID)
3. Connect to the admin (public/index.php?page=login) to check that you are admin now

### Customize static contents