{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="Normal" align="center">
&nbsp;<br />
<p align="center" class="Titolo">{$fac_facTitle|escape:"html"}</p>

<p>{$fac_langList|escape:"html"}</p>

{foreach from=$fac_list item=fac}
<table width="90%" border="0" cellspacing="0" cellpadding="0" summary=""> 
			    <tr><td bgcolor="#000099">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
						<tr>
						 <td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
						 <td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
						 </tr>
						</table>
						</td></tr>
				<tr><td class="Titolo" align="center" bgcolor="#000050"><p>{$fac.name|escape:"html"|lower}</p></td></tr>
     			<tr bgcolor="#000099"><td><img src="tpl/black/invisible.gif" width="200" height="2" alt="" /></td></tr>
</table>

<table width="90%" border="0" cellspacing="0" cellpadding="1" summary="">


  {foreach from=$fac.list item=cdl}
<tr><td class="Normal" bgcolor="#000016">&nbsp;<img src="tpl/black/elle_begin.gif" width="10" height="12" alt="" />
<a href="{$cdl.link}">{$cdl.cod|escape:"html"}	{$cdl.name|escape:"html"}</a> </td></tr>
  {/foreach} 

</table>
&nbsp;<br />

{/foreach}



</td></tr>
</table>



{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}