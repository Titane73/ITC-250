<?php
/**
 * category.php
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
session_start();

require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
require 'category.php';
# check variable of item passed in - if invalid data, forcibly redirect back to index.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $CategoryID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "news/index.php");
}

$myCategory = new Category($CategoryID);

if($myCategory->IsValid)
{#only load data if record found
	$config->titleTag = $myCategory->Name . " RSS News Feeds built with PHP & XML"; 
}

get_header(); #defaults to theme header or header_inc.php

if($myCategory->IsValid)
{#records exist - show Feed

    echo '
    <h3 align="center"> Category: <i><b>' . $myCategory->Name .
        '</b></i></h3>
        <p align="center">' . $myCategory->Description . '</p>
    ';
    
    echo '
    <table class="table table-striped table-hover ">
      <thead>
        <tr>
          <th>Feed</th>
          <th>Feed Description</th>
        </tr>
      </thead>
      <tbody>
    ';

    foreach($myCategory->Feeds as $feed) {
	// process each row
        echo '
            <tr>
                <td><a href="' . VIRTUAL_PATH . 'news/feed_view.php?id=' . $feed->FeedID . '">' . $feed->Name . '</a></td>
                <td>' . $feed->Description . '</td>
            </tr>
            ';
	}
    echo '
      </tbody>
    </table>
    ';

}else{//no such Description!
    echo '<div align="center">ERROR: No such Description for ID=' . $CategoryID . '</div>';
}

echo '<div align="center"><a href="' . VIRTUAL_PATH . 'news/index.php">Back</a></div>';

get_footer(); #defaults to theme footer or footer_inc.php


