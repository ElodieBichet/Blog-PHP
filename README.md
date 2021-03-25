# Blog-PHP
Professional PHP blog, without CMS neither PHP framework.  
Work carried out as part of the training course "Application Developer - PHP / Symfony" on OpenClassrooms.

## Table of Contents
1.  [Prerequisite and technologies](#prerequisite-and-technologies)
2.  [Installation](#installation)
3.  [Usage](#usage)

---
## PREREQUISITE AND TECHNOLOGIES

### __Server__
You need a web server with PHP7 and MySQL DBMS.  
Versions used in this project:
* Apache 2.4.46
* PHP 7.3.21
* MySQL 5.7.31

You also need an access to a SMTP server.

### __Languages and libraries__
This project is coded in __PHP7__, __HTML5__, __CSS3__ and __JS__.  
Dependencies manager: __Composer__  
PHP packages, included via Composer:
* Symfony/Dotenv ^5.2 ([more info](https://github.com/symfony/dotenv))
* Cocur/Slugify ^4.0 ([more info](https://github.com/cocur/slugify))
* Swiftmailer/Swiftmailer ^6.2 ([more info](https://github.com/swiftmailer/swiftmailer))

CSS/JS libraries, included via CDN links:
* Bootstrap ^5 bêta 2
* Font-awesome ^5.15.1  

*NB: If you want to customize Bootstrap, install it in your project instead of using CDN links ([more info](https://getbootstrap.com/)).*

---
## INSTALLATION

### __Download__
Download zip files or clone the project repository with github ([see GitHub documentation](https://docs.github.com/en/github/creating-cloning-and-archiving-repositories/cloning-a-repository)).

### __Configure environment variables__
1.  Open the ___.env.example___ file
2.  Replace the example values with your own values (Database, SMTP, and default Admin info)
3.  Rename the file ___.env___
```env
# .env
DB_HOST=host_name
DB_NAME=db_name
DB_CHARSET=utf8
DB_USERNAME=username
DB_PASSWORD=password
SMTP_HOST=host
SMTP_USERNAME=username
SMTP_PASSWORD=password
ADMIN_EMAIL=your@email.com
ADMIN_NAME=yourname
```

### __Create the database__
1.  Create a new MySQL Database in your DBMS
2.  Import ___my_blog.sql___ file

Note that _roles_ and _status_ tables contains French labels by default. You can update them to translate in any language.  
* _status_ table:

| ID | French label | Matching constant in code |
|:--------------:|:-------------:|:--------------:|
| 0 | brouillon | STATUS_DRAFT |
| 1 | soumis | STATUS_SUBMITTED |
| 2 | approuvé | STATUS_APROVED |
| 3 | rejeté | STATUS_REJECTED |  
  
* _roles_ table:

| ID | French label | Matching constant in code |
|:--------------:|:-------------:|:--------------:|
| 0 | default | ROLE_DEFAULT |
| 1 | admin | ROLE_ADMIN |
| 2 | auteur | ROLE_AUTHOR |
  
---  
### __Install Composer__
1.  Go to the project directory in your cmd:
```
$ cd some\directory
```
2.  Install __Composer__ by following [the official instructions].(https://getcomposer.org/download/).
3.  Install dependencies with the following command:
```
$ composer install
```
Dependencies should be installed in your project (check _vendor_ directory).

---
## USAGE

### __Visit your new site__
Open ___public/index.php___ file in your favorite browser. This is your home page!

### __Create your admin profile__
1.  Register you as a new user via registration form (___public/index.php?page=register___)
2.  Update your user profile in the database to set status to 2 (=approved) and role to 1 (=admin):
(if your user ID is not 1, replace with the right user ID)
```sql
UPDATE `users` SET `status` = '2', `role` = '1' WHERE `users`.`id` = 1
```
3.  Connect to the admin (___public/index.php?page=login___) to check that you are administrator.
4.  Start managing your site!

### __Customize home page contents__
To change the contents below, you have to update manually the *config.php* file, and upload your images and other files in *public* directory:
* Personal photo and name
* Tagline
* PDF resume filename
* LinkedIn link
* GitHub link
```php
$my_avatar_filename = 'your-avatar.jpg'; // upload the file in public/files/ directory
$my_name = 'Your name';
$my_tagline = 'Your tagline';
$my_cv_filename = 'your-resume.pdf'; // upload the file in public/files/ directory 
$my_linkedin_link = 'https://www.linkedin.com/in/your-linkedin-url/';
$my_github_link = 'https://github.com/your-github-url';
```

### __Customize notifications__
In the ___config.php___ file, you can enable (set to 1) or disable (set to 0) email notifications. By default, all notifications are enabled.
```php
/**
 * EMAIL NOTIFICATIONS
 * Update variables below to disable or enable email notifications
 */
$notify_new_comment = 1; // set to 1 if you want to notify authors by email when a new comment is submitted on his post, set to 0 else
$notify_new_post = 1; // set to 1 if you want to be notified when a new post is submitted, set to 0 else
$notify_new_user = 1; // set to 1 if you want to be notified when a new user is submitted, set to 0 else
```
