{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="95%" border="0" cellspacing="0" cellpadding="0" summary="" align="center">
<tr><td class="Normal"><p align="center" class="Titolo">{$infoDid_title|escape:"htmlall"|nl2br}</p>
{if $infoDid_obiettiviInfo!=""}
<p class="NormalC">{$infoDid_langObiettiviInfo|escape:"htmlall"}</p>
<p class="Normal">{$infoDid_obiettiviInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_obiettiviLink!=""}
<p class="NormalC">{$infoDid_langObiettiviLink|escape:"htmlall"}</p>
<p class="Normal"><a href="{$infoDid_obiettiviLink|escape:"htmlall"}">{$infoDid_obiettiviLink|escape:"htmlall"}</a> </p>
{/if}

{if $infoDid_programmaInfo!=""}
<p class="NormalC">{$infoDid_langProgrammaInfo|escape:"htmlall"}</p>
<p class="Normal">{$infoDid_programmaInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_programmaLink!=""}
<p class="NormalC">{$infoDid_langProgrammaLink|escape:"htmlall"}</p>
<p class="Normal"><a href="{$infoDid_programmaLink|escape:"htmlall"}">{$infoDid_programmaLink|escape:"htmlall"}</a> </p>
{/if}
		
{if $infoDid_materialeInfo!=""}
<p class="NormalC">{$infoDid_langMaterialeInfo|escape:"htmlall"}</p>
<p class="Normal">{$infoDid_materialeInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_materialeLink!=""}
<p class="NormalC">{$infoDid_langMaterialeLink|escape:"htmlall"}</p>
<p class="Normal"><a href="{$infoDid_materialeLink|escape:"htmlall"}">{$infoDid_materialeLink|escape:"htmlall"}</a> </p>
{/if}
		
{if $infoDid_modalitaInfo!=""}
<p class="NormalC">{$infoDid_langModalitaInfo|escape:"htmlall"}</p>
<p class="Normal">{$infoDid_modalitaInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_modalitaLink!=""}
<p class="NormalC">{$infoDid_langModalitaLink|escape:"htmlall"}</p>
<p class="Normal"><a href="{$infoDid_modalitaLink|escape:"htmlall"}">{$infoDid_modalitaLink|escape:"htmlall"}</a> </p>
{/if}
		
{if $infoDid_appelliInfo!=""}
<p class="NormalC">{$infoDid_langAppelliInfo|escape:"htmlall"}</p>
<p class="Normal">{$infoDid_appelliInfo|escape:"htmlall"}</p>
{/if}
{if $infoDid_appelliLink!=""}
<p class="NormalC">{$infoDid_langAppelliLink|escape:"htmlall"}</p>
<p class="Normal"><a href="{$infoDid_appelliLink|escape:"htmlall"}">{$infoDid_appelliLink|escape:"htmlall"}</a> </p>
{/if}
--
<p class="Normal" align="center">{$infoDid_langAppelliUniwex|escape:"htmlall"}</p>

</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}