{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="98%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="Normal">
<p class="Titolo">{$home_langWelcome|escape:"htmlall"}</p>
<p>{$home_langWhatIs|escape:"htmlall"}</p>
<p>{$home_langMission|escape:"htmlall"}</p>

{include file=avviso_notice.tpl}

<p align="right"><a href="{$common_canaleMyUniversiBO|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a></p>
&nbsp;<br />
 <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
 <tr bgcolor="#000099"> 
 <td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
 <td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
 </tr>
 </table>
&nbsp;<br />


{include file=News/latest_news.tpl titleSize="big"}


</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}

