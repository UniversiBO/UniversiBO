{include file=header_index.tpl}
<h3>Gestione Links</h3>
<p><a href="{$add_link_uri}">Aggiungi un link</a></p>
{include file=Links/show_links_extended.tpl}

<p><a href="{$common_canaleURI|escape:"htmlall"}">Torna&nbsp;{$common_langCanaleNome}</a></p>

{include file=footer_index.tpl}