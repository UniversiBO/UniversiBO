<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" summary="">
<tr align="center" ><td><a name="news"></a><img src="tpl/black/news_30.gif" width="100" height="39" alt="News" /><br />
</td>
</tr>
<tr>
<td>
{foreach from=$showNewsLatest_newsList item=temp_news}
&nbsp;
{include file=News/news.tpl titolo=$temp_news.titolo  notizia=$temp_news.notizia autore=$temp_news.autore autore_link=$temp_news.autore_link id_autore=$temp_news.id_autore data=$temp_news.data modifica=$temp_news.modifica modifica_link=$temp_news.modifica_link elimina=$temp_news.elimina elimina_link=$temp_news.elimina_link"  }
{/foreach}
</td>
</tr>
</table> 
