{include file=header_index.tpl}

<div class="titoloPagina">
<h2>Scheda dell'utente: {$showUserNickname}</h2>
</div>
<p><span>Email: <a href="mailto:{$showEmailFirstPart}(at){$showEmailSecondPart}">{$showEmailFirstPart}<img src="tpl/unibo/chiocciola.gif" width="9" height="9" alt="(at)" />{$showEmailSecondPart}</a>
{if $showDiritti == 'true'}
	&nbsp;<a href="{$showSettings}">Modifica</a>
{/if}
</span></p>
<div class="elenco">
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
	<tr><td colspan="2"><h3>Ruoli</h3></td></tr>
	{foreach name=ruoli from=$showCanali item=temp_currLink}
	<tr align="left"><td class="{if ($smarty.foreach.ruoli.iteration % 2) == 0}odd{else}even{/if}">
				<p class="{if $smarty.foreach.ruoli.iteration%2 == 0}odd{else}even{/if}"><a href="{$temp_currLink.uri}">{$temp_currLink.label|escape:"htmlall"}</a>
		</td><td class="{if $smarty.foreach.ruoli.iteration%2 == 0}odd{else}even{/if}"><span>{$temp_currLink.categoria}
				{if $temp_currLink.ruolo=="R"},<img src="tpl/unibo/icona_3_r.gif" width="9" height="9" alt="Referente" />{/if}
				{if $temp_currLink.ruolo=="M"},<img src="tpl/unibo/icona_3_m.gif" width="9" height="9" alt="Moderatore" />{/if}
				{if $showDiritti == 'true'}
					&nbsp;<img src="tpl/unibo/esame_myuniversibo_del.gif" width="15" height="15" alt="" />&nbsp;<a href="{$temp_currLink.rimuovi}">Rimuovi dal tuo MyUniversiBO</a>
				{/if}</span></p>
	</td></tr>
	{/foreach}
	{if $smarty.foreach.ruoli.total == 0}<tr><td>Nessun ruolo</td></tr>{/if}
</table>
	</div>
</p>
{include file=footer_index.tpl}