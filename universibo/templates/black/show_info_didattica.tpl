{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="" align="center">
<tr><td class="Normal">&nbsp;<br /> 
<p align="center" class="Titolo">{$infoDid_title|escape:"htmlall"}</p>

&nbsp;<br />&nbsp;<br />

</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}