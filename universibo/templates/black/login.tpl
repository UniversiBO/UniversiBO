

{$error_notice}
<form action="{$common_receiverUrl}?do=Login" name="form1" method="post">
<table width="90%"  border="0" cellspacing="0" cellpadding="0" align="center" summary="">
<tr> 
<td><img src="tpl/black/login_18.gif" width="69" height="22" alt="Login" /></td>
</tr>
<tr align="center"> 
<td class="Piccolo">&nbsp;<br />Username:<br /><input type="text" name="f1_username" size="9" maxlength="25" style="width: 120px" value="{$f1_username_value}" /><br />
Password:<br /><input type="password" name="f1_password" size="9" maxlength="25" style="width: 120px" value="{$f1_password_value}" /><br />
<input type="hidden" name="f1_resolution" value="" />
<input name="f1_submit" type="submit" value="Entra" onclick="document.form1.f1_resolution.value = screen.width;" /></td>
</tr>
</table></form>
