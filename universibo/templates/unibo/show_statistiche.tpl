{include file=header_index.tpl}

<h2>{$ShowStatistiche_titolo}</h2>


{foreach name=extern from=$ShowStatistiche_elencoFilePerMese item=row}
{if $smarty.foreach.extern.first}<ul>{/if}
<li>{$row.anno} {$row.mese} {$row.somma} </li>
{if $smarty.foreach.extern.last}</ul>{/if}
{foreachelse}<p>Nessun risultato da visualizzare </p>
{/foreach}


{include file=footer_index.tpl}