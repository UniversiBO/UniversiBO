{if $common_contactsCanaleAvailable|default:"false" =="true"}
{include file=box_begin.tpl}
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
<tr><td colspan="3"><img src="tpl/black/contatti_18.gif" width="90" height="22" alt="{$common_langContactsCanale|escape:"htmlall"}" /></td></tr>
{foreach from=$common_contactsCanale item=temp_currLink}
<tr>
<td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
<td><img src="tpl/black/invisible.gif" width="4" height="2" alt="" /></td>
<td class="Menu" width="100%"><a href="{$temp_currLink.utente_link}">{$temp_currLink.label|escape:"htmlall"}</a>
{if $temp_currLink.ruolo=="R"}&nbsp;<img src="tpl/black/icona_3_r.gif" width="9" height="9" alt="Referente" />{/if}
{if $temp_currLink.ruolo=="M"}&nbsp;<img src="tpl/black/icona_3_m.gif" width="9" height="9" alt="Moderatore" />{/if}
</td>
</tr>
{/foreach}
</table>
{include file=box_end.tpl}
{/if}