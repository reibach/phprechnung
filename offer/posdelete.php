<?php

/*
	posdelete.php

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

if(!is_numeric($tmpPosID) || $tmpPosID <= 0 )
{
	die(header("Location: $web"));
}

if(isset($MethodOfPayment))
	$smarty->assign("NR_METHOD_OF_PAYMENT","$MethodOfPayment");

// Assign needed text from language file
//
$smarty->assign("Title","$a[position] - $a[delete]");
$smarty->assign("PositionName","$a[pos_name]");


// Database connection
//
DBConnect();

$query1 = $db->Execute("SELECT P.POSITIONID, P.POS_NAME, T.POSITIONID FROM {$TBLName}article AS P, {$TBLName}tmp_offer AS T WHERE T.POSITIONID=P.POSITIONID AND TMP_OFFERID=$tmpPosID");

// If an error has occurred, display the error message
//
if (!$query1)
	print($db->ErrorMsg());
else
	foreach($query1 as $f)
	{
		$smarty->assign("POSITIONID",$f['POSITIONID']);
		$smarty->assign("POS_NAME",$f['POS_NAME']);
	}

$smarty->display('offer/posdelete.tpl');

?>
