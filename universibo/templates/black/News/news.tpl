{* parametri da passare: titolo, notizia, autore, autore_link, id_autore, data, modifica, modifica_link, elimina, elimina_link *}

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
<td class="Titolo">{$titolo|escape:"htmlall"}</td>
</tr>
<tr bgcolor="#000099" align="center"> 
<td><img src="tpl/black/invisible.gif" height="2" width="1" alt="" /></td>
</tr>
<tr bgcolor="#000032"> 
<td>
  <table border="0" width="100%" cellspacing="0" cellpadding="4" summary="">
  <tr> 
  <td class="News">{$notizia|escape:"htmlall"|ereg_replace:"[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]":"<a href=\"\\0\" target=\"_blank\">\\0</a>"|ereg_replace:"[^<>[:space:]]+[[:alnum:]/]@[^<>[:space:]]+[[:alnum:]/]":"<a href=\"mailto:\\0\" target=\"_blank\">\\0</a>"|nl2br}</td></tr>
  <tr> 
  <td class="News" align="right">{$data}<br />
  {* come interpreto la riga sotto???? *}
	<a href="#news" onclick="window.open('popup.php?pg=666&amp;id_utente={$id_autore}','','width=500,height=500,scrollbars=yes,resizable=yes,scrolling=yes,top=50,left=100')">{$autore}</a></td>
  </tr>
  </table>
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
  <td class="Piccolo" align="left">
{if $modifica!=""}&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#news" onclick="window.open('popup.php?pg=11&amp;id_news=766','','scrollbars=yes,resizable=yes,scrolling=yes,top=20,left=50')"><img src="tpl/black/news_edt.gif" width="15" height="15" border="0"  alt="" />Modifica</a>
{/if}
{if $elimina!=""}&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#news" onclick="window.open('popup.php?pg=12&amp;id_news=766','','scrollbars=yes,resizable=yes,scrolling=yes,top=20,left=50')"><img src="tpl/black/news_del.gif" width="15" height="15" border="0"  alt="" />Elimina</a>
{/if}	
	</td>
  <td class="Piccolo" align="right">
&nbsp;	
	</td>
  </tr>
  </table>
</td>
</tr>
</table>