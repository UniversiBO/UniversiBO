{if $showFileStudentiCommenti_langCommentiAvailableFlag == "true"}
	{foreach from=$showFileStudentiCommenti_commentiList item=temp_commenti}
	<div class="Commento">
	    <p>Autore del commento: <a href="{$temp_commenti.userLink|escape:"htmlall"}">{$temp_commenti.userNick}</a></p>
		<p>Voto proposto: {$temp_commenti.voto}</p>
		<p>Commento: {$temp_commenti.commento}</p>
	</div>
	{/foreach}
{else}
<p> Non esistono commenti per questo file.</p>
{/if}