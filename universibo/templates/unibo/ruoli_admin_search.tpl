{include file=header_index.tpl}

<div class="titoloPagina">
<h2>{$ruoliAdminSearch_langAction|escape:"htmlall"|nl2br}</h2>
</div>
{include file=avviso_notice.tpl}
{foreach from=$ruoliAdminSearch_users key=temp_key item=temp_currGroup}
	<p>{$temp_key|escape:"htmlall"}</p>
	{foreach from=$temp_currGroup item=temp_currLink}
		<p><a href="{$temp_currLink.utente_link|escape:"htmlall"}">{$temp_currLink.label|escape:"htmlall"}</a></p>
		{if $temp_currLink.ruolo=="R"}&nbsp;<img src="tpl/unibo/icona_3_r.gif" width="9" height="9" alt="Referente" />&nbsp;Referente{/if}
		{if $temp_currLink.ruolo=="M"}&nbsp;<img src="tpl/unibo/icona_3_m.gif" width="9" height="9" alt="Moderatore" />&nbsp;Moderatore{/if}
		<p><a href="{$temp_currLink.edit_link|escape:"htmlall"}">Modifica</a></p>
	{/foreach}
{/foreach}
<h3>{$ruoliAdminSearch_langSearch|escape:"htmlall"}</h3>

<form method="post">
	<p><label for="f16_username">Cerca per username: </label>
		<input name="f16_username" id="f16_username" type="text" value="" /></p>
	<p><label for="f16_email">Cerca per e-mail: </label>
		<input name="f16_email" id="f16_email" type="text" value="" /></p>
	<p><input class="submit" name="f16_submit" id="f16_submit" type="submit" value="Cerca" /></p>
</form>
<p><a href=" Torna {$common_langCanaleUri|escape:"htmlall"|nl2br}">Torna {$common_langCanaleNome|escape:"htmlall"|nl2br}</a></p>
<hr />
<p>{include file=Help/topic.tpl showTopic_topic=$showTopic_topic idsu=$showTopic_topic.reference}</p>
{include file=footer_index.tpl}