<h2>Files</h2>
{if $showFileTitoli_addFileFlag == "true"}&nbsp;
	<img src="tpl/unibo/file_new.gif" width="15" height="15" alt="" />
	<a href="{$showFileTitoli_addFileUri|escape:"htmlall"}">{$showFileTitoli_addFile|escape:"htmlall"|bbcode2html|nl2br}</a>
	&nbsp;&nbsp;&nbsp;
{/if}<br />
	{if $showFileTitoli_langFileAvailableFlag=="true"}
<div class="elenco">
		{foreach name=listacategorie from=$showFileTitoli_fileList item=temp_categoria}
			<p class="categoria">{$temp_categoria.desc|escape:"htmlall"}</p>
			{foreach name=listafile from=$temp_categoria.file item=temp_file}
				<p class="{cycle values="even,odd"}">&gt;&nbsp;<a href="{$temp_file.show_info_uri|escape:"htmlall"}">{$temp_file.titolo|escape:"htmlall"|nl2br|truncate}</a>&nbsp;{if $temp_file.nuova=="true"}&nbsp;&nbsp;<img src="tpl/unibo/icona_new.gif" width="21" height="9" alt="!NEW!" />{/if}
				{if $temp_file.modifica!=""}<a href="{$temp_file.modifica_link|escape:"htmlall"}"><img src="tpl/unibo/file_edt.gif" border="0" width="15" height="15" alt="modifica" /></a>{/if}  {if $temp_file.elimina!=""}<a href="{$temp_file.elimina_link|escape:"htmlall"}"><img src="tpl/unibo/file_del.gif" border="0" width="15" height="15" alt="elimina" /></a>{/if}  <a href="{$temp_file.download_uri|escape:"htmlall"}"><img src="tpl/unibo/file_download.gif" border="0" width="15" height="15" alt="scarica il file" /></a>&nbsp;<a href="{$temp_file.autore_link|escape:"htmlall"}">{$temp_file.autore|escape:"htmlall"}</a></p>
			{/foreach}
		{/foreach}
</div>
	{else}
		<p>{$showFileTitoli_langFileAvailable}</p>
	{/if}
