{include file=header_index.tpl}

{include file=avviso_notice.tpl}


<h2>{$fac_facTitle|escape:"htmlall"} - {$fac_facCodice}<h2>
<p><a href="{$fac_facLink|escape:"htmlall"}" target="_blank">Apri il sito ufficiale della facoltá</a></p>
<p><a href="{$common_canaleMyUniversiBO|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a></p>
<p>{$fac_langList|escape:"htmlall"}</p>
<hr />
<div class="elenco">
{foreach from=$fac_list item=temp_fac}
	
	<h3>{$temp_fac.name|escape:"html"|upper}</h3>
	
	{foreach from=$temp_fac.list item=temp_cdl}
	<p class="{cycle values="even,odd"}"><a href="{$temp_cdl.link}">{$temp_cdl.cod|escape:"htmlall"} - {$temp_cdl.name|escape:"htmlall"}</a></p>
  {/foreach} 
{/foreach}
<hr />
{include file=News/latest_news.tpl}
</div>
{include file=footer_index.tpl}