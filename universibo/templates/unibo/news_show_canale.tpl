{include file=header_index.tpl}

{include file=avviso_notice.tpl}

<div class="titoloPagina">
<h2>News</h2>
</div>
{if $NewsShowCanale_addNewsFlag == "true"}<p><a href="{$NewsShowCanale_addNewsUri|escape:"htmlall"}"><img src="tpl/unibo/news_new.gif" width="15" height="15" alt="" />
	{$NewsShowCanale_addNews|escape:"htmlall"|bbcode2html|nl2br}</a></p>
{/if}
{if $NewsShowCanale_numPagineFlag == "true"}
{foreach name=newspage item=news_curr_page key=news_curr_key from=$NewsShowCanale_numPagine}
	{if $smarty.foreach.newspage.first}
		<p>Pagine:&nbsp;</p>
		{if $news_curr_page.current == 'false'}<p><a href="{$news_curr_page.URI}">{$news_curr_key}</a></p>
		{else}{$news_curr_key}
		{/if}
	{else}
		{if $news_curr_page.current == 'false'}<p>&nbsp;|&nbsp;<a href="{$news_curr_page.URI}">{$news_curr_key}</a></p>
		{else}&nbsp;|&nbsp;{$news_curr_key}
		{/if}
	{/if}
{/foreach}
{/if}

{include file=News/show_news.tpl}
<p><a href="{$common_canaleURI|escape:"htmlall"}">Torna&nbsp;a&nbsp;{$common_langCanaleNome}</a></p>
<hr />
{include file=Help/topic.tpl showTopic_topic=$showTopic_topic idsu=$showTopic_topic.reference}

{include file=footer_index.tpl}