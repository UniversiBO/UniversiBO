{* parametri da passare: titolo, notizia, autore, autore_link, id_autore, data, modifica, modifica_link, elimina, elimina_link, nuova *}
<table width="100%" cellspacing="0" cellpadding="0" border="0" summary="">
<tr><td bgcolor="#999999" height="1"><img src="tpl/unibo/spacer.gif" width="1" height="1" alt=""></td></tr>
</table>
<table width="100%" cellspacing="0" cellpadding="3" border="0" summary="">
  <tr><td class="testoNormale" bgcolor="#cccccc" colspan="2"><b>:: {$titolo|escape:"htmlall"} ::</b> {if $nuova=="true"}&nbsp;&nbsp;novit&agrave;{/if}</td></tr>
  <tr><td class="testoNormale" colspan="2">{$notizia|escape:"htmlall"|ereg_replace:"[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]":"<a href=\"\\0\" target=\"_blank\">\\0</a>"|ereg_replace:"[^<>[:space:]]+[[:alnum:]/]@[^<>[:space:]]+[[:alnum:]/]":"<a href=\"mailto:\\0\" target=\"_blank\">\\0</a>"|nl2br}</td></tr>
  <tr><td class="testoNormale" >
{if $modifica!=""}&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#news" onclick="window.open('popup.php?pg=11&amp;id_news=766','','scrollbars=yes,resizable=yes,scrolling=yes,top=20,left=50')"><img src="tpl/black/news_edt.gif" width="15" height="15" border="0"  alt="" />Modifica</a>
{/if} | {if $elimina!=""}&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#news" onclick="window.open('popup.php?pg=12&amp;id_news=766','','scrollbars=yes,resizable=yes,scrolling=yes,top=20,left=50')"><img src="tpl/black/news_del.gif" width="15" height="15" border="0"  alt="" />Elimina</a>
{/if} </td>
<td class="testoNormale" align="right">{$data} | <a href="#news" onclick="window.open('popup.php?pg=666&amp;id_utente={$id_autore}','','width=500,height=500,scrollbars=yes,resizable=yes,scrolling=yes,top=50,left=100')">{$autore}</a> </td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0" summary="">
<tr><td bgcolor="#999999" height="1"><img src="tpl/unibo/spacer.gif" width="1" height="1" alt=""></td></tr>
</table>