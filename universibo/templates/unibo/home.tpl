{include file=header_index.tpl}

<div id="home">
<h1>{$home_langWelcome|escape:"htmlall"}</h1>
<p>{$home_langWhatIs|escape:"htmlall"}</p>
<p>{$home_langMission|escape:"htmlall"}</p>
<p>
{if $common_canaleMyUniversiBO == "remove"}
	<img src="tpl/black/esame_myuniversibo_del.gif" width="15" height="15" alt="" />&nbsp;
{else}<img src="tpl/black/esame_myuniversibo_add.gif" width="15" height="15" alt="" />&nbsp;
{/if}<a href="{$common_canaleMyUniversiBOUri|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a></p>
</div>
	
{* qui ci va il link addMyUniversibo *}

<hr />					
{include file=News/latest_news.tpl}

{include file=footer_index.tpl}
