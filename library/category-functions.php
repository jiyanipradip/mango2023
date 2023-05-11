<?php
require_once 'config.php';

/*********************************************************
*                 CATEGORY FUNCTIONS 
*********************************************************/

/*
	Return the current category list which only shows
	the currently selected category and it's children.
	This function is made so it can also handle deep 
	category levels ( more than two levels )
*/
function formatCategories($categories)
{
	// $navCat stores all children categories
	// of $parentId
	$navCat = array();
	
	// expand only the categories with the same parent id
	// all other remain compact
	$ids = array();
	foreach ($categories as $category) {
//		if ($category['cat_parent_id'] == $parentId) 
{
			$navCat[] = $category;
		}
		
		// save the ids for later use
		$ids[$category['SubCatId']] = $category;
	}	

	

	return $navCat;
}

/*
	Get all top level categories
*/
function getCategoryList()
{
	$sql = "SELECT CatagoryId, CatagoryName
	        FROM catgmaster
			ORDER BY CatagoryName";
    $result = dbQuery($sql);
    
    $cat = array();
    while ($row = dbFetchAssoc($result)) {
		extract($row);
		$cat[] = array('url'   => $_SERVER['PHP_SELF'] . '?cc=' . $CatagoryId,
		              
					   'name'  => $CatagoryName);

    }
	
	return $cat;			
}

function getCategoryList1()
{
	$catId  = (isset($_GET['cc']) && $_GET['cc'] != '1') ? $_GET['cc'] : 0;
	$sql1 = "SELECT CatagoryName
	        FROM catgmaster where CatagoryId = '$catId'
			ORDER BY CatagoryName";
    $result1 = mysql_query($sql1) or die(mysql_error());
	$data1=mysql_fetch_assoc($result1);
	$sql = "SELECT CatagoryId,SubCatId, SubCatName
	        FROM subcatgmaster where CatagoryId = '$catId'
			ORDER BY SubCatName";
    $result = dbQuery($sql);
    $cat = array();
    while ($row = dbFetchAssoc($result))
	{
		extract($row);
		$cat[] = array('url'   => 'index.php' . '?c=' . $SubCatId . '&cc=' . $CatagoryId,
		              
					   'name'  => $SubCatName);
    }
	return $cat;			
}
/*
	Fetch all children categories of $id. 
	Used for display categories
*/
function getChildCategories($categories, $id, $recursive = true)
{
	if ($categories == NULL)
	{
		$categories = fetchCategories();
	}
	$n     = count($categories);
	$child = array();
	for ($i = 0; $i < $n; $i++)
	{
		$catId    = $categories[$i]['SubCatId'];
		 {
			$child[] = $catId;
			if ($recursive)
			{
				$child   = array_merge($child, getChildCategories($categories, $catId));
			}	
		}
	}
	return $child;
}

function fetchCategories()
{
    $sql = "SELECT SubCatId, SubCatName
	        FROM subcatgmaster
			ORDER BY SubCatId";
    $result = dbQuery($sql);
    
    $cat = array();
    while ($row = dbFetchAssoc($result))
	{
        $cat[] = $row;
    }
	
	return $cat;
}
?>