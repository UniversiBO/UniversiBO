{include file=header_index.tpl}

{include file=avviso_notice.tpl}

<h2>{$showHelpIndex_langAltTitle|escape:"htmlall"|bbcode2html}</h2>
<hr />
{include file=Help/help_id.tpl showHelpId_langArgomento=$showHelpId_langArgomento indice=true idsu=help}
<hr />
{include file=footer_index.tpl}
