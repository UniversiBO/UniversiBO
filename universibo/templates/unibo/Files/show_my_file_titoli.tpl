{if $showMyFileTitoli_langFileAvailableFlag=="true"}
{foreach name=showmyfiletitoli from=$showMyFileTitoli_fileList item=temp_file}
	<span>
	<div class="elencoFile">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
			<tr><th colspan="8">{$temp_file.desc|escape:"htmlall"}</th><tr>
				<td>&nbsp;&nbsp;{$temp_file.data|escape:"htmlall"}&nbsp;&nbsp;</td>
				<td><a href="{$temp_file.show_info_uri|escape:"htmlall"}">{$temp_file.titolo|escape:"htmlall"|nl2br|truncate}</a>&nbsp;{if $temp_file.nuova=="true"}&nbsp;&nbsp;<img src="tpl/unibo/icona_new.gif" width="21" height="9" alt="!NEW!" />{/if}</td>
				<td><a href="{$temp_file.autore_link|escape:"htmlall"}">{$temp_file.autore|escape:"htmlall"}</a></td>
				<td>&nbsp;&nbsp;{$temp_file.dimensione|escape:"htmlall"}&nbsp;kB&nbsp;&nbsp;</td>
				<td>{if $temp_file.modifica!=""}<a href="{$temp_file.modifica_link|escape:"htmlall"}"><img src="tpl/unibo/news_edt.gif" border="0" width="15" height="15" alt="modifica" hspace="1"/></a>{/if}</td>
				<td>{if $temp_file.elimina!=""}<a href="{$temp_file.elimina_link|escape:"htmlall"}"><img src="tpl/unibo/file_del.gif" border="0" width="15" height="15" alt="elimina" hspace="1"/></a>{/if}</td>
				<td><a href="{$temp_file.download_uri|escape:"htmlall"}"><img src="tpl/unibo/file_download.gif" border="0" width="15" height="15" alt="scarica il file" vspace="2" hspace="1"/></a>&nbsp;</td>
		</table>
	</div>
	{foreach from=$temp_file.canali item=temp_canale}
		<p class="comandi"><a href={$temp_canale.link|escape:"htmlall"}>{$temp_canale.titolo|escape:"htmlall"} </a><p>
	{/foreach}
	</span>
&nbsp;<br />
{/foreach}
{else}
<p>{$showMyFileTitoli_langFileAvailable|escape:htmlall}</p>
{/if}
