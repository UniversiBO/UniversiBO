{if $showFileStudentiCommenti_langCommentiAvailableFlag == "true"}
	<br />
	{foreach from=$showFileStudentiCommenti_commentiList item=temp_commenti}
	<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" summary="">
	<tr bgcolor="#000099">
	<td>
  		<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  			<tr>
				<td align="left"><img src="tpl/black//rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  				<td align="right"><img src="tpl/black//rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  			</tr>
  		</table>
	</td></tr>
	<tr bgcolor="#000032">
	<td>
	<table width="100%" align="center" border="0" cellspacing="0" cellpadding="5" summary="">
	    <tr><td class="Normal" colspan="2"><span class="NormalC">Autore del commento:</span>&nbsp;<a href="{$temp_commenti.userLink|escape:"htmlall"}">{$temp_commenti.userNick}</a></td></tr>
		<tr><td class="Normal" colspan="2"><span class="NormalC">Voto proposto: </span>{$temp_commenti.voto}</td></tr>
		<tr><td class="Normal" colspan="2"><span class="NormalC">Commento: </span>{$temp_commenti.commento|escape:"htmlall"|bbcode2html|ereg_replace:"[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]":"<a href=\"\\0\" target=\"_blank\">\\0</a>"|ereg_replace:"[^<>[:space:]]+[[:alnum:]/]@[^<>[:space:]]+[[:alnum:]/]":"<a href=\"mailto:\\0\" target=\"_blank\">\\0</a>"|nl2br}</td></tr>
		{if $temp_commenti.dirittiCommento=="true"}
		<tr><td class="Normal"><span>
			<a href="{$temp_commenti.editCommentoLink|escape:"htmlall"}">Modifica il commento</a>&nbsp;
			<a href="{$temp_commenti.deleteCommentoLink|escape:"htmlall"}">Cancella il commento</a>
		</span></td></tr>
		{/if}
		</table>
		</td>
		</tr>
		<tr bgcolor="#000099">
		<td>
  		<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
  			<tr>
				<td align="left"><img src="tpl/black//rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  				<td align="right"><img src="tpl/black//rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  			</tr>
  		</table>
		</td></tr>
		</table>
	<br />
	{/foreach}
{else}
<p> Non esistono commenti per questo file.</p>
{/if}