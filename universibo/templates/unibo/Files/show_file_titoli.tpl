<h2>Files</h2>
{if $showFileTitoli_addFileFlag == "true"}
<div class="comandi">
	<img src="tpl/unibo/file_new.gif" width="15" height="15" alt="" />
	<a href="{$showFileTitoli_addFileUri|escape:"htmlall"}">{$showFileTitoli_addFile|escape:"htmlall"|bbcode2html|nl2br}</a>
</div>
{/if}<br />
	{if $showFileTitoli_langFileAvailableFlag=="true"}
<div>
<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" summary="">
		{foreach name=listacategorie from=$showFileTitoli_fileList item=temp_categoria}
			{*<p class="categoria">{$temp_categoria.desc|escape:"htmlall"}</p>*}
			<tr><th align="left" colspan="9">
			{$temp_categoria.desc|escape:"htmlall"}
			</th></tr>
			{foreach name=listafile from=$temp_categoria.file item=temp_file}
				{*<p class="{cycle values="even,odd"}">&gt;&nbsp;<a href="{$temp_file.show_info_uri|escape:"htmlall"}">{$temp_file.titolo|escape:"htmlall"|nl2br|truncate}</a>&nbsp;{if $temp_file.nuova=="true"}&nbsp;&nbsp;<img src="tpl/unibo/icona_new.gif" width="21" height="9" alt="!NEW!" />{/if}
				{if $temp_file.modifica!=""}<a href="{$temp_file.modifica_link|escape:"htmlall"}"><img src="tpl/unibo/file_edt.gif" border="0" width="15" height="15" alt="modifica" /></a>{/if}  {if $temp_file.elimina!=""}<a href="{$temp_file.elimina_link|escape:"htmlall"}"><img src="tpl/unibo/file_del.gif" border="0" width="15" height="15" alt="elimina" /></a>{/if}  <a href="{$temp_file.download_uri|escape:"htmlall"}"><img src="tpl/unibo/file_download.gif" border="0" width="15" height="15" alt="scarica il file" /></a>&nbsp;<a href="{$temp_file.autore_link|escape:"htmlall"}">{$temp_file.autore|escape:"htmlall"}</a></p>
				*}
				<tr valign="center" class="{cycle values="even,odd"}"> 
				<td align="left"><img src="" alt="" />&nbsp;</td>
				<td width="30">{$temp_file.data|escape:"htmlall"}&nbsp;&nbsp;</td>
				<td align="left"><a href="{$temp_file.show_info_uri|escape:"htmlall"}">{$temp_file.titolo|escape:"htmlall"|nl2br|truncate}</a>&nbsp;{if $temp_file.nuova=="true"}&nbsp;&nbsp;<img src="tpl/black/icona_new.gif" width="21" height="9" alt="!NEW!" />{/if}</td>
				<td &nbsp;&nbsp;<a href="{$temp_file.autore_link|escape:"htmlall"}">{$temp_file.autore|escape:"htmlall"}</a></td>
				<td align="right">&nbsp;&nbsp;{$temp_file.dimensione|escape:"htmlall"}&nbsp;kB&nbsp;&nbsp;</td>
				<td valign="center" align="right">{if $temp_file.modifica!=""}<a href="{$temp_file.modifica_link|escape:"htmlall"}"><img src="tpl/unibo/news_edt.gif" border="0" width="15" height="15" alt="modifica" hspace="1"/></a>{/if}</td>
				<td valign="center" align="right">{if $temp_file.elimina!=""}<a href="{$temp_file.elimina_link|escape:"htmlall"}"><img src="tpl/unibo/file_del.gif" border="0" width="15" height="15" alt="elimina" hspace="1"/></a>{/if}</td>
				<td valign="center" align="right"><a href="{$temp_file.download_uri|escape:"htmlall"}"><img src="tpl/unibo/file_download.gif" border="0" width="15" height="15" alt="scarica il file" vspace="2" hspace="1"/></a></td>
				</tr>
			{/foreach}
		{/foreach}
</table>
</div>
	{else}
		<p>{$showFileTitoli_langFileAvailable}</p>
	{/if}
