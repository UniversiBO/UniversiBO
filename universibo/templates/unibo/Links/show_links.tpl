<div class="box"> {* blocchetto forum*}
<h3>Links</h3>
	<div class="contenuto">
{section loop=$showLinks_linksList name=temp_currLink}<p><img src="tpl/unibo/freccia.gif" width="12" height="11" alt="->" />&nbsp;<a title="Questo link apre una nuova pagina" target="_blank" href="{$showLinks_linksList[temp_currLink].uri|escape:"htmlall"}">{$showLinks_linksList[temp_currLink].label|escape:"htmlall"}</a></p>{/section}
	</div>
</div>
