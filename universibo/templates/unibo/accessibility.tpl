{include file=header_index.tpl}

<div class="titoloPagina">
<h2>{$showAccessibility_langTitleAlt|escape:"htmlall"}</h2>
{* Decommentare questa parte se si vuole che sia possibile aggiungere questa pagina al my universibo NB il comando corrispondente deve ereditare da canale command
{if $common_langCanaleMyUniversiBO != '' }
	<div class="comandi">
	{if $common_canaleMyUniversiBO == "remove"}<img src="tpl/unibo/esame_myuniversibo_del.gif" width="15" height="15" alt="" />&nbsp;{else}<img src="tpl/unibo/esame_myuniversibo_add.gif" width="15" height="15" alt="" />&nbsp;{/if}<a href="{$common_canaleMyUniversiBOUri|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a></div>
{/if}
*}
</div>


{include file=footer_index.tpl}
