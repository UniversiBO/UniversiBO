<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" summary="">
<tr align="center" ><td><a name="news"></a>
<img src="tpl/black/news_30.gif" width="100" height="39" alt="News" /><br />
</td>
</tr>
<tr><td class="piccolo">
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="piccolo">
&nbsp;{if $showNewsLatest_langNewsShowOthers != ""}<img src="tpl/black/news_all.gif" width="15" height="15" alt="" />
<script type="text/javascript" language="JavaScript"><!--
document.write("<a href=\"javascript:universiboPopup('{$showNewsLatest_langNewsShowOthersUri|escape:"htmlall"|nl2br}&amp;pageType=popup');\">{$showNewsLatest_langNewsShowOthers|escape:"htmlall"|bbcode2html|nl2br}<\/a>");
--></script>
<noscript><a href="index.php?do={$showNewsLatest_langNewsShowOthersUri|escape:"htmlall"}" target="_popup">{$showNewsLatest_langNewsShowOthers|escape:"htmlall"|bbcode2html|nl2br}</a></noscript>
&nbsp;&nbsp;&nbsp;{/if}
</td><td class="piccolo" align="right">
&nbsp;{if $showNewsLatest_addNewsFlag == "true"}<img src="tpl/black/news_new.gif" width="15" height="15" alt="" />
<script type="text/javascript" language="JavaScript"><!--
document.write("<a href=\"javascript:universiboPopup('{$showNewsLatest_addNewsUri|escape:"htmlall"|nl2br}&amp;pageType=popup');\">{$showNewsLatest_addNews|escape:"htmlall"|bbcode2html|nl2br}<\/a>");
--></script>
<noscript><a href="index.php?do={$showNewsLatest_addNewsUri|escape:"htmlall"}" target="_popup">{$showNewsLatest_addNews|escape:"htmlall"|bbcode2html|nl2br}</a></noscript>
{/if}
</td>
</tr></table>
<tr>
<td class="Normal" align="center">
{if $showNewsLatest_langNewsAvailableFlag=="true"}
{foreach from=$showNewsLatest_newsList item=temp_news}
&nbsp;
{include file=News/news.tpl titolo=$temp_news.titolo notizia=$temp_news.notizia autore=$temp_news.autore autore_link=$temp_news.autore_link id_autore=$temp_news.id_autore data=$temp_news.data modifica=$temp_news.modifica modifica_link=$temp_news.modifica_link elimina=$temp_news.elimina elimina_link=$temp_news.elimina_link nuova=$temp_news.nuova scadenza=$temp_news.scadenza }
{/foreach}
{else}
{$showNewsLatest_langNewsAvailable}
{/if}
</td>
</tr>
</table> 
