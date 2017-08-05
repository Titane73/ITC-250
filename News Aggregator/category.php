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
require 'feed.php';
    
class Category
{
    public $NewsCategoryID = 0;
    public $Name= '';
    public $Slug= '';
    public $Description= '';
    public $DateAdded = '';
    public $LastUpdated = '';
    public $Feeds = array();
    public $IsValid = false;
    
    public function __construct($id)
    {
        $id = (int)$id;//cast to integer disallows SQL injection

        $sql = "
            SELECT
                NewsCategoryID,
                Name,
                Slug,
                Description,
                date_format(DateAdded, '%W %D %M %Y %H:%i') 'DateAdded',
                date_format(LastUpdated, '%W %D %M %Y %H:%i') 'LastUpdated' 
            FROM " . PREFIX . "news_categories nc  
            WHERE NewsCategoryID = " . $id;
        
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
            $this->IsValid = true;//record found!
            while ($row = mysqli_fetch_assoc($result))
            {
                $this->NewsCategoryID = $id;
                $this->Name = dbOut($row['Name']);
                $this->Slug = dbOut($row['Slug']);
                $this->Description = dbOut($row['Description']);
                $this->DateAdded = dbOut($row['DateAdded']);
                $this->LastUpdated = dbOut($row['LastUpdated']);
            }
        }
        @mysqli_free_result($result); # We're done with the data!
        
        //populate Feeds array
        $sql = "
            SELECT
                FeedID,
                NewsCategoryID
            FROM " . PREFIX . "news_feeds nf  
            WHERE NewsCategoryID = " . $id;
        
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
            while ($row = mysqli_fetch_assoc($result))
            {
                $myFeed = new Feed(dbOut($row['FeedID']));
                array_push($this->Feeds, $myFeed);
            }
        }

        @mysqli_free_result($result); # We're done with the data!

    }// END class Feed Constructor
    

    
} // END class Category
