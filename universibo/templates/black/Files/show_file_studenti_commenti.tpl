{if $showFileStudentiCommenti_langCommentiAvailableFlag == "true"}
	<br />
	{foreach from=$showFileStudentiCommenti_commentiList item=temp_commenti}
	<div class="Commento">
	    <p>Autore del commento: <a href="{$temp_commenti.userLink|escape:"htmlall"}">{$temp_commenti.userNick}</a></p>
		<p>Voto proposto: {$temp_commenti.voto}</p>
		<p>Commento: {$temp_commenti.commento|escape:"htmlall"|bbcode2html|ereg_replace:"[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]":"<a href=\"\\0\" target=\"_blank\">\\0</a>"|ereg_replace:"[^<>[:space:]]+[[:alnum:]/]@[^<>[:space:]]+[[:alnum:]/]":"<a href=\"mailto:\\0\" target=\"_blank\">\\0</a>"|nl2br}</p>
		{if $temp_commenti.dirittiCommento=="true"}
		<p><span>
			<a href="{$temp_commenti.editCommentoLink|escape:"htmlall"}">Modifica il commento</a>&nbsp;
			<a href="{$temp_commenti.deleteCommentoLink|escape:"htmlall"}">Cancella il commento</a>
		</span></p>
		{/if}
	</div>
	<br />
	{/foreach}
{else}
<p> Non esistono commenti per questo file.</p>
{/if}