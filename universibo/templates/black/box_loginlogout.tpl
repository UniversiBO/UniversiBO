
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr valign="bottom"> 
<td height="12" width="12"><img src="tpl/black/menuTL.gif" width="12" height="12" alt="" /></td>
<td height="12" align="left"><img src="tpl/black/menuT.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="12" alt="" /></td>
</tr>
<tr> 
<td width="12" valign="top"><img src="tpl/black/menuL.gif" width="12" height="67" alt="" /></td>
<td valign="middle" align="center">
{if $common_userLoggedIn=='false'}
<form action="{$common_receiverUrl}?do=Login" name="form1_a" method="post">
<table width="90%"  border="0" cellspacing="0" cellpadding="0" align="center" summary="">
<tr> 
<td><img src="tpl/black/login_18.gif" width="69" height="22" alt="Login" /></td>
</tr>
<tr align="center"> 
<td class="Piccolo">&nbsp;<br />Username:<br /><input type="text" name="f1_username" size="9" maxlength="25" style="width: 120px" /><br />
Password:<br /><input type="password" name="f1_password" size="9" maxlength="25" style="width: 120px" /><br />
<input type="hidden" name="f1_resolution" value="" />
<input name="f1_submit" type="submit" value="Entra" onclick="document.form1_a.f1_resolution.value = screen.width;" /></td>
</tr>
<tr>
<td class="Menu">&nbsp;<br />
{* le funzioni javascript sarebbe meglio metterle in un altro file per scaricarle una volta sola *}
{* inoltre è palloso scrivere le graffe con Smarty che interpreta il template!! *}
<script type="text/javascript" language="JavaScript">
<!--
function universiboPopup(dest)
{ldelim}
	window.open(dest,'','scrollbars=yes,resizable=yes,scrolling=yes,top=20,left=50')
{rdelim}
-->
</script>
<script type="text/javascript" language="JavaScript">
<!--
document.write("<a href=\"javascript:universiboPopup('index.php?do=ShowHome&amp;pageType=popup');\"><font color=\"#FF0000\">Registrazione Studenti<\/font><\/a><br />");
-->
</script>
<noscript><a href="index.php?do=ShowHome&amp;pageType=popup" target="_popup"><font color="#FF0000">Registrazione Studenti</font></a><br /></noscript>
<script type="text/javascript" language="JavaScript">
<!--
document.write("<a href=\"javascript:universiboPopup('index.php?do=ShowHome&amp;pageType=popup');\">Password smarrita...<\/a><br \/>");
-->
</script>
<noscript><a href="index.php?do=ShowHome&amp;pageType=popup" target="_popup">Password smarrita...</a><br /></noscript>
</td></tr>
</table></form>
{else}
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<form action="{$common_receiverUrl}?do=Logout" name="form2" method="post">
<tr><td class="Normal" valign="center" align="center">&nbsp;<br />
{$common_langWelcomeMsg|escape:"htmlall"|bbcode2html|nl2br} <font class="NormalC">{$common_userUsername|escape:"htmlall"}</font><br />
{$common_langUserLivello|escape:"htmlall"|bbcode2html|nl2br} <font class="NormalC">{$common_userLivello|escape:"htmlall"}</font><br />
&nbsp;<br />
<input name="f2_submit" type="submit" value="LogOut" /><br />&nbsp;
</td></tr>
</form>
</table>
{/if}
</td>
<td width="12" valign="bottom"><img src="tpl/black/menuR.gif" width="12" height="67" alt="" /></td>
</tr>
<tr valign="top"> 
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="12" height="12" alt="" /></td>
<td height="12" align="right"><img src="tpl/black/menuB.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/menuBR.gif" width="12" height="12" alt="" /></td>
</tr>
</table>