{if $indice}
	<div class="elenco">
	{foreach from=$showHelpId_langArgomento item=temp_helpid}
	<p class="{cycle name=index values="even,odd"}">&nbsp<a href="#{$temp_helpid.id|escape:"htmlall"}"> {$temp_helpid.titolo|escape:"htmlall"}</a></p>
	{/foreach}
	</div>
{/if}
<div class="help_generale">
{foreach from=$showHelpId_langArgomento item=temp_helpid}
	<h4 id="{$temp_helpid.id|escape:"htmlall"}">&nbsp;{$temp_helpid.titolo|escape:"htmlall"}</h4>
	<span><a href="">torna su</a> </span>
	<p>{$temp_helpid.contenuto|escape:"htmlall"|bbcode2html|nl2br}</p>
{/foreach}
</div>
