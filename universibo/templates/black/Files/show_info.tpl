<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr bgcolor="#000099" align="center">
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="tpl/black//rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  <td align="right"><img src="tpl/black//rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table>
</td></tr>
<tr><td bgcolor="#000050" class="Titolo">&nbsp;&nbsp;{$showFileInfo_titolo|escape:"htmlall"}</td></tr>
<tr bgcolor="#000099" align="center">
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  <td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table>
</td></tr>
<tr bgcolor="#000032">
<td> 
 <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" summary="">
 <tr><td class="Normal" colspan="2"><span class="NormalC">Inserito da:</span> <a href="{$showFileInfo_userLink|escape:"htmlall"}">{$showFileInfo_username|escape:"htmlall"}</a></td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">Inserito il:</span> {$showFileInfo_dataInserimento|escape:"htmlall"}</td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">Titolo:</span> {$showFileInfo_descrizione|escape:"htmlall"}</td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">Descrizione/abstract:</span> {$showFileInfo_descrizione|escape:"htmlall"}</td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">Parole chiave:</span> {foreach from=$showFileInfo_paroleChiave item=temp_parola}{$temp_parola|escape:"htmlall"} {/foreach}</td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">Categoria:</span> {$showFileInfo_categoria|escape:"htmlall"}</td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">Dimensione:</span> {$showFileInfo_dimensione|escape:"htmlall"} kB</td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">Scaricato:</span> {$showFileInfo_download|escape:"htmlall"} volte</td></tr>
 <tr><td class="NormalC" colspan="2">Formato file:</td></tr>
 <tr><td class="Normal"><img src="{$showFileInfo_icona|escape:"htmlall"}" width="32" height="32" alt="{$showFileInfo_tipo|escape:"htmlall"}" border="0" /></td><td class="Normal" valign="middle" width="100%">   {$showFileInfo_info|escape:"htmlall"|nl2br|bbcode2html}</td></tr>
 <tr><td class="Normal" colspan="2"<span class="NormalC">Hash MD5:</span> {$showFileInfo_hash|escape:"htmlall"}</td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">Presente in:</span><br />{foreach from=$showFileInfo_canali item=temp_canale}&nbsp;&nbsp;<a href="{$temp_canale.uri|escape:"htmlall"}">{$temp_canale.titolo|escape:"htmlall"}</a><br />{/foreach}</td></tr>
 <tr><td class="Normal" colspan="2"><span class="NormalC">&nbsp;Download:</span>&nbsp;&nbsp;<a href="{$showFileInfo_downloadUri|escape:"htmlall"}"><img src="tpl/black/file_download_32.gif" width="32" height="32" alt="scarica" border="0" align="top" /></a></td></tr>
 </table>
</td></tr>
<tr bgcolor="#000099" align="center">
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>

  <td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table>
</td></tr>
</table>
