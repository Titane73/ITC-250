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

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
$sql = 
"
    SELECT
        NewsCategoryID,
        Name,
        Description
    FROM " . PREFIX . "news_categories nc  
    ORDER BY Name
";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'News Feeds';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'SCC,Seattle Central, ITC250, XML, RSS News Feeds ' . $config->metaDescription;
$config->metaKeywords = 'RSS,News,PHP'. $config->metaKeywords;

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
	if($myPager->showTotal()==1){$itemz = "news category";}else{$itemz = "news categories";} # deal with plural
    echo '<div align="center"><h4>We have ' . $myPager->showTotal() . ' ' . $itemz . ' today</h4></div>';
    echo '
    <table class="table table-striped table-hover ">
      <thead>
        <tr>
          <th>Category</th>
          <th>Category Description</th>
        </tr>
      </thead>
      <tbody>
    ';

	while($row = mysqli_fetch_assoc($result))
	{# process each row
        echo '
            <tr>
                <td><a href="' . VIRTUAL_PATH . 'news/feed_list.php?id=' . (int)$row['NewsCategoryID'] . '">' . dbOut($row['Name']) . '</a></td>
                <td>' . dbOut($row['Description']) . '</td>
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
