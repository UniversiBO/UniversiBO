{include file=header_index.tpl}

<h4>{$ins_title|escape:"htmlall"}</h4>
<p><a href="{$common_canaleMyUniversiBO|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a></p>
<hr />
{include file=News/latest_news.tpl}

{include file=Files/show_file_titoli.tpl}

<hr/>

{include file=footer_index.tpl}