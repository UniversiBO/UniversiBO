<table width="100%" align="left" border="0" summary="">
<tr> 
<td class="titoloHome">News</td>
<td align="left">&nbsp;{if $showNewsLatest_addNewsFlag == "true"}<a class="menu" href="{$showNewsLatest_addNewsUri}">{$showNewsLatest_addNews}</a>{/if}</td>
<td align="right" class="testoNormale">&nbsp;{if $showNewsLatest_langNewsShowOthers != ""}<a href="{$showNewsLatest_langNewsShowOthersUri}">{$showNewsLatest_langNewsShowOthers}</a>{/if}</td>
</tr>
<tr> 
<td colspan="3" class="testoNormale">

{if $showNewsLatest_langNewsAvailableFlag=="true"}
{foreach from=$showNewsLatest_newsList item=temp_news}
&nbsp;<br />
&nbsp;<br />
{include file=News/news.tpl titolo=$temp_news.titolo notizia=$temp_news.notizia autore=$temp_news.autore autore_link=$temp_news.autore_link id_autore=$temp_news.id_autore data=$temp_news.data modifica=$temp_news.modifica modifica_link=$temp_news.modifica_link elimina=$temp_news.elimina elimina_link=$temp_news.elimina_link nuova=$temp_news.nuova  }
{/foreach}
{else}
{$showNewsLatest_langNewsAvailable}
{/if}

</td>
</tr>
</table>