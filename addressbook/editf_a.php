<?php

/*
	editf.php

	phpRechnung - is easy-to-use Web-based multilingual accounting software.
	Copyright (C) 2001 - 2010 Edy Corak < edy at loenshotel dot de >

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

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

if(!is_numeric($myID) || $myID <= 0 )
{
	die(header("Location: $web"));
}

if(isset($infoID) && $infoID == "10")
{
	$Searchstring = "&CustomerID=$CustomerID&Prefix1=$Prefix1&Title11=$Title11&Firstname1=$Firstname1&Initials1=$Initials1&Lastname1=$Lastname1&Phonehome1=$Phonehome1&Salutation1=$Salutation1&Mobile1=$Mobile1&Address1=$Address1&Fax1=$Fax1&Stateprov1=$Stateprov1&Email1=$Email1&Postalcode1=$Postalcode1&City1=$City1&Url1=$Url1&Company1=$Company1&Phonework1=$Phonework1&Department1=$Department1&Phoneoffi1=$Phoneoffi1&Position11=$Position11&Phoneothe1=$Phoneothe1&Pager1=$Pager1&Note1=$Note1&Country1=$Country1&Date_From1=$Date_From1&Date_Till1=$Date_Till1&Birthday1=$Birthday1&Category1=$Category1&MethodOfPayment1=$MethodOfPayment1&PrintName1=$PrintName1";
}

// Database connection
//
DBConnect();

// Get the creator
//
$query = $db->Execute("SELECT MYID, CREATEDBY FROM {$TBLName}addressbook WHERE MYID=$myID");
$row = $query->GetRows();

// If an error has occurred, display the error message
//
if (!$query)
	print $db->ErrorMsg();
else
	foreach($row as $f)
	{
		$CreatedBy = $f['CREATEDBY'];
	}

function UserInput($mark)
{
	global $smarty;

	$smarty->assign("mark",$mark);
	$smarty->assign("EditForm","3");
}

if (empty($myID))
{
	$smarty->assign("FieldError","$a[customer_no] - $a[field_error]");
	UserInput("");
	$smarty->display('addressbook/editf.tpl');
}
else if (empty($UserName))
{
	$smarty->assign("FieldError","$a[username] - $a[field_error]");
	UserInput("UserName");
	$smarty->display('addressbook/editf.tpl');
}
else if (empty($Password1))
{
	$smarty->assign("FieldError","$a[password] - $a[field_error]");
	UserInput("Password1");
	$smarty->display('addressbook/editf.tpl');
}
else if (empty($Password2))
{
	$smarty->assign("FieldError","$a[password] - $a[field_error]");
	UserInput("Password1");
	$smarty->display('addressbook/editf.tpl');
}
else if ($Password1 != $Password2)
{
	$smarty->assign("FieldError","$a[password_error]");
	UserInput("Password1");
	$smarty->display('addressbook/editf.tpl');
}
else if(isset($_SESSION['Username']) && $_SESSION['Username'] != $root && $_SESSION['Usergroup1'] != $admingroup_1 && $_SESSION['Usergroup2'] != $admingroup_2 && $_SESSION['Username'] != $CreatedBy)
{
	$smarty->assign("FieldError","$a[no_permission]");
	UserInput("");
	$smarty->display('addressbook/editf.tpl');
}
else
{
	$query1 = $db->Execute("SELECT MYID, DECODE(USERNAME,'$pkey') AS USERNAME FROM {$TBLName}addressbook WHERE DECODE(USERNAME,'$pkey')='$UserName' AND MYID != $myID");
	$numrows1 = $query1->RowCount();

	if ($numrows1) {
		$smarty->assign("FieldError","$a[entry_exist] - $a[username]");
		UserInput("UserName");
		$smarty->display('addressbook/editf.tpl');
	}
	else
	{
		$query3 = "UPDATE {$TBLName}addressbook SET MODIFIEDBY='$_SESSION[Username]', MODIFIED='$CurrentDateTime', PASSWORD=ENCODE('$Password1','$pkey'), USERLANGUAGE='$UserLanguage', USERNAME=ENCODE('$UserName','$pkey'), USER_ACTIVE='$UserActive' WHERE MYID=$myID";

		if ($db->Execute($query3) === false)
		{
			die($db->ErrorMsg());
		}

		$_SESSION['EditID'] = "1";
	}

	if($infoID == '9')
	{
		Header("Location: $web/addressbook/searchlist.php?myID=$myID&page=$page&Customer=$Customer&Order=$Order&Sort=$Sort&$sessname=$sessid#$myID");
	}
	else if($infoID == '10')
	{
		Header("Location: $web/addressbook/searchlist_e.php?myID=$myID&page=$page$Searchstring&Order=$Order&Sort=$Sort&$sessname=$sessid#$myID");
	}
	else
	{
		Header("Location: $web/addressbook/list.php?myID=$myID&page=$page&Order=$Order&Sort=$Sort&$sessname=$sessid#$myID");
	}
}

?>
