{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

{include file=avviso_notice.tpl}
<table width="95%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td align="center"><p class="Titolo">&nbsp;<br /><img src="tpl/black/my_universibo_18s.gif" alt="My UniversiBO" height="22" width="140" /><br />&nbsp;</p></td></tr>
<tr><td>{include file=News/show_my_news.tpl}</td></tr>
</table>
{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}