{if $common_contactsCanaleAvailable|default:"false" =="true"}
{include file=box_begin.tpl}
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
<tr><td colspan="3"><img src="tpl/black/contatti_18.gif" width="90" height="22" alt="{$common_langContactsCanale|escape:"htmlall"}" /></td></tr>
{foreach from=$common_contactsCanale item=temp_currLink}
<tr>
<td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
<td><img src="tpl/black/invisible.gif" width="4" height="2" alt="" /></td>
<td class="Menu" width="100%"><a href="mailto:{$temp_currLink.mail}">{$temp_currLink.label|escape:"htmlall"}</a>
<!--{*if $temp_currLink.ruolo=="R"*}&nbsp;<img src="tpl/black/icona_R.gif" width="15" height="11" alt="Referente" />{*/if*}
{*if $temp_currLink.ruolo=="M"*}&nbsp;<img src="tpl/black/icona_M.gif" width="15" height="11" alt="Moderatore" />{*/if*}
{*if $temp_currLink.new=="true"*}&nbsp;<img src="tpl/black/icona_new.gif" width="21" height="9" alt="!NEW!" />{*/if*}-->
</td>
</tr>
{/foreach}
</table>
{include file=box_end.tpl}
{/if}