<br />
<div class="boxCommento">
	    <p>Autore del commento: <a href="{$showFileStudentiCommenti_commento.userLink|escape:"htmlall"}">{$showFileStudentiCommenti_commento.userNick}</a></p>
		<p>Voto proposto: {$showFileStudentiCommenti_commento.voto}</p>
		<p>Commento: {$showFileStudentiCommenti_commento.commento|escape:"htmlall"|bbcode2html|ereg_replace:"[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]":"<a href=\"\\0\" target=\"_blank\">\\0</a>"|ereg_replace:"[^<>[:space:]]+[[:alnum:]/]@[^<>[:space:]]+[[:alnum:]/]":"<a href=\"mailto:\\0\" target=\"_blank\">\\0</a>"|nl2br}</p>
</div>
<br />
