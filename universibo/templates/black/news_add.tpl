{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}
<table width="95%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td align="center"><p class="Titolo">&nbsp;<br />Aggiungi una nuova notizia<br />&nbsp;</p>
{include file=avviso_notice.tpl}
</td></tr>

<form method="post">
<table width="98%" cellspacing="0" cellpadding="2" border="0">
<tr>
<td class="News" align="right" valign="top">Titolo:</td>
<td><input type="text" id="f7_titolo" name="f7_titolo" size="65" maxlength="130" value="{$f7_titolo|escape:htmlall}" /></td>

</tr>
<tr>
<td class="News" align="right" valign="top">Data Inserimento:<br />(GG-MM-AAAA)</td>
<td class="News">
<input type="text" id="f7_data_ins_gg" name="f7_data_ins_gg" size="2" maxlength="2" value="{$f7_data_ins_gg|escape:htmlall}" /> -
<input type="text" id="f7_data_ins_mm" name="f7_data_ins_mm" size="2" maxlength="2" value="{$f7_data_ins_mm|escape:htmlall}" /> -
<input type="text" id="f7_data_ins_aa" name="f7_data_ins_aa" size="4" maxlength="4" value="{$f7_data_ins_aa|escape:htmlall}" />
</td>
</tr>
<tr>
<td class="News" align="right" valign="top">Orario Inserimento:<br />(hh-mm)</td>

<td class="News">
<input type="text" id="f7_data_ins_ora" name="f7_data_ins_ora" size="2" maxlength="2" value="{$f7_data_ins_ora|escape:htmlall}" /> :
<input type="text" id="f7_data_ins_min" name="f7_data_ins_min" size="2" maxlength="2" value="{$f7_data_ins_min|escape:htmlall}" />
</td>
</tr>
<tr>
<td class="News" align="right" valign="top"> Notizia:<br />(max 2500 <br />caratteri)</td>

<td><textarea cols="50" rows="10" id="f7_testo" name="f7_testo">{$f7_testo|escape:htmlall}</textarea></td>
</tr>
<tr>
<td class="News" align="right" valign="top">Attiva Scadenza:</td>
<td><input type="checkbox" {if $f7_scadenza=="true"}checked="checked" {/if} id="f7_scadenza" name="f7_scadenza" /></td>
</tr>
<tr>
<td class="News" align="right" valign="top">Data Scadenza:<br />(GG-MM-AAAA)</td>
<td class="News">

<input type="text" id="f7_data_scad_gg"  name="f7_data_scad_gg" size="2" maxlength="2" value="{$f7_data_scad_gg|escape:htmlall}" /> -
<input type="text" id="f7_data_scad_mm"  name="f7_data_scad_mm" size="2" maxlength="2" value="{$f7_data_scad_mm|escape:htmlall}" /> -
<input type="text" id="f7_data_scad_aa"  name="f7_data_scad_aa" size="4" maxlength="4" value="{$f7_data_scad_aa|escape:htmlall}" />
</td>
</tr>
<tr>
<td class="News" align="right" valign="top">Orario Scadenza:<br />(hh-mm)</td>
<td class="News">
<input type="text" id="f7_data_scad_ora"  name="f7_data_scad_ora" size="2" maxlength="2" value="{$f7_data_scad_ora|escape:htmlall}" /> :
<input type="text" id="f7_data_scad_min"  name="f7_data_scad_min" size="2" maxlength="2" value="{$f7_data_scad_min|escape:htmlall}" />
</td>
</tr>
<tr>
<td class="News" align="right" valign="top"> Invia il messaggio come urgente:</td>
<td><input type="checkbox" id="f7_urgente" {if $f7_urgente=="true"}checked="checked" {/if} name="f7_urgente" /></td>
</tr>
<tr>
<td class="Normal" colspan="2" align="center">&nbsp;<br /><p class="Normal">La notizia verr&agrave; inserita negli argomenti:<br />
</td>
</tr>
{foreach item=item name=canali from=$f7_canale}
<tr>
<td class="Normal" colspan="2" valign="top">&nbsp;&nbsp;<input type="checkbox" id="f7_canale_{$smarty.foreach.canali.iteration}" {if $item.spunta=="true"}checked="checked" {/if}name="f7_canale[]" />&nbsp;&nbsp;&nbsp;{$item.nome_canale}</td>
</tr>
{/foreach}
<tr>
<td colspan="2" align="center">
<input type="submit" id="" name="f7_submit" size="20" value="Invia"></td>
</tr>
</table></FORM>


{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}