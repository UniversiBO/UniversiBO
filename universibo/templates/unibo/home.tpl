{include file=header_index.tpl}

<div id="home">
<h1>{$home_langWelcome|escape:"htmlall"}</h1>
<p>{$home_langWhatIs|escape:"htmlall"}</p>
<p>{$home_langMission|escape:"htmlall"}</p>
</div>
	
{* qui ci va il link addMyUniversibo *}
<hr />					
{include file=News/latest_news.tpl}

<hr />
{include file=Files/show_info.tpl}

{include file=footer_index.tpl}
