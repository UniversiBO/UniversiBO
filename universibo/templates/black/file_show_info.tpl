{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}
<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td align="center"><p class="Titolo">&nbsp;<br />Informazioni file<br />&nbsp;</p></td></tr>
<tr><td align="center" class="Normal">

<tr bgcolor="#000099" align="center">
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="tpl/black//rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  <td align="right"><img src="tpl/black//rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table>
</td></tr>
<tr><td bgcolor="#000050" class="Titolo">&nbsp;&nbsp;{$fileShowInfo_titolo|escape:"htmlall"}</td></tr>
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
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
 <tr> 
 <td width="190" class="Normal">
  &nbsp;<br />
  <font class="NormalC">&nbsp;Inserito il:</font>&nbsp;&nbsp;{$fileShowInfo_dataInserimento|escape:"htmlall"}<br /><br />
  <font class="NormalC">&nbsp;Inserito da:</font>&nbsp;&nbsp;<a href="{$fileShowInfo_userLink|escape:"htmlall"}">{$fileShowInfo_username|escape:"htmlall"}</a><br /><br />
  <font class="NormalC">&nbsp;Descrizione/abstract:</font>&nbsp;&nbsp;{$fileShowInfo_descrizione|escape:"htmlall"}<br /><br />
  <font class="NormalC">&nbsp;Parole chiave:</font>&nbsp;&nbsp; __, ___<br /><br />
  <font class="NormalC">&nbsp;Categoria:</font>&nbsp;&nbsp;{$fileShowInfo_categoria|escape:"htmlall"}<br /><br />
  <font class="NormalC">&nbsp;Dimensione:</font>&nbsp;&nbsp;{$fileShowInfo_dimensione|escape:"htmlall"} kB<br /><br />
  <font class="NormalC">&nbsp;Scaricato:</font>&nbsp;&nbsp;{$fileShowInfo_download|escape:"htmlall"} volte<br /><br />
  <font class="NormalC">&nbsp;Formato file:</font><p>&nbsp;&nbsp;<img src="{$fileShowInfo_icona|escape:"htmlall"}" width="32" height="32" alt="{$fileShowInfo_tipo|escape:"htmlall"}" border="0" vspace="2"/></a> {$fileShowInfo_info|escape:"htmlall"|nl2br|bbcodes2html}<br /></p>
  <font class="NormalC">&nbsp;Hash MD5:</font><br />&nbsp;&nbsp;{$fileShowInfo_hash|escape:"htmlall"}<br /><br />
  <font class="NormalC">&nbsp;Presente in:</font><br />{foreach from=$fileShowInfo_canali item=temp_canale}&nbsp;&nbsp;<a href="{$temp_canale.uri|escape:"htmlall"}">{$temp_canale.titolo|escape:"htmlall"}</a><br />{/foreach}
  <br />
  <font class="NormalC">&nbsp;Download:</font><br />&nbsp;&nbsp;<a href="{$fileShowInfo_Downloaduri|escape:"htmlall"}"><img src="icona_download" width="32" height="32" alt="scarica" border="0" /></a><br /><br />
 </td>
 </tr></table>
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

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}