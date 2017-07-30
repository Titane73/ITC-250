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

require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to index.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $feedID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "news/index.php");
}

$myFeed = new Feed($feedID);

if($myFeed->IsValid)
{#only load data if record found
	$config->titleTag = $myFeed->Name . " RSS News Feeds built with PHP & XML"; 
}

# END CONFIG AREA ---------------------------------------------------------- 
get_header(); #defaults to theme header or header_inc.php

if($myFeed->IsValid)
{#records exist - show Feed 
    echo '
    <h3 align="center"> Category: <i><b>' . $myFeed->CategoryName .
        '</b></i>, RSS Feed: <i><b>' . $myFeed->Name . '</b></i></h3>
    ';

    //our simplest example of consuming an RSS feed

    $response = file_get_contents($myFeed->Feed);
    $xml = simplexml_load_string($response);
    print '<h1>' . $xml->channel->title . '</h1>';

    foreach($xml->channel->item as $story) {
        //echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
        echo '<p>' . $story->description . '</p><br /><br />';
    }
}else{//no such Feed!
    echo '<div align="center">ERROR: No such Feed for ID=' . $feedID . '</div>';
}

echo '<div align="center"><a href="' . VIRTUAL_PATH . 'news/index.php">Back</a></div>';

get_footer(); #defaults to theme footer or footer_inc.php

class Feed
{
    public $FeedID = 0;
    public $NewsCategoryID = 0;
    public $CategoryName = '';
    public $Name= '';
    public $Feed = '';
    public $IsValid = false;
    
    public function __construct($id)
    {
        $id = (int)$id;//cast to integer disallows SQL injection
        $sql = "SELECT
                    FeedID,
                    NewsCategoryID,
                    Name,
                    Feed
                FROM " . PREFIX . "news_feeds where FeedID = " . $id;

        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
            $this->IsValid = true;//record found!
            while ($row = mysqli_fetch_assoc($result))
            {
                $this->FeedID = $id;
                $this->NewsCategoryID = dbOut($row['NewsCategoryID']);
                $this->Name = dbOut($row['Name']);
                $this->Feed = dbOut($row['Feed']);
            }
        }

        @mysqli_free_result($result); # We're done with the data!

        //---look up category name
        $sql = "SELECT
                    Name
                FROM " . PREFIX . "news_categories
                WHERE NewsCategoryID = " . $this->NewsCategoryID;
        
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
            while ($row = mysqli_fetch_assoc($result))
            {
                $this->CategoryName= dbOut($row['Name']); 
            }
        }
        
        @mysqli_free_result($result); # We're done with the data!

    }// END class Feed Constructor
    
} // END class Feed

