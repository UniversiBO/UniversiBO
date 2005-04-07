
<div class="contenuto">
<table width="98%" border="0" cellspacing="0" cellpadding="2" align="center" summary="">
	<tr>
	 <td>Indirizzo</td>
	 <td>Descrizione</td>
	 <td>Autore</td>
	 <td>Modifica/Elimina</td>
	</tr>
{section loop=$showLinksExtended_linksList name=temp_currLink}
<tr>
 <td><a title="Questo link apre una nuova pagina" target="_blank" href="{$showLinksExtended_linksList[temp_currLink].uri|escape:"htmlall"}">{$showLinksExtended_linksList[temp_currLink].label|escape:"htmlall"}</a></td>
 <td>{$showLinksExtended_linksList[temp_currLink].description|escape:"htmlall"}</td>
 <td><a title="Questo link apre una nuova pagina" target="_blank" href="{$showLinksExtended_linksList[temp_currLink].userlink|escape:"htmlall"}">{$showLinksExtended_linksList[temp_currLink].user|escape:"htmlall"}</a></td>
 <td>{if $showLinksExtended_linksList[temp_currLink].modifica!=""}<a href="{$showLinksExtended_linksList[temp_currLink].modifica_link_uri|escape:"htmlall"}"><img src="tpl/unibo/news_edt.gif" border="0" width="15" height="15" alt="modifica" hspace="1"/></a>{/if}
	 {if $showLinksExtended_linksList[temp_currLink].elimina!=""}<a href="{$showLinksExtended_linksList[temp_currLink].elimina_link_uri|escape:"htmlall"}"><img src="tpl/unibo/file_del.gif" border="0" width="15" height="15" alt="elimina" hspace="1"/></a>{/if}</td>
 </tr>
 {/section}
 </table>
</div>
