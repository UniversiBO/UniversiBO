{* ?fare controllo presenza notizia? *}

{* parametri da passare: titolo, notizia, autore, id_user, data*}

&nbsp;


<tr bgcolor="#000099"> 
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="img/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
	<td align="right"><img src="img/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table>
</td></tr>
<tr bgcolor="#000050"> 
<td class="Titolo">{$titolo}</td>
</tr>
<tr bgcolor="#000099" align="center"> 
<td><img src="img/invisible.gif" height="2" width="1" alt="" /></td>
</tr>
<tr bgcolor="#000032"> 
<td>
  <table border="0" width="100%" cellspacing="0" cellpadding="4" summary="">
  <tr> 
  <td class="News">{$notizia}</td></tr>
  <tr> 
  <td class="News" align="right">{$data}<br />
  {* come interpreto la riga sotto???? *}
	<a href="#news" onclick="window.open('popup.php?pg=666&amp;id_user={$id_user}','','width=500,height=500,scrollbars=yes,resizable=yes,scrolling=yes,top=50,left=100')">{$autore}</a></td>
  </tr>
  </table>
</td>
</tr>

&nbsp;