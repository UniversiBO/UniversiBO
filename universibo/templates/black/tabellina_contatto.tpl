	<!--{$username|escape:"html"}-->
		<table summary="{$username|escape:"html"}" width="100%" border="0" cellspacing="0" cellpadding="0" alt="tabella con le informazioni su {$username|escape:"html"}">
			<tr bgcolor="#000099"> 
				<td colspan="2">
					<table summary="{$username|escape:"html"} 2" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
							<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr bgcolor="#000050"> 
				<td colspan="2" align="center" class="Titolo">{$username|escape:"html"}</td>
			</tr>
			<tr bgcolor="#000099" align="center"> 
				<td colspan="2"><img src="tpl/black/invisible.gif" width="1" height="2" alt="" /></td>
			</tr>
			<tr bgcolor="#000032">
				<td class="Normal" align="center">&nbsp;<br /><img src="{$contacts_path}{$id_utente}_{$foto|escape:"html"}" alt="foto di {$username|escape:"html"}" width="60" height="80"><br />&nbsp;</td>
          		<td class="Normal">&nbsp;<br />{$intro|escape:"html"}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000099" align="center"> 
				<td colspan="2"><img src="tpl/black/invisible.gif" width="1" height="2" alt="" /></td>
			</tr>

			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">&nbsp;<br />ruolo principale:</td>
				<td class="Normal">&nbsp;<br />{$ruolo|escape:"html"}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">e-mail:</td>
				<td class="Normal"><a href="mailto:{$email|escape:"html"}">{$email|escape:"html"}</a><br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">recapito telefonico:</td>
				<td class="Normal">{$recapito|escape:"html"}<br />&nbsp;</td>
			</tr>
			<tr bgcolor="#000032">
				<td width="30%" class="NormalC" valign="top" align="left">obiettivi:</td>			
                <td class="Normal">&quot;{$obiettivi|escape:"html"}&quot;</td>
          	</tr>
			<tr bgcolor="#000032"><td colspan=2>&nbsp;</td></tr>

			<tr bgcolor="#000099"> 
				<td colspan="2">
					<table summary="{$username|escape:"html"} 3" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
							<td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
						</tr>
					</table>
				</td>
			</tr>


		</table>
		