{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="98%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="Normal"><br />
<p class="Titolo">Benvenuto in UniversiBO!</p>
<p>
Questo &egrave; il nuovo portale sperimentale per la didattica, dedicato agli
studenti dell'universit&agrave; di Bologna.</p>
<p>
L'obiettivo verso cui &egrave; tracciata la rotta delle iniziative e dei
servizi che trovate su questo portale &egrave; di &quot;aiutare gli studenti
ad aiutarsi tra loro&quot;, fornirgli un punto di riferimento centralizzato in 
cui prelevare tutte le informazioni didattiche riguardanti i propri corsi di
studio e offrire un mezzo di interazione semplice e veloce con i docenti che
partecipano all'iniziativa.</p>

&nbsp;<br />
 <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
 <tr bgcolor="#000099"> 
 <td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
 <td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
 </tr>
 </table>
&nbsp;<br />


Qui vanno incluse le news


</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}

