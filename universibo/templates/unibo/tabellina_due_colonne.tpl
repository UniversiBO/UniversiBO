{* dato un array di link in formato bbcode lo dispone in una tabella di due colonne*}

{*parametro: array $arrayToShow*}

<div class="tbl2col">
{section loop=$arrayToShow name=allitem} 

{if $smarty.section.allitem.last && $smarty.section.allitem.index is even}
	<div><p class="lastRow">{$arrayToShow[allitem]|escape:"htmlall"|bbcode2html}</p></div>
{elseif $smarty.section.allitem.last && $smarty.section.allitem.index is odd}
	<p class="lastColRow">{$arrayToShow[allitem]|escape:"htmlall"|bbcode2html}</p></div>
{else}
	{if $smarty.section.allitem.index is odd}
	 	<p class="lastCol">{$arrayToShow[allitem]|escape:"htmlall"|bbcode2html}</p></div>
	{elseif $smarty.section.allitem.index is even}
		<div><p class="leftCol">{$arrayToShow[allitem]|escape:"htmlall"|bbcode2html}</p>
	{/if}	
{/if}
{/section}

</div>