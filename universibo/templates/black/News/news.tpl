{* parametri da passare: titolo, notizia, autore, autore_link, id_autore, data, modifica, modifica_link, elimina, elimina_link, nuova, scadenza *}
{* modifica, elimina sono da considerare come boolean, scadenza deve contenere o la stringa "Scade il data" o "scaduta il data"
   tutti e tre i parametri servono per il controllo dei diritti che avviene a livello applicativo *}

<table cellspacing="0" cellpadding="0" width="100%" summary="">
<tr bgcolor="#000099"> 
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
	<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table>
</td></tr>
<tr bgcolor="#000050"> 
<td class="Titolo">&nbsp;::&nbsp;{$titolo|escape:"htmlall"|nl2br}&nbsp;::{if $nuova=="true"}&nbsp;&nbsp;<img src="tpl/black/icona_new.gif" width="21" height="9" alt="!NEW!" />{/if}</td>
</tr>
<tr bgcolor="#000099" align="center"> 
<td><img src="tpl/black/invisible.gif" height="2" width="1" alt="" /></td>
</tr>
<tr bgcolor="#000032"> 
<td>
  <table border="0" width="100%" cellspacing="0" cellpadding="4" summary="">
  <tr> 
  <td class="News">{$notizia|escape:"htmlall"|bbcode2html|ereg_replace:"[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]":"<a href=\"\\0\" target=\"_blank\">\\0</a>"|ereg_replace:"[^<>[:space:]]+[[:alnum:]/]@[^<>[:space:]]+[[:alnum:]/]":"<a href=\"mailto:\\0\" target=\"_blank\">\\0</a>"|nl2br}</td></tr>
  <tr> 
  
{*<td class="News" valign="bottom">  
<table border="0" width="100%" cellspacing="0" cellpadding="0" summary="">
<tr><td class="Piccolo" valign="bottom">  
  {if $modifica!=""}&nbsp;&nbsp;&nbsp;<img src="tpl/black/news_edt.gif" width="15" height="15" alt="modifica" />
<script type="text/javascript" language="JavaScript">
document.write("<a href=\"javascript:universiboPopup('index.php?do={$modifica_link|escape:"htmlall"|nl2br}&amp;pageType=popup');\">{$modifica|escape:"htmlall"|nl2br}</a>");
</script>
<noscript><a href="index.php?do={$modifica_link|escape:"htmlall"}">{$modifica|escape:"htmlall"|nl2br}</a></noscript>
{/if}
{if $elimina!=""}&nbsp;&nbsp;&nbsp;<img src="tpl/black/news_del.gif" width="15" height="15" alt="elimina" />
<script type="text/javascript" language="JavaScript">
<!--
document.write("<a href=\"javascript:universiboPopup('index.php?do={$elimina_link|escape:"htmlall"|nl2br}&amp;pageType=popup');\">{$elimina|escape:"htmlall"|bbcode2html|nl2br}<\/a>");
-->
</script>
<noscript><a href="index.php?do={$elimina_link|escape:"htmlall"}" target="_popup">{$elimina|escape:"htmlall"|bbcode2html|nl2br}</a></noscript>
{/if}&nbsp;
</td>
  *}
  
  <td class="News" align="right">{$data|escape:"htmlall"|nl2br}<br />
{*<script type="text/javascript" language="JavaScript">
<!--
document.write("<a href=\"javascript:universiboPopup('index.php?do=ShowUser&amp;id_utente={$id_autore|escape:"htmlall"|nl2br}&amp;pageType=popup');\">{$autore|escape:"htmlall"}<\/a>");
-->
</script>
<noscript><a href="index.php?do=ShowUser&amp;id_utente={$id_autore|escape:"htmlall"}" target="_popup">{$autore|escape:"htmlall"}</a></noscript>*}
<a href="index.php?do=ShowUser&amp;id_utente={$id_autore|escape:"htmlall"}" target="_popup">{$autore|escape:"htmlall"}</a>
  {*</td></tr></table>*}
  </td></tr></table>
</td>
</tr>

<tr bgcolor="#000099"> 
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
	<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table>
</td></tr>

<tr> 
<td> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr> 

<td class="Piccolo" valign="bottom">  
  {if $modifica!=""}&nbsp;&nbsp;&nbsp;<img src="tpl/black/news_edt.gif" width="15" height="15" alt="modifica" />
{*<script type="text/javascript" language="JavaScript">
document.write("<a href=\"javascript:universiboPopup('index.php?do={$modifica_link|escape:"htmlall"|nl2br}&amp;pageType=popup');\">{$modifica|escape:"htmlall"|nl2br}</a>");
</script>
<noscript><a href="index.php?do={$modifica_link|escape:"htmlall"}">{$modifica|escape:"htmlall"|nl2br}</a></noscript>*}
<a href="index.php?do={$modifica_link|escape:"htmlall"}">{$modifica|escape:"htmlall"|nl2br}</a>
{/if}
{if $elimina!=""}&nbsp;&nbsp;&nbsp;<img src="tpl/black/news_del.gif" width="15" height="15" alt="elimina" />
{*<script type="text/javascript" language="JavaScript">
<!--
document.write("<a href=\"javascript:universiboPopup('index.php?do={$elimina_link|escape:"htmlall"|nl2br}&amp;pageType=popup');\">{$elimina|escape:"htmlall"|bbcode2html|nl2br}<\/a>");
-->
</script>
<noscript><a href="index.php?do={$elimina_link|escape:"htmlall"}">{$elimina|escape:"htmlall"|bbcode2html|nl2br}</a></noscript>*}
<a href="index.php?do={$elimina_link|escape:"htmlall"}">{$elimina|escape:"htmlall"|bbcode2html|nl2br}</a>
{/if}&nbsp;
</td>

<td class="Piccolo" align="left">
{if $scadenza!=""}
{$scadenza|escape:"htmlall"|bbcode2html|nl2br}
{/if}
  </td>
  <td class="Piccolo" align="right">&nbsp;</td>
  </tr>
  </table>
</td>
</tr>
</table>