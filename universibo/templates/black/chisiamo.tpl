{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table summary="chi siamo"width="90%" border="0" cellspacing="0" cellpadding="0">
<tr><td class="Normal" align="left">
		<div align="center">&nbsp;<br /><img src="tpl/black/chi_siamo_30.gif" width="179" height="39" alt="{$contacts_altTitle}" /></div>
        
      <p>
      {$contacts_intro|escape}      
      </p>
      
{section name=data loop=$contacts_personal}
	
	
	<!--{$contacts_personal[data].nick|escape}-->
		<table summary="{$contacts_personal[data].nick|escape}" width="100%" border="0" cellspacing="0" cellpadding="0" alt="tabella con le informazioni su {$contacts_personal[data].nick|escape}">
			<tr bgcolor="#000099"> 
				<td colspan="2">
					<table summary="{$contacts_personal[data].nick|escape} 2" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
							<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr bgcolor="#000050"> 
				<td colspan="2" align="center" class="Titolo">{$contacts_personal[data].nick|escape}</td>
			</tr>
			<tr bgcolor="#000099" align="center"> 
				<td colspan="2"><img src="tpl/black/invisible.gif" width="1" height="2" alt="" /></td>
			</tr>
			<tr bgcolor="#000032">
          		<td colspan="2" class="Normal">&nbsp;<br />{$contacts_personal[data].intro|escape}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000099" align="center"> 
				<td colspan="2"><img src="tpl/black/invisible.gif" width="1" height="2" alt="" /></td>
			</tr>

			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">&nbsp;<br />ruolo principale:</td>
				<td class="Normal">&nbsp;<br />{$contacts_personal[data].ruolo|escape}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">e-mail:</td>
				<td class="Normal"><a href="mailto:{$contacts_personal[data].e-mail|escape}">{$contacts_personal[data].e-mail|escape}</a><br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">recapito telefonico:</td>
				<td class="Normal">{$contacts_personal[data].recapito|escape}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">obiettivi:</td>
				
          <td class="Normal">&quot;{$contacts_personal[data].obiettivi|escape}&quot;</td>
			</tr>

			<tr bgcolor="#000099"> 
				<td colspan="2">
					<table summary="{$contacts_personal[data].nick|escape} 3" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
							<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
						</tr>
					</table>
				</td>
			</tr>


		</table>
		
		<p>&nbsp;</p>	
	
{/section}

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}