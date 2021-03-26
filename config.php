<?php
/**
 * SITE CONFIGURATION
 *
 * SITE DATA
 */
define('SITE_NAME', 'My Blog'); // site name
define('TIMEZONE', 'Europe/Paris'); // default timezone for date and time functions: use the same timezone as in the database

 /**
 * PERSONAL AND PROFESSIONAL DATA
 * Update variables below to customize your Home page
 */ 
define('MY_DATA', array(
  'avatar_filename'  =>  'avatar.jpg', // upload the file in public/files/ directory
  'name'             =>  'Elodie Bichet',
  'tagline'          =>  'Empruntez le meilleur chemin vers votre objectif',
));
define('MY_LINKS', array(
  'cv_filename'     =>  'CV_Elodie-Bichet.pdf', // upload the file in public/files/ directory
  'linkedin'        =>  'https://www.linkedin.com/in/elodie-bichet-chef-de-projet-digital/',
  'github'          =>  'https://github.com/ElodieBichet'
));

/**
 * EMAIL NOTIFICATIONS
 * Update variables below to disable or enable email notifications
 */
define('NOTIFY', array(
  'new_comment'   => 1, // set to 1 if you want to notify authors by email when a new comment is submitted on his post, set to 0 else
  'new_post'      => 1, // set to 1 if you want to be notified when a new post is submitted, set to 0 else
  'new_user'      => 1  // set to 1 if you want to be notified when a new user is submitted, set to 0 else
));