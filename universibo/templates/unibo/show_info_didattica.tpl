{include file=header_index.tpl}

<div class="titoloPagina">
<h2>{$infoDid_title|escape:"htmlall"|nl2br}</h2>
</div>
{if $infoDid_obiettiviInfo!=""}
	<h4>{$infoDid_langObiettiviInfo|escape:"htmlall"}</h4>
	<p>{$infoDid_obiettiviInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_obiettiviLink!=""}
	<h4>{$infoDid_langObiettiviLink|escape:"htmlall"}</h4>
	<p><a href="{$infoDid_obiettiviLink|escape:"htmlall"}">{$infoDid_obiettiviLink|escape:"htmlall"}</a> </p>
{/if}

{if $infoDid_programmaInfo!=""}
	<h4>{$infoDid_langProgrammaInfo|escape:"htmlall"}</h4>
	<p>{$infoDid_programmaInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_programmaLink!=""}
	<h4>{$infoDid_langProgrammaLink|escape:"htmlall"}</h4>
	<p><a href="{$infoDid_programmaLink|escape:"htmlall"}">{$infoDid_programmaLink|escape:"htmlall"}</a> </p>
{/if}
		
{if $infoDid_materialeInfo!=""}
	<h4>{$infoDid_langMaterialeInfo|escape:"htmlall"}</h4>
	<p>{$infoDid_materialeInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_materialeLink!=""}
	<h4>{$infoDid_langMaterialeLink|escape:"htmlall"}</h4>
	<p><a href="{$infoDid_materialeLink|escape:"htmlall"}">{$infoDid_materialeLink|escape:"htmlall"}</a> </p>
{/if}
		
{if $infoDid_modalitaInfo!=""}
	<h4>{$infoDid_langModalitaInfo|escape:"htmlall"}</h4>
	<p>{$infoDid_modalitaInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_modalitaLink!=""}
	<h4>{$infoDid_langModalitaLink|escape:"htmlall"}</h4>
	<p><a href="{$infoDid_modalitaLink|escape:"htmlall"}">{$infoDid_modalitaLink|escape:"htmlall"}</a> </p>
{/if}
		
{if $infoDid_appelliInfo!=""}
	<h4>{$infoDid_langAppelliInfo|escape:"htmlall"}</h4>
	<p>{$infoDid_appelliInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_appelliLink!=""}
	<h4>{$infoDid_langAppelliLink|escape:"htmlall"}</h4>
	<p><a href="{$infoDid_appelliLink|escape:"htmlall"}">{$infoDid_appelliLink|escape:"htmlall"}</a> </p>
{/if}
--
<p>{$infoDid_langAppelliUniwex|escape:"htmlall"}</p>

{include file=footer_index.tpl}