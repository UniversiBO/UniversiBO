{include file=header_index.tpl}

<div class="titoloPagina">
<h2>{$showAccessibility_langTitleAlt|escape:"htmlall"}</h2>
{* Decommentare questa parte se si vuole che sia possibile aggiungere questa pagina al my universibo NB il comando corrispondente deve ereditare da canale command
{if $common_langCanaleMyUniversiBO != '' }
	<div class="comandi">
	{if $common_canaleMyUniversiBO == "remove"}<img src="tpl/unibo/esame_myuniversibo_del.gif" width="15" height="15" alt="" />&nbsp;{else}<img src="tpl/unibo/esame_myuniversibo_add.gif" width="15" height="15" alt="" />&nbsp;{/if}<a href="{$common_canaleMyUniversiBOUri|escape:"htmlall"}">{$common_langCanaleMyUniversiBO|escape:"htmlall"}</a></div>
{/if}
*}
</div>

<p>Nello sviluppo di UniversiBO, si &egrave; posta particolare attenzione nel
renderlo il più accessibile possibile, poich&eacute;
convinti che le informazioni debbano essere fruibili da chiunque a
prescindere dalle proprie capacità.</p>
<p>In tale ottica, per facilitare la navigazione sono stati definiti
degli <lang="en">accesskey</lang>, ovvero dei tasti di accesso rapido
che permettono di accedere direttamente a determinate parti delle pagine.
</p><p>Ecco la lista dei tasti implementati:</p>
<dl>
<dt>1</dt><dd>vai all'homepage</dd>
<dt>2</dt><dd>vai al forum (mmm, nella pagina degli insegnamenti quale dei due
link al forum?)</dd>
<dt>3</dt><dd>vai al contenuto principale della pagina</dd>
<dt>4</dt><dd>vai al myuniversibo</dd>
<dt>5</dt><dd>vai al menù di navigazione tra le sezioni</dd>
<dt>0</dt><dd>vai a questa pagina sull'accessibilità</dd>
</dl>
<p>
L'attivazione di questi tasti di accesso dipende sia dal vostro
sistema operativo e dal vostro <lang="en">browser</lang>:
</p>
<dl>
<dt>IE Windows, IBM Home Page Reader : </dt><dd><alt + [accesskey] + Invio </dd>
<dt>Mozilla, Netscape 6+, K-Meleon, FireFox Windows: </dt><dd>Alt+[accesskey]</dd>
<dt>Opera 7 Windows, Macintosh, Linux : </dt><dd>Esc + Shift e [accesskey]</dd>
<dt>MSIE Macintosh : </dt><dd>Ctrl e [accesskey], poi Invio</dd>
<dt>Safari 1.2 Macintosh : </dt><dd>Ctrl e [accesskey]</dd>
<dt>Mozilla, Netscape Macintosh : </dt><dd>Ctrl e [accesskey]</dd>
<dt>Galeon/Mozilla/FireFox Linux : </dt><dd>Alt e [accesskey]</dd>
<dt>Konqueror 3.3+ : </dt><dd>Ctrl, e successivamente [accesskey]</dd>
<dt>Handspring Blazer (Treo 600) : </dt><dd>[accesskey]</dd>
</dl>
<p>Netscape 4, Camino, Galeon, Konqueror prima della versione 3.3.0,
Omniweb, Safari prima della versione 1.2, Opera Windows/Linux prima
della versione 7, non supportano i tasti di accesso.</p>
{*<p>Il testo della pagina &egrave; ridimensionabile tramite browser fino ad un
150% circa del testo originale (@TODO verificare)</p>
<p>Per gli utilizzatori di browser testuali o screenreader sono stati
aggiunti dei link che permettono una veloce navigazione tra le aree di
interesse della pagina, del tipo "Vai al contenuto".</p>*}
<p>Si &egrave; cercato inoltre di rispettare il più possibile le linee guide
specificate dal WCAG (@TODO mettere l'acronimo) del W3C.</p>

{include file=footer_index.tpl}
