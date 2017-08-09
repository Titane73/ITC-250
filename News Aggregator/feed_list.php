<?php
/** feed_add.php
 * @package newsfeeds
 * @author Anu Slorah
 * @author Kyrrah Nork
 * @author Ron Nims <rleenims@gmail.com>
 * @link http://www.artdevsign.com/
 * @version 0.1 2017/07/17
 * Copyright [2017] [Ron Nims]
 * http://www.apache.org/licenses/LICENSE-2.0
 * @see feed.php
 * @see Pager.php 
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
require 'category.php';
 


if(isset($_REQUEST['id']) && (int)$_REQUEST['id'] > 0) {
	 $CategoryID = (int)$_REQUEST['id'];
    if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}
    switch ($myAction) 
    {//check 'act' for type of process
        case "add": //2) Form for adding new category
            addForm($CategoryID);
            break;
        case "insert": //3) Insert new category
            insertExecute($CategoryID);
            break; 
        default: //1)Show existing categories
            showFeeds($CategoryID);
    }

}else{
	myRedirect(VIRTUAL_PATH . "news/index.php");
}


function showFeeds($CatId)
{//Select Category
    global $config;
    $myCategory = new Category($CatId);

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

    }else{//no such Description
        echo '<div align="center">ERROR: No such Description for ID=' . $CatId . '</div>';
    }

    echo '<div align="center"><a href="' . VIRTUAL_PATH . 'news/index.php">BACK</a> </div>';
	echo '<div align="center"><a href="' . THIS_PAGE . '?act=add&id=' . $CatId . '">ADD FEED</a></div>';
    get_footer(); #defaults to theme footer or footer_inc.php

}

function addForm($CatId)
{# shows details from a single customer, and preloads their first name in a form.
	global $config;
    $myCategory = new Category($CatId);

    if($myCategory->IsValid)
    {#only load data if record found
        $config->titleTag = $myCategory->Name . " RSS News Feeds built with PHP & XML"; 
    }
	
	get_header();
	echo '<h3 align="center">' . smartTitle() . '</h3>
	<h4 align="center">Add RSS Feed to Category <strong><em>' . $myCategory->Name . '</em></strong></h4>
	<form action="feed_add.php" method="post">
	<table align="center">
       <tr><td align="right">RSS Feed Name</td>
		   	<td>
		   		<input type="text" name="FeedName" />
		   		<font color="red"><b>*</b></font> <em>(alphanumerics & spaces)</em>
		   	</td>
	   </tr>

	   <tr><td align="right">Feed Description</td>
		   	<td>
		   		<input type="text" name="FeedDescription" size="56"/>
		   	</td>
	   </tr>
       <tr><td align="right">RSS Feed URL</td>
		   	<td>
		   		<input type="url" name="FeedURL" size="56"/>
		   		<font color="red"><b>*</b></font> <em>(valid RSS Feed URL)</em>
		   	</td>
	   </tr>
       <tr><td align="right">Feed Search Terms</td>
		   	<td>
		   		<input type="text" name="FeedSearch" />
		   		<font color="red"><b>*</b></font> <em>(alphanumerics & spaces)</em>
		   	</td>
	   </tr>     
	   <input type="hidden" name="act" value="insert" />
	   <input type="hidden" name="id" value="' . $CatId . '" />
	   <tr>
	   		<td align="center" colspan="2">
	   			<input type="submit" value="Add New Feed">
	   		</td>
	   </tr>
	</table>    
	</form>
	<div align="center"><a href="' . THIS_PAGE . '">Exit Without Add</a></div>
	';
	get_footer();
	
}
/*


*/


function insertExecute($CatId)
{
	$iConn2 = \IDB::conn();//must have DB as variable to pass to mysqli_real_escape() via iformReq()
	$redirect = THIS_PAGE; //global var used for following formReq redirection on failure
	$FeedName = trim(iformReq('FeedName',$iConn2));
  
    
    $FeedName = preg_replace("/(?![.,=$'€%-])\p{P}/u", "", $FeedName);
    $FeedDescription = iformReq('FeedDescription',$iConn2);
	$FeedURL = iformReq('FeedURL',$iConn2);
	$FeedSearch = iformReq('FeedSearch',$iConn2);


    $FeedSlugArray = explode(" ", strtolower($FeedName));
    $FeedSlug = implode("-", $FeedSlugArray);
	
	//next check for specific issues with data
	if(!ctype_print($FeedName))
	{//data must be alphanumeric or punctuation only	
		feedback("Feed Name must contain only letters, numbers or spaces");
		myRedirect(THIS_PAGE);
	}

    //build string for SQL insert with replacement vars, %s for string, %d for digits 
    $sql = "INSERT INTO sm17_news_feeds VALUES 
    (NULL, '%d', '%s', '%s', '%s', '%s', '%s', NOW(), NOW())"; 

    # sprintf() allows us to filter (parameterize) form data 
	$sql = sprintf($sql,
        $CatId,
        $FeedName,
        $FeedSlug,
        $FeedDescription,
        $FeedSearch,
        $FeedURL);

	@mysqli_query($iConn2,$sql) or die(trigger_error(mysqli_error($iConn), E_USER_ERROR));
	#feedback success or failure of update
	if (mysqli_affected_rows($iConn2) > 0)
	{//success!  provide feedback, chance to change another!
		feedback("RSS Feed Added Successfully!","notice");
	}else{//Problem!  Provide feedback!
		feedback("RSS Feed NOT added!");
	}
	myRedirect(THIS_PAGE . "?id=" . $CatId);
}


