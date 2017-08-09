<?php
/**
 * @package newsfeeds
 * @author Anu Slorah
 * @author Kyrrah Nork
 * @author Ron Nims <rleenims@gmail.com>
 * @link http://www.artdevsign.com/
 * @version 0.1 2017/07/17
 * Copyright [2017] [Ron Nims]
 * http://www.apache.org/licenses/LICENSE-2.0
 * @see category.php
 * @see Pager.php 
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}

switch ($myAction) 
{//check 'act' for type of process
	case "add": //2) Form for adding new category
	 	addForm();
	 	break;
	case "insert": //3) Insert new category
		insertExecute();
		break; 
	default: //1)Show existing categories
	 	showCategories();
}

function showCategories()
{//Select Customer
	global $config;
	get_header();
	echo '<h3 align="center">' . smartTitle() . '</h3>';
	echo '<h4 align="center">List of Current Categories</h4>';

        $sql = "
            SELECT
                NewsCategoryID,
                Name,
                Slug,
                Description,
                date_format(DateAdded, '%W %D %M %Y %H:%i') 'DateAdded',
                date_format(LastUpdated, '%W %D %M %Y %H:%i') 'LastUpdated' 
            FROM " . PREFIX . "news_categories nc
            ";
    
	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
	if (mysqli_num_rows($result) > 0)//at least one record!
	{//show results
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
		while ($row = mysqli_fetch_assoc($result))
		{//dbOut() function is a 'wrapper' designed to strip slashes, etc. of data leaving db
			echo '<tr>
					<td><a href="' . VIRTUAL_PATH . 'news/feed_list.php?id=' . (int)$row['NewsCategoryID'] . '">' . dbOut($row['Name']) . '</a></td>
                    <td>' . dbOut($row['Description']) . '</td>
                </tr>
				';
		}
		echo '</table>';
	}else{//no records
      echo '<div align="center"><h3>Currently No Categories in Database.</h3></div>';
	}
	echo '<div align="center"><a href="' . THIS_PAGE . '?act=add">ADD CATEGORY</a></div>';
	@mysqli_free_result($result); //free resources
	get_footer();
}

function addForm()
{# shows details from a single customer, and preloads their first name in a form.
	global $config;
	
	get_header();
	echo '<h3 align="center">' . smartTitle() . '</h3>
	<h4 align="center">Add Category</h4>
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
	<table align="center">
	   <tr><td align="right">Category Name</td>
		   	<td>
		   		<input type="text" name="CategoryName" />
		   		<font color="red"><b>*</b></font> <em>(alphanumerics & spaces)</em>
		   	</td>
	   </tr>
	   <tr><td align="right">Category Description</td>
		   	<td>
		   		<input type="text" name="CategoryDescription" size="56"/>
		   	</td>
	   </tr>
	   <input type="hidden" name="act" value="insert" />
	   <tr>
	   		<td align="center" colspan="2">
	   			<input type="submit" value="Add New Category">
	   		</td>
	   </tr>
	</table>    
	</form>
	<div align="center"><a href="' . THIS_PAGE . '">Exit Without Add</a></div>
	';
	get_footer();
	
}

function insertExecute()
{
	$iConn = IDB::conn();//must have DB as variable to pass to mysqli_real_escape() via iformReq()
	
	$redirect = THIS_PAGE; //global var used for following formReq redirection on failure

	$CategoryName = trim(iformReq('CategoryName',$iConn));
	$CategoryName = preg_replace("/(?![.,=$'€%-])\p{P}/u", "", $CategoryName);
	$CategoryDescription = iformReq('CategoryDescription',$iConn);

    //$CategorySlug = $CategoryName;
    $CategorySlugArray = explode(" ", strtolower($CategoryName));
    $CategorySlug = implode("-", $CategorySlugArray);
	
	//next check for specific issues with data
	if(!ctype_print($CategoryName))
	{//data must be alphanumeric or punctuation only	
		feedback("CategoryName must contain only letters, numbers or spaces");
		myRedirect(THIS_PAGE);
	}

    //build string for SQL insert with replacement vars, %s for string, %d for digits 
    $sql = "INSERT INTO sm17_news_categories VALUES 
    (NULL, '%s', '%s', '%s', NOW(), NOW())"; 

    # sprintf() allows us to filter (parameterize) form data 
	$sql = sprintf($sql,$CategoryName,$CategorySlug,$CategoryDescription);
    

	@mysqli_query($iConn,$sql) or die(trigger_error(mysqli_error($iConn), E_USER_ERROR));
	#feedback success or failure of update
	if (mysqli_affected_rows($iConn) > 0)
	{//success!  provide feedback, chance to change another!
		feedback("Category Added Successfully!","notice");
	}else{//Problem!  Provide feedback!
		feedback("Category NOT added!");
	}
	myRedirect(THIS_PAGE);
}

