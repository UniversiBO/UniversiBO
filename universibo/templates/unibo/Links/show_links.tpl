<div class="box"> {* blocchetto forum*}
<h3>Links</h3>
	<div class="contenuto">
{foreach name=linkpagina from=$showLinks_linksList item=temp_currLink}<p>
 {if $temp_currLink.tipo == "esterno"}
	<img src="tpl/unibo/freccia.gif" width="12" height="11" alt="->" />
{else}
 <img src="tpl/unibo/pallino1.gif" width="11" height="10" alt="" />
 {/if}&nbsp;<a title="Questo link apre una nuova pagina" target="_blank" href="{$temp_currLink.uri|escape:"htmlall"}">{$temp_currLink.label|escape:"htmlall"}</a></p>{/foreach}
{if $smarty.foreach.linkpagina.total == 0}<p>Nessuno contributo disponibile</p>{/if} 
{if $showLinks_linksPersonalizza == 'true'}
	<p><a href="{$showLinks_linksAdminUri}">{$showLinks_linksAdminLabel|escape:"htmlall"}</a></p>
{/if}
	</div>
</div>
