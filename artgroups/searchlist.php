<?php
require_once("../include/phprechnung.inc.php");
require_once("../include/smarty.inc.php");

CheckUser();
CheckSession();

$ArrayValue = CheckArrayValue($_REQUEST);

foreach($ArrayValue as $key => $val)
{
	$$key = $val;
	$smarty->assign("$key",$val);
}

if(!isset($page) || !is_numeric($page) || $page <= 0 )
{
	$page = 1;
}

if(!isset($Sort) || $Sort !== 'ASC' && $Sort !== 'DESC')
{
	$Sort = "";
}

if(empty($Order) || $Order !== 'ARTGROUPSID' && $Order !== 'DESCRIPTION')
{
	$Order = "DESCRIPTION";
	$Sort = "";
}

$smarty->assign("Title","$a[article] - $a[art_groups] - $a[searchresult]");
$smarty->assign("EntryChanged","$a[entry_changed]");
$smarty->assign("EntryDeleted","$a[entry_deleted]");

// Database connection
//
DBConnect();

$intCursor = ($page - 1) * $EntrysPerPage;

// Get Article Group Information
//
$query = $db->Execute("SELECT ARTGROUPSID, DESCRIPTION FROM artgroups WHERE DESCRIPTION LIKE '%$Description_1%' ORDER BY $Order $Sort LIMIT $intCursor, $EntrysPerPage");

// If an error has occurred, display the error message
//
if (!$query)
	print($db->ErrorMsg());
else
	// Count only PageRows depend on $query
	//
	$pagenumrows = $query->RecordCount();

	// Count MaxRows
	//
	$query1 = $db->Execute("SELECT ARTGROUPSID, DESCRIPTION FROM artgroups WHERE DESCRIPTION LIKE '%$Description_1%' ORDER BY $Order $Sort");

	$numrows = $query1->RecordCount();

	// Save MaxPages
	//
	$intPages = ceil($numrows/$EntrysPerPage);

	// Save all entrys in $artgroupsData
	//
	foreach($query as $result)
	{
		$ArtGroupsData[] = $result;
	}

	if(isset($ArtGroupsData))
		$smarty->assign('ArtGroupsData', $ArtGroupsData);
	$smarty->assign("PageRows","$pagenumrows");
	$smarty->assign("MaxRows","$numrows");

// Display pager only if $numrows > $EntrysPerPage ( lines per page )
// from settings menu
//
if ($numrows > $EntrysPerPage)
{
	$smarty->assign('CurrentPage', "$page");
	$smarty->assign('MaxPages', "$intPages");
	$smarty->assign('AddCurrentPage', "page=$page&amp;");

	// If we are not on first page then display
	// first page, previous page link
	//
	if ($page > 1)
	{
		$Page = $page - 1;
		$smarty->assign('PrevPage', "$Page");
	}

	// If we are not on the last page then display
	// next page, last page link
	//
	if ($page < $intPages)
	{
		$Page = $page + 1;
		$smarty->assign('NextPage', "$Page");
	}
}

$smarty->display('artgroups/searchlist.tpl');

unset($_SESSION['EditID']);
unset($_SESSION['DeleteID']);

?>
