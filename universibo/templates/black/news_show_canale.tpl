{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="95%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td>
{include file=avviso_notice.tpl}
</td></tr>
<tr align="center" ><td><img src="tpl/black/news_30.gif" width="100" height="39" alt="News" /><br />
</td></tr>
<tr><td class="Normal" align="right">
{section name=page loop=$NewsShowCanale_numPagine}
	{if $smarty.section.page.first} Pagine:&nbsp;{$smarty.section.page.iteration}
	{else}
	&nbsp;|&nbsp;{$smarty.section.page.iteration}
	{/if}
{/section}
</td></tr>
<tr><td>
{include file=News/show_news.tpl}
</td></tr>
</table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}