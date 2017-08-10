<?php
/**
 * @package NewsViews
 * @author Anu Slorah
 * @author Kyrrah Nork
 * @author Ron Nims <rleenims@gmail.com>
 * @link http://www.artdevsign.com/
 * @version 0.1 2017/07/17
 * Copyright [2017] [Ron Nims]
 * http://www.apache.org/licenses/LICENSE-2.0
 * @see news_view.php
 * @see Pager.php 
 */

class Feed
{
    public $FeedID = 0;
    public $Name= '';
    public $Slug= '';
    public $Description= '';
    public $Search = '';
    public $Feed = '';
    public $DateAdded = '';
    public $LastUpdated = '';
    public $IsValid = false;
    
    // function clearAllCaches - clear all feed caches
    // the only session variables are for caches so unset all
    public static function clearAllCaches()
    {
        session_unset();
    }
        
    
    public function __construct($id)
    {
        $id = (int)$id;//cast to integer disallows SQL injection

        $sql = "
            SELECT
                FeedID,
                Name,
                Slug,
                Description,
                Search,
                Feed,
                date_format(DateAdded, '%W %D %M %Y %H:%i') 'DateAdded',
                date_format(LastUpdated, '%W %D %M %Y %H:%i') 'LastUpdated' 
            FROM " . PREFIX . "news_feeds nf 
            WHERE FeedID = " . $id;
        
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
            $this->IsValid = true;//record found!
            while ($row = mysqli_fetch_assoc($result))
            {
                $this->FeedID = $id;
                $this->Name = dbOut($row['Name']);
                $this->Slug = dbOut($row['Slug']);
                $this->Description = dbOut($row['Description']);
                $this->Search = dbOut($row['Search']);
                $this->Feed = dbOut($row['Feed']);
                $this->DateAdded = dbOut($row['DateAdded']);
                $this->LastUpdated = dbOut($row['LastUpdated']);
            }
        }

        @mysqli_free_result($result); # We're done with the data!

    }// END class Feed Constructor
    
    // function getRSS - return RSS Feed object
    public function getRSS()
    {
        if ( !isset($_SESSION['Feed' . $this->FeedID]) || $this->stale() ) {
            // create unique session variable containing Feed object
            $response = file_get_contents($this->Feed);
            $_SESSION['Feed' . $this->FeedID] = $response;
            // update session timestamp variable
            $_SESSION['FeedTime' . $this->FeedID] = getdate()['0'];
        }else{
            $response = $_SESSION['Feed' . $this->FeedID];    
        }
        
        // return Feed object from the session variable
        $rssObject = simplexml_load_string($response);
        return $rssObject;
    }

    // function stale - has Cached Feed object expired?
    private function stale()
    {
        define ('CACHE_TIMEOUT', 600); // in seconds, 600 = 10 minutes
        
        if ( isset($_SESSION['FeedTime' . $this->FeedID]) ) {        
            $expiresTime = $_SESSION['FeedTime' . $this->FeedID] + CACHE_TIMEOUT;

            if ( $expiresTime < getdate()['0'] ) {
                $expired = true;
            }else{
                $expired = false;
            }
        }else{
            $expired = true;            
        }
        return $expired;    
    }
      
    // function clearFeedCache - delete session variables for this feed
    public function clearFeedCache()
    {
        if ( isset($_SESSION['Feed' . $this->FeedID]) ) {        
            unset($_SESSION['Feed' . $this->FeedID]);
            unset($_SESSION['FeedTime' . $this->FeedID]);
        }
    }
        
    // function timeStamp - return timestamp of latest cache data 
    public function timeStamp()
    {
        return $_SESSION['FeedTime'.$this->FeedID];        
    }
    
} // END class Feed
