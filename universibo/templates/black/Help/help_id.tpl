{* parametro: showHelpId_langArgomento     array di argomenti (id, titolo, contenuto)*}
<table width="100%" border="0" cellspacing="0" cellpadding="1" summary="">
<tr><td>	
	<table width="100%" border="0" cellspacing="0" cellpadding="1" summary="">
	<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" summary=""><tr><td bgcolor="#000099" align="left"><img src="img/rule_piccoloL.gif" width="200" height="2" alt="" /></td><td bgcolor="#000099" align="right"><img src="img/rule_piccoloR.gif" width="200" height="2" alt="" /></td></tr></table></td></tr>
	{foreach from=$showHelpId_langArgomento item=temp_helpid}
	<tr><td class="Menu" bgcolor="{cycle values="#000016,#000032"}">&nbsp;<img src="tpl/black/elle_begin.gif" width="10" height="12" alt="" />
	<a href="{$temp_helpid.id|escape:"htmlall"}"> {$temp_helpid.titolo|escape:"htmlall"}</a></td></tr>
	{/foreach}
	<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" summary=""><tr><td bgcolor="#000099" align="left"><img src="img/rule_piccoloL.gif" width="200" height="2" alt="" /></td><td bgcolor="#000099" align="right"><img src="img/rule_piccoloR.gif" width="200" height="2" alt="" /></td></tr></table></td></tr> 
	</table>
</td></tr>	
<tr><td>	
	<table width="100%" border="0" cellspacing="0" cellpadding="1" summary="">
	{foreach from=$showHelpId_langArgomento item=temp_helpid}
	<tr><td class="Title" bgcolor="{cycle values="#000016,#000032"}">&nbsp;<img src="tpl/black/elle_begin.gif" width="10" height="12" alt="" />
	<a name="{$temp_helpid.id|escape:"htmlall"}" id="{$temp_helpid.id|escape:"htmlall"}"> {$temp_helpid.titolo|escape:"htmlall"}</a></td></tr>
	<tr><td class="Menu" bgcolor="{cycle values="#000016,#000032"}">{$temp_helpid.contenuto|escape:"htmlall"}</td></tr>
	{/foreach} 
	</table>
	<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" summary=""><tr><td bgcolor="#000099" align="left"><img src="img/rule_piccoloL.gif" width="200" height="2" alt="" /></td><td bgcolor="#000099" align="right"><img src="img/rule_piccoloR.gif" width="200" height="2" alt="" /></td></tr></table></td></tr>
</td></tr>
</table>