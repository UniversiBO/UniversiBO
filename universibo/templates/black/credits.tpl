{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

{include file=avviso_notice.tpl}

<table width="90%" border="0" cellspacing="0" cellpadding="5" summary="">
<tr><td class="Normal" align="center">
	&nbsp;<br />
	<img src="tpl/black/credits_30.gif" width="124" height="39" alt="{$showCredits_langTitleAlt|escape:"htmlall"}" /><br />&nbsp;
</td></tr>
<tr>
    <td colspan="2" class="Normal" align="left">
    {$showCredits_langIntro|escape:"htmlall"|bbcode2html|nl2br}<br />&nbsp;
    </td>
</tr>
<tr>
	<td class="Normal">{$showCredits_langDebian|escape:"htmlall"|bbcode2html|nl2br}
	</td>
	<td><img src="img/credits/gnu_linux.gif" width="88" height="31" alt="" /><br />
		<img src="img/credits/debian.png" width="88" height="31" alt="" />
	</td>
</tr>
<tr>
	<td class="Normal">{$showCredits_langApache|escape:"htmlall"|bbcode2html|nl2br}
	</td>
	<td align="center"><img src="img/credits/apache_ssl.gif" width="88" height="31" alt="" />
	</td>
</tr>
<tr>
	<td class="Normal">{$showCredits_langPostgres|escape:"htmlall"|bbcode2html|nl2br}
	</td>
	<td align="center"><img src="img/credits/postgresql.gif" width="88" height="31" alt="" />
	</td>
</tr>
<tr>
	<td class="Normal">{$showCredits_langPhp|escape:"htmlall"|bbcode2html|nl2br}
	</td>
	<td align="center"><img src="img/credits/php.gif" width="88" height="31" alt="" />
	</td>
</tr>
<tr>
	<td class="Normal">{$showCredits_langPhpbb|escape:"htmlall"|bbcode2html|nl2br}
	</td>
	<td align="center"><img src="img/credits/phpmailer.png" width="88" height="31" alt="" /><br />
		<img src="img/credits/phpbb.png" width="88" height="31" alt="" />
	</td>
</tr>
<tr>
	<td class="Normal">{$showCredits_langW3c|escape:"htmlall"|bbcode2html|nl2br}
	</td>
	<td align="center"><img src="img/credits/valid-html401.gif" width="88" height="31" alt="" />
	</td>
</tr>
<tr>
	<td class="Normal">{$showCredits_langSmarty|escape:"htmlall"|bbcode2html|nl2br}
	</td>
	<td align="center"><img src="img/credits/smarty.gif" width="88" height="31" alt="" />
	</td>
</tr>

</table>

<br />


{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}