{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

{include file=avviso_notice.tpl}


<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="" align="center">
<tr><td class="Normal">
<!--&nbsp;<br /> <img src="tpl/black/facolta_30.gif" width="132" height="39" alt="{$fac_langTitleAlt|escape:"htmlall"}" />-->
<p align="center" class="Titolo">&nbsp;<br />{$fac_facTitle|escape:"htmlall"} - {$fac_facCodice}</p>
<p align="center" class="Normal"><a href="{$fac_facLink|escape:"htmlall"}" target="_blank">{$fac_facLink|escape:"htmlall"}</a><br />&nbsp;<br />
{if $common_langCanaleMyUniversiBO != ''}
<p align="center"><a href="{$common_canaleMyUniversiBO|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a></p>
{/if}

<p align="center">{$fac_langList|escape:"htmlall"}</p>

{foreach from=$fac_list item=temp_fac}
<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="" align="center"> 
			    <tr><td bgcolor="#000099">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
						<tr>
						 <td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
						 <td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
						 </tr>
						</table>
						</td></tr>
				<tr><td class="Titolo" align="center" bgcolor="#000050">{$temp_fac.name|escape:"html"|upper}</td></tr>
     			<tr bgcolor="#000099"><td><img src="tpl/black/invisible.gif" width="200" height="2" alt="" /></td></tr>
</table>

<table width="90%" border="0" cellspacing="0" cellpadding="1" summary="" align="center">


  {foreach from=$temp_fac.list item=temp_cdl}
<tr><td class="Menu" bgcolor="{cycle values="#000016,#000032"}">&nbsp;<img src="tpl/black/elle_begin.gif" width="10" height="12" alt="" />
<a href="{$temp_cdl.link}">{$temp_cdl.cod|escape:"htmlall"} - {$temp_cdl.name|escape:"htmlall"}</a> </td></tr>

  {/foreach} 

</table>
<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="" align="center"><tr><td bgcolor="#000099" align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td><td bgcolor="#000099" align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td></tr></table> 
<p>&nbsp;</p>
{/foreach}

{include file=News/latest_news.tpl}


</td></tr>
</table>



{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}