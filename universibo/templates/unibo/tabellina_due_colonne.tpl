{* dato un array di link in formato bbcode lo dispone in una tabella di due colonne*}

{*parametro: array $arrayToShow*}

<div class="tbl2col">
{section loop=$arrayToShow name=allitem} 

{if %allitem.last% && %allitem.index% is even}
	<p class="lastRow">{$arrayToShow[allitem]|escape:"htmlall"|bbcode2html}</p>
{elseif %allitem.last% && %allitem.index% is odd}
	<p class="lastRow,lastCol">{$arrayToShow[allitem]|escape:"htmlall"|bbcode2html}</p>
{else}
	{if %allitem.index% is odd}
	 	<p class="lastCol">{$arrayToShow[allitem]|escape:"htmlall"|bbcode2html}</p>
	{elseif %allitem.index% is even}
		<p class="lastCol">{$arrayToShow[allitem]|escape:"htmlall"|bbcode2html}</p>
	{/if}	
{/if}
{/section}

</div>