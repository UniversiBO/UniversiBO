<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" summary="">
<tr align="center" ><td>
{if $titleSize|default:"small" == "big"}
<img src="tpl/black/files_30.gif" width="100" height="39" alt="News" /><br />
{else}
<img src="tpl/black/files_18.gif" width="64" height="22" alt="News" /><br />
{/if}
</td></tr>
<tr><td class="piccolo">
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="piccolo">
&nbsp;{if $showFileTitoli_addFileFlag == "true"}<img src="tpl/black/file_new.gif" width="15" height="15" alt="" />
<a href="{$showFileTitoli_addFileUri|escape:"htmlall"}">{$showFileTitoli_addFile|escape:"htmlall"|bbcode2html|nl2br}</a>
&nbsp;&nbsp;&nbsp;{/if}
</td>
</tr></table>
<tr>
<td class="Normal" align="center">
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" summary="">
<tr>
{if $showFileTitoli_langFileAvailableFlag=="true"}
<td class="Normal" align="center" bgcolor="#000099">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
	<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
	</table>
</td></tr>

{foreach name=listafile from=$showFileTitoli_fileList item=temp_file}
{*&nbsp;
	{if $smarty.foreach.listafile.iteration is odd}
{include file=Files/file_titolo.tpl titolo=$temp_file.titolo autore=$temp_file.autore autore_link=$temp_file.autore_link id_autore=$temp_file.id_autore data=$temp_file.data modifica=$temp_file.modifica modifica_link=$temp_file.modifica_link elimina=$temp_file.elimina elimina_link=$temp_file.elimina_link nuova=$temp_file.nuova dimensione=$temp_file.dimensione download_uri=$temp_file.download_uri background="#000032" show_info_uri=$temp_file.show_info_uri }
	{else}
{include file=Files/file_titolo.tpl titolo=$temp_file.titolo autore=$temp_file.autore autore_link=$temp_file.autore_link id_autore=$temp_file.id_autore data=$temp_file.data modifica=$temp_file.modifica modifica_link=$temp_file.modifica_link elimina=$temp_file.elimina elimina_link=$temp_file.elimina_link nuova=$temp_file.nuova dimensione=$temp_file.dimensione download_uri=$temp_file.download_uri background='#000016' show_info_uri=$temp_file.show_info_uri}
	{/if}*}
	
<tr bgcolor="{cycle values="#000016,#000032"}"> 
<td>&nbsp;::&nbsp;<a href="{$temp_file.show_info_uri|escape:"htmlall"}">{$temp_file.titolo|escape:"htmlall"|nl2br}</a>&nbsp;::{if $temp_file.nuova=="true"}&nbsp;&nbsp;<img src="tpl/black/icona_new.gif" width="21" height="9" alt="!NEW!" />{/if}</td>
<td class="News" align="right">{$temp_file.data|escape:"htmlall"|nl2br}<br />
<a href="{$temp_file.autore_link|escape:"htmlall"}">{$temp_file.autore|escape:"htmlall"}</a></td>
<td>{$temp_file.dimensione|escape:"htmlall"}</td>
<td>
{if $temp_file.download_uri != ""}
<a href="{$temp_file.download_uri|escape:"htmlall"}"><img src="tpl/black/file_copy.gif" width="15" height="9" alt="scarica il file" /></a>
{else}&nbsp;
{/if}
</td>
<td> 
{if $temp_file.modifica!=""}&nbsp;&nbsp;&nbsp;<img src="tpl/black/file_edt.gif" width="15" height="15" alt="modifica" />
<a href="{$temp_file.modifica_link|escape:"htmlall"}">{$temp_file.modifica|escape:"htmlall"|nl2br}</a>
{/if}
{if $temp_file.elimina!=""}&nbsp;&nbsp;&nbsp;<img src="tpl/black/file_del.gif" width="15" height="15" alt="elimina" />
<a href="{$temp_file.elimina_link|escape:"htmlall"}">{$temp_file.elimina|escape:"htmlall"|bbcode2html|nl2br}</a>
{/if}&nbsp;
</td>
</tr>

{/foreach}

<tr bgcolor="#000099"> 
<td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  <tr>
	<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
	<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table>
</td></tr>
{else}
<td class="Normal" align="center">
{$showFileTitoli_langFileAvailable}
{/if}
</td>
</tr></table>
</td>
</tr>
</table> 
