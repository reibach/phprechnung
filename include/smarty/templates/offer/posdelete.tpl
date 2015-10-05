{*
	posdelete.tpl

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
*}
{include file="header.tpl"}
<body>
{include file="htable.tpl"}
<table border="0" width="100%" cellspacing="0" cellpadding="0" summary="Tabelle 3"><tbody>
<tr><td id="td1_20" width="20%" valign="top">
{* Menubar start *}
<table border="0" width="80%" cellspacing="0" cellpadding="0" summary="Tabelle 4"><tbody>
{if $smarty.session.SuperUser and ( $smarty.session.SuperUser eq $Root )}
	<tr><td align="center" class="phprechnung_menu"><a accesskey="L" title="{$Logout}"
	href="../login/suend.php?{$Session}">{$Logout}</a></td></tr>
{else}
	<tr><td align="center" class="phprechnung_menu"><a accesskey="L" title="{$Logout}"
	href="../login/logout.php?{$Session}">{$Logout}</a></td></tr>
{/if}
<tr><td align="left" class="phprechnung_menu"><a accesskey="W" title="{$Startpage}"
href="../index.php?{$Session}">{$Startpage}</a></td></tr>
<tr><td align="left" class="phprechnung_menu"><a accesskey="A" title="{$Addressbook}"
href="../addressbook/list.php?{$Session}">{$Addressbook}</a></td></tr>
<tr><td align="left" class="phprechnung_menu"><a accesskey="P" title="{$Position}"
href="../position/list.php?{$Session}">{$Position}</a></td></tr>
<tr><td align="left" class="phprechnung_menu_sel"><a accesskey="O" title="{$Offer} - {$List}"
href="list.php?{$Session}">{$Offer}</a></td></tr>
<tr><td align="left" class="phprechnung_menu_sub"><a accesskey="1" title="{$Offer} - {$New}"
href="new.php?{$Session}">{$New}</a></td></tr>
<tr><td align="left" class="phprechnung_menu_sub"><a accesskey="2" title="{$Offer} - {$Search}"
href="search.php?{$Session}">{$Search}</a></td></tr>
<tr><td align="left" class="phprechnung_menu_sub"><a accesskey="3" title="{$Offer} - {$Help}"
href="help.php?{$Session}">{$Help}</a></td></tr>
<tr><td align="left" class="phprechnung_menu"><a accesskey="I" title="{$Invoice}"
href="../invoice/list.php?{$Session}">{$Invoice}</a></td></tr>
<tr><td align="left" class="phprechnung_menu"><a accesskey="M" title="{$Payment}"
href="../payment/list.php?{$Session}">{$Payment}</a></td></tr>
<tr><td align="left" class="phprechnung_menu"><a accesskey="C" title="{$Cashbook}"
href="../cashbook/list.php?{$Session}">{$Cashbook}</a></td></tr>
<tr><td align="left" class="phprechnung_menu"><a accesskey="R" title="{$Reports}"
href="../reports/index.php?{$Session}">{$Reports}</a></td></tr>
<tr><td align="left" class="phprechnung_menu"><a accesskey="S" title="{$Configuration}"
href="../configuration.php?{$Session}">{$Configuration}</a></td></tr>
{if $smarty.session.Username and ( $smarty.session.Username neq $Root )}
	<tr><td align="left" class="phprechnung_menu"><a accesskey="U" title="{$Superuser}"
	href="../login/sustart.php?{$Session}">{$Superuser}</a></td></tr>
{/if}
</tbody></table></td>
{* Menubar end *}
<td id="td1_2" width="2%"></td><td width="78%" valign="top" align="center">
<table width="80%" border="0" class="phprechnung_tabelle" cellpadding="2" cellspacing="0" summary="Tabelle 1"><tbody>
{if $offerID}
	<tr>
		<td valign="middle" align="left">
		[&nbsp;<a title="{$BackMsg} - {$Offer} - {$Edit}" class="ninfolink" href="edit.php?page={$page}&amp;myID={$myID}&amp;offerID={$offerID}&amp;infoID={$infoID}&amp;tmpID=1&amp;messageID={$messageID}&amp;OfferDate={$OfferDate}&amp;OfferStatus={$OfferStatus}&amp;MethodOfPayment={$NR_METHOD_OF_PAYMENT}&amp;MethodOfPaymentDate={$MethodOfPaymentDate}&amp;Note={$Note}&amp;OfferID1={$OfferID1}&amp;CustomerID1={$CustomerID1}&amp;DateFrom1={$DateFrom1}&amp;DateTill1={$DateTill1}&amp;Total1={$Total1}&amp;Customer1={$Customer1}&amp;Order={$Order}&amp;Sort={$Sort}&amp;Canceled={$Canceled}&amp;{$Session}#{$offerID}">{$BackMsg}</a>&nbsp;]
		</td>
	</tr>
{else}
	<tr>
		<td valign="middle" align="left">
		[&nbsp;<a title="{$BackMsg} - {$Offer} - {$New}" class="ninfolink" href="new.php?page={$page}&amp;myID={$myID}&amp;offerID={$offerID}&amp;infoID={$infoID}&amp;tmpID=1&amp;messageID={$messageID}&amp;OfferDate={$OfferDate}&amp;OfferStatus={$OfferStatus}&amp;MethodOfPayment={$NR_METHOD_OF_PAYMENT}&amp;MethodOfPaymentDate={$MethodOfPaymentDate}&amp;Note={$Note}&amp;Order={$Order}&amp;Sort={$Sort}&amp;Canceled={$Canceled}&amp;{$Session}#{$offerID}">{$BackMsg}</a>&nbsp;]
		</td>
	</tr>
{/if}
<tr><td align="center" colspan="2"><h2>{$Position} - {$Delete}</h2></td></tr>
<tr><td align="center" colspan="2">{$PositionName} [ {$POS_NAME} ] - {$EntryNo}: {$tmpPosID}</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td align="center" valign="top" colspan="2">
<form action="posdeletef.php?{$Session}" method="post">
<input type="hidden" name="myID" value="{$myID}" />
<input type="hidden" name="offerID" value="{$offerID}" />
<input type="hidden" name="infoID" value="{$infoID}" />
<input type="hidden" name="tmpID" value="{$offerID}" />
<input type="hidden" name="tmpPosID" value="{$tmpPosID}" />
<input type="hidden" name="messageID" value="{$messageID}" />
<input type="hidden" name="OfferDate" value="{$OfferDate}" />
<input type="hidden" name="OfferStatus" value="{$OfferStatus}" />
<input type="hidden" name="MethodOfPayment" value="{$NR_METHOD_OF_PAYMENT}" />
<input type="hidden" name="MethodOfPaymentDate" value="{$MethodOfPaymentDate}" />
<input type="hidden" name="Note" value="{$Note}" />
{if $infoID eq 9}
	<input type="hidden" name="OfferID1" value="{$OfferID1}" />
	<input type="hidden" name="CustomerID1" value="{$CustomerID1}" />
	<input type="hidden" name="DateFrom1" value="{$DateFrom1}" />
	<input type="hidden" name="DateTill1" value="{$DateTill1}" />
	<input type="hidden" name="Total1" value="{$Total1}" />
	<input type="hidden" name="Customer1" value="{$Customer1}" />
{/if}
<input type="hidden" name="page" value="{$page}" />
<input type="hidden" name="Order" value="{$Order}" />
<input type="hidden" name="Sort" value="{$Sort}" />
<input type="hidden" name="Canceled" value="{$Canceled}" />
<input class="button" type="submit" title="{$Position} - {$Delete}" value="{$Delete}" />
</form>
</td></tr>
<tr><td>&nbsp;</td></tr>
</tbody></table>
</td></tr>
<tr><td id="td2_20" width="20%"><br /></td><td id="td2_2" width="2%"></td>
<td width="78%" valign="top"><br /></td></tr></tbody></table>
{include file="footer.tpl"}
