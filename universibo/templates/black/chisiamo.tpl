{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table summary="chi siamo"width="90%" border="0" cellspacing="0" cellpadding="0">
<tr><td class="Normal" align="left">
		<div align="center">&nbsp;<br /><img src="tpl/black/chi_siamo_30.gif" width="179" height="39" alt="{$contacts_altTitle|escape:"html"}" /></div>
        
      <p>
      {$contacts_intro|escape:"html"}      
      </p>
      

	
{foreach from=$contacts_personal item=curr_people}
	<!--{$curr_people.nick|escape:"html"}-->
		<table summary="{$curr_people.nick|escape:"html"}" width="100%" border="0" cellspacing="0" cellpadding="0" alt="tabella con le informazioni su {$curr_people.nick|escape:"html"}">
			<tr bgcolor="#000099"> 
				<td colspan="2">
					<table summary="{$curr_people.nick|escape:"html"} 2" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
							<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr bgcolor="#000050"> 
				<td colspan="2" align="center" class="Titolo">{$curr_people.nick|escape:"html"}</td>
			</tr>
			<tr bgcolor="#000099" align="center"> 
				<td colspan="2"><img src="tpl/black/invisible.gif" width="1" height="2" alt="" /></td>
			</tr>
			<tr bgcolor="#000032">
          		<td colspan="2" class="Normal">&nbsp;<br />{$curr_people.intro|escape:"html"}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000099" align="center"> 
				<td colspan="2"><img src="tpl/black/invisible.gif" width="1" height="2" alt="" /></td>
			</tr>

			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">&nbsp;<br />ruolo principale:</td>
				<td class="Normal">&nbsp;<br />{$curr_people.ruolo|escape:"html"}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">e-mail:</td>
				<td class="Normal"><a href="mailto:{$curr_people.email|escape:"html"}">{$curr_people.email|escape:"html"}</a><br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">recapito telefonico:</td>
				<td class="Normal">{$curr_people.recapito|escape:"html"}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">obiettivi:</td>			
                <td class="Normal">&quot;{$curr_people.obiettivi|escape:"html"}&quot;</td>
          	</tr>
			<tr bgcolor="#000032"><td colspan=2>&nbsp;</td></tr>

			<tr bgcolor="#000099"> 
				<td colspan="2">
					<table summary="{$curr_people.nick|escape:"html"} 3" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
							<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
						</tr>
					</table>
				</td>
			</tr>


		</table>
		
		<p>&nbsp;</p>	

	
{/foreach}

</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}