{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

{include file=avviso_notice.tpl}

<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="Normal" align="center">
	&nbsp;<br />
	<img src="tpl/black/collabora_30.gif" width="167" height="39" alt="{$contributes_langTitleAlt}" /><br />&nbsp;
</td></tr>
<tr>
    <td class="Normal" align="left">
    {$contributes_langIntro}
    
    <div align="center" class="Titolo">
    {$contributes_langTitle}
    </div>
    
    {$contributes_langHowToContribute}
    
    </td>
</tr>
</table>



{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}