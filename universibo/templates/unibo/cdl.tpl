{include file=header_index.tpl}

{include file=avviso_notice.tpl}

<div class="titoloPagina">
<h2>{$cdl_cdlTitle|escape:"htmlall"} - {$cdl_cdlCodice|escape:"htmlall"}</h2>
{if $common_langCanaleMyUniversiBO != '' }
	<div class="comandi">
	{if $common_canaleMyUniversiBO == "remove"}
		<img src="tpl/black/esame_myuniversibo_del.gif" width="15" height="15" alt="" />&nbsp;
	{else}<img src="tpl/black/esame_myuniversibo_add.gif" width="15" height="15" alt="" />&nbsp;
	{/if}<a href="{$common_canaleMyUniversiBOUri|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a></div>
{/if}
<p>{$cdl_langYear|escape:"htmlall"}<p/>
<a href="{$cdl_prevYearUri|escape:"htmlall"}">{$cdl_prevYear|escape:"htmlall"}</a>&nbsp;&lt;&lt;
&nbsp;&nbsp;{$cdl_thisYear|escape:"htmlall"}&nbsp;&nbsp;
&gt;&gt;&nbsp;<a href="{$cdl_nextYearUri|escape:"htmlall"}">{$cdl_nextYear|escape:"htmlall"}</a> </p>
<h4>{$cdl_langList|escape:"htmlall"}</h4>
</div>
<hr />
{foreach from=$cdl_list item=temp_anno}
<div class="elenco">
	<h3>{$temp_anno.name|escape:"html"|upper}</h3>
	{foreach name=t_ciclo from=$temp_anno.list item=temp_ciclo}
		{if $smarty.foreach.t_ciclo.last}<div class="lastElemento">{else}<div>{/if}
		{foreach name=elenco_ins from=$temp_ciclo.list item=temp_ins}
			<p class="{if $smarty.foreach.elenco_ins.iteration%2 == 0}odd{else}even{/if}">&nbsp;{$temp_ciclo.ciclo|escape:"htmlall"}&gt;&nbsp;
			<a href="{$temp_ins.uri|escape:"htmlall"}">{$temp_ins.name|escape:"htmlall"} - {$temp_ins.nomeDoc|lower|ucwords|escape:"htmlall"}</a> &nbsp; <a href="{$temp_ins.forumUri|escape:"htmlall"}" alt="{$cdl_langGoToForum|escape:"htmlall"}"><img src="tpl/unibo/forum_omini_piccoli.gif" width="11" height="12" alt="{$cdl_langGoToForum|escape:"htmlall"}" border="0"/></a>&nbsp;</p>
		{/foreach}
		</div> 
	{/foreach} 
</div>
{/foreach}
<hr />
{include file=News/latest_news.tpl}

{include file=footer_index.tpl}