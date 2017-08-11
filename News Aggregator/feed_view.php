<?php
/**
 * news_view.php
 *
 * @package NewsViews
 * @author Anu Slorah
 * @author Kyrrah Nork
 * @author Ron Nims <rleenims@gmail.com>
 * @link http://www.artdevsign.com/
 * @version 0.1 2017/07/17
 * Copyright [2017] [Ron Nims]
 * http://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @todo !!! implement persistent sessions and cached feed data
 * @todo NTH Add Feeds
 * @todo NTH Update Feeds
 */
$time = $_SERVER[‘REQUEST_TIME’];
/**
 * for a 30 minute timeout, specified in seconds
 */
$timeout_duration = 600;
/**
 * Here we look for the user’s LAST_ACTIVITY timestamp. If
 * it’s set and indicates our $timeout_duration has passed,
 * blow away any previous $_SESSION data and start a new one.
if (isset($_SESSION[‘LAST_ACTIVITY’]) && ($time-$_SESSION[‘LAST_ACTIVITY’]) > $timeout_duration) {
  session_unset();    
  session_destroy();
  session_start();    
}
 * Finally, update LAST_ACTIVITY so that our timeout
 * is based on it and not the user’s login time.
$_SESSION[‘LAST_ACTIVITY’] = $time;
 */
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
require '../inc_0700/Pager_inc.php';
require 'category.php';
# check variable of item passed in - if invalid data, forcibly redirect back to index.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $feedID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "news/news_index.php");
}

$myFeed = new Feed($feedID);

if(isset($_GET['act'])) {
    $myAction = (trim($_GET['act']));
    switch ($myAction) 
    {//check 'act' for type of process
        case "clear": // Cear feed cache
            //TODO $myFeed->clearFeedCache() is not working
            $myFeed->clearFeedCache();
            //so clearing feed cach directly
            //if ( isset($_SESSION['Feed' . $feedID]) ) {        
            //    unset($_SESSION['Feed' . $feedID]);
            //    unset($_SESSION['FeedTime' . $feedID]);
            //}
            myRedirect(THIS_PAGE . "?id=" . $feedID);
    }
}
if(isset($_GET['catid'])) {
	$categoryID = (int)$_GET['catid'];
    $myCategory = new Category($categoryID);
    $categoryName = $myCategory->Name;
}else{
    $categoryName = 'News';
}
if($myFeed->IsValid)
{#only load data if record found
	$config->titleTag = $myFeed->Name . " RSS News Feeds built with PHP & XML"; 
}
# END CONFIG AREA ---------------------------------------------------------- 
get_header(); #defaults to theme header or header_inc.php

if($myFeed->IsValid)
{#records exist - show Feed
    // $xml will contain the entire RSS Feed object for this feed
    $xml = $myFeed->getRSS();

    echo '
    <div class="fragment">
    <h3 align="center"> Category: <i><b>' . $categoryName .
        '</b></i>, RSS Feed: <i><b>' . $myFeed->Name . '</b></i></h3>
        <p align="center">' . $myFeed->Description . '</p>
        <p align="center">' . 'Feed loaded at: ' . $myFeed->timeStamp() . '
        <a href="' . THIS_PAGE . '?id=' . $feedID . '&act=clear">Clear Cache</a></p>
        </div>
    ';
    
    
    print '<h1 class="feedTitle">' . $xml->channel->title . '</h1>';

    foreach($xml->channel->item as $story) {
        echo '<div class="fragment">
        <p>' . $story->description . '</p>
        <p>' . $story->pubDate . '</p>
        </div><br /><br />';
    }
}else{//no such Feed!
    echo '<div align="center">ERROR: No such Feed for ID=' . $feedID . '</div>';
}

echo '<div align="center"><a href="' . VIRTUAL_PATH . 'news/news_index.php">Back</a></div>';

get_footer(); #defaults to theme footer or footer_inc.php

