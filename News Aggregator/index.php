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
 * @todo !!! implement persistent sessions and cached feed data
 * @todo NTH Add Feeds
 * @todo NTH Update Feeds
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
$sql = 
"
    SELECT
        nf.FeedID,
        nf.NewsCategoryID,
        nc.Name 'CategoryName',
        nf.Name,
        nf.Description,
        nf.Feed,
        date_format(nf.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded' 
    FROM " . PREFIX . "news_feeds nf 
    INNER JOIN " . PREFIX . "news_categories nc ON nf.NewsCategoryID = nc.NewsCategoryID 
    ORDER BY nf.NewsCategoryID
";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'News Feeds';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'SCC,Seattle Central, ITC250, XML, RSS News Feeds ' . $config->metaDescription;
$config->metaKeywords = 'RSS,News,PHP'. $config->metaKeywords;

/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h2 align="center">ITC250 SU17 Project 3</h2>
<h3 align="center">RSS News Feeds</h3>

<p>RSS (Rich Site Summary) Google News feed links for a variety of popular topics.</p>
 
<?php
#reference images for pager
$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

# dumpDie(mysqli_fetch_assoc($result));
if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "news feed";}else{$itemz = "news feeds";}  deal with plural
    echo '<div align="center"><h4>We have ' . $myPager->showTotal() . ' ' . $itemz . '!</h4></div>';
    echo '
    <table class="table table-striped table-hover ">
      <thead>
        <tr>
          <th>Category</th>
          <th>RSS Feed Name</th>
          <th>Feed Description</th>
          <th>Date Added</th>
        </tr>
      </thead>
      <tbody>
    ';
    $currentCategory='';
	while($row = mysqli_fetch_assoc($result))
	{# process each row
                #<td><a href="' . VIRTUAL_PATH . 'surveys/survey_view.php?id=' . (int)$row['SurveyID'] . '">' . dbOut($row['Title']) . '</a></td>
        if ($currentCategory == dbOut($row['CategoryName'])) {
            $showCategory = '';
        }else{
            $currentCategory = dbOut($row['CategoryName']);
            $showCategory = $currentCategory;
        }
        echo '
            <tr>
                <td><b>' . $showCategory . '</b></td>
                <td><a href="' . VIRTUAL_PATH . 'news/news_view.php?id=' . (int)$row['FeedID'] . '">' . dbOut($row['Name']) . '</a></td>
                <td>' . dbOut($row['Description']) . '</td>
                <td>' . dbOut($row['DateAdded']) . '</td>
            </tr>
            ';
	}
    echo '
      </tbody>
    </table>
    ';
	echo $myPager->showNAV(); # show paging nav, only if enough records
}else{#no records
    echo "<div align=center>There are currently no news feeds</div>";	
}
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
