<?php
/*
config.php

Provides a place to put all configuration info 
for our app

*/

ob_start(); #buffers our page to be prevent header errors. Call before INC files or ANY html!

include 'credentials.php';
include 'common.php';//stores our functions
include 'MyAutoLoader.php'; //loads class that autoloads all classes in include folder
include 'Pager.php'; 
 
define('DEBUG',true); #we want to see all errors

//THIS_PAGE is the name of the current page
define('THIS_PAGE',basename($_SERVER['PHP_SELF']));

/* use the following path settings for placing all code in one application folder */ 
define('VIRTUAL_PATH', 'http://www.lindese.com/itc250/sandbox/A2-FoodTruck/'); # Virtual (web) 'root' of application for images, JS & CSS files

define('PREFIX', 'spot_'); #Adds uniqueness to your DB table names.  Limits hackability, naming collisions

define('ADMIN_PATH', VIRTUAL_PATH); # Path to Admin files: could change to https://, etc.

define('PHYSICAL_PATH', '/home/sarlin18/lindese.com/itc250/sandbox/A2-FoodTruck/'); # Physical (PHP) 'root' of application for file & upload reference

define('INCLUDE_PATH', PHYSICAL_PATH . 'includes/'); # Path to PHP include files - INSIDE APPLICATION ROOT

header("Cache-Control: no-cache");header("Expires: -1");#Helps stop browser & proxy caching

date_default_timezone_set('America/Los_Angeles'); #sets default date/timezone for this website



// $nav1['index.php'] = "home";   
// $nav1['ourwork.php'] = "our work"; 
// $nav1['testimonials.php'] = "testimonials"; 
// $nav1['projects.php'] = "projects"; 
// $nav1['contact.php'] = "contact us"; 
// $nav1['maps.php'] = "maps"; 

// echo THIS_PAGE;
// die; 

ob_start(); 

switch(THIS_PAGE) 
{
    case "index.php": 
        $title = "Home page";
        $pageID = "home page"; 
        $pic = '<img src="images/spinifex1.jpg" />'; 
        break;
    
    case "ourwork.php": 
        $title = "Our work page"; 
        $pageID = "our work page"; 
        $pic = '<img src="images/spinifex2.jpg" />';
        break;
    
        
    case "testimonials.php": 
        $title = "Testimonials page";
        $pageID = "testimonials page"; 
        $pic = '<img src="images/spinifex3.jpg" />';
        break;
    
        
    case "projects.php": 
        $title = "Projects page";
        $pageID = "projects page"; 
        $pic = '<img src="images/tacos-stand-logo.gif" />';
        break;
    
        
    case "contact.php": 
        $title = "Contact Us page";
        $pageID = "contact us page"; 
        $pic = '<img src="images/spinifex5.jpg" />';
        break;
        
        
    case "maps.php": 
        $title = "Maps page";
        $pageID = "maps page"; 
        $pic = '<img src="images/spinifex6.jpg" />';
        break;
    
        
    default: 
        $title = THIS_PAGE;
        $pageID = ""; 
        $pic = '<img src="images/spinifex1.jpg" />';
}

//Here are the keys for the server: lindese.com
$siteKey = "6LcmXBcTAAAAAKZtAVLCZajUgski2nXVLzwBfOOi";
$secretKey = "6LcmXBcTAAAAABnQsS3wAaDsk1o5PJAMCb50VtNe";

//Here are the keys for the server: lindesara.com
//$siteKey = "6LfY3hQTAAAAALqw7wkWTM5lRpTzhowstYYF4lub";
//$secretKey = "6LfY3hQTAAAAAIU-wyXU7I5A8l0El4gJ41c1AlIA";

if(startSession() && isset($_SESSION['AdminID']))
{#add admin logged in info to sidebar or nav
	$adminWidget = '<li><a href="' . ADMIN_PATH . 'admin_dashboard.php">ADMIN</a></li>';
	$adminWidget .= '<li><a href="' . ADMIN_PATH . 'admin_logout.php">LOGOUT</a> ';
    $adminWidget .= '<li>' . $_SESSION['Privilege'] . ' <b>' . $_SESSION['FirstName'] . '</b> is logged in. </li>';
}else{
    $adminWidget = '';
}

/*
 * These variables, when added to the header.php and footer.php files, 
 * allow custom JS or CSS scripts to be loaded into <head> element and 
 * just before the closing body tag, respectively
 */
$loadhead = '';
$loadfoot = '';



