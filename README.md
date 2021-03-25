# Blog-PHP
Professional PHP blog, without CMS neither framework.
Work carried out as part of the training course "Application Developer - PHP / Symfony" on OpenClassrooms.

## Table of Contents
1. [Prerequisite and technologies](#prerequisite-and-technologies)
2. [Installation](#installation)
3. [Usage](#usage)

## PREREQUISITE AND TECHNOLOGIES
***
### Server
You need a server with PHP7 and MySQL DBMS
Versions used in this project:
* Apache 2.4.46
* PHP 7.3.21
* MySQL 5.7.31

You also need an access to a SMTP server.

### Languages and libraries
This project is coded in PHP7, HTML5, CSS3 and JS
Dependencies manager: Composer
PHP packages, included via Composer: Symfony/Dotenv ^5.2, Cocur/Slugify ^4.0, Swiftmailer/Swiftmailer ^6.2
CSS/JS libraries, included via CDN links: Bootstrap 5 ^bêta 2, Font-awesome ^5.15.1

If you want to customize Bootstrap, install it in your project instead of using CDN links ([more info](https://getbootstrap.com/)).

## INSTALLATION
***
### Download
Download zip files or clone project via github.

### Configure environment variables:
1.  Open the ".env.example" file
2.  Replace the example values with your own values (Database, SMTP, and default Admin info)
3.  Rename the file ".env"

### Create the database
1. Create a new MySQL Database in your DBMS
2. Import *my_blog.sql* file

Note that 'roles' and 'status' tables contains French labels by default. You can update them to translate in any language.
status table:
| ID | French label | Matching constant in code |
|:--------------:|:-------------:|:--------------:|
| 0 | brouillon | STATUS_DRAFT |
| 1 | soumis | STATUS_SUBMITTED |
| 2 | approuvé | STATUS_APROVED |
| 3 | rejeté | STATUS_REJECTED |
roles table:
| ID | French label | Matching constant in code |
|:--------------:|:-------------:|:--------------:|
| 0 | default | ROLE_DEFAULT |
| 1 | admin | ROLE_ADMIN |
| 2 | auteur | ROLE_AUTHOR |

### Install Composer and needed libraries
Install Composer by following [the official instructions](https://getcomposer.org/download/).
Install [Symfony/Dotenv](https://github.com/symfony/dotenv) via composer:
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
***
### Visit your new site
Open *public/index.php* file in your favorite browser. This is your home page!

### Create your admin profile
1. Register you as a new user via registration form (*public/index.php?page=register*)
2. Update your user profile in the database to set status to 2 (=approved) and role to 1 (=admin):
(if your user ID is not 1, replace with the right user ID)
```sql
UPDATE `users` SET `status` = '2', `role` = '1' WHERE `users`.`id` = 1
```
3. Connect to the admin (*public/index.php?page=login*) to check that you are administrator.
4. Start managing your site!

### Customize home page contents
To change the contents below, you have to update manually the *config.php* file, and upload your images and other files in *public* directory:
- Personal photo and name
- Tagline
- PDF resume filename
- LinkedIn link
- GitHub link

### Customize notifications
In the *config.php* file, you can enable (set to 1) or disable (set to 0) email notifications. By default, all notifications are enabled.