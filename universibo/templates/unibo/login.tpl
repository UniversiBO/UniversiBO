{include file=header_index.tpl}

<div class="titoloPagina">
<h2>Login errato!</h2>
</div>

{include file=avviso_notice.tpl}

<form action="{$common_receiverUrl}?do=Login" name="form1" method="post">
	<p>Username:<input type="text" name="f1_username" size="9" maxlength="25" style="width: 120px" value="{$f1_username_value|escape:"htmlall"}" /></p>
	<p>Password:<input type="password" name="f1_password" size="9" maxlength="25" style="width: 120px" value="{$f1_password_value|escape:"htmlall"}" /></p>
	<input type="hidden" name="f1_resolution" value="" />
	<input type="hidden" name="f1_referer" value="{$f1_referer_value|escape:"htmlall"}" />
	<p><input name="f1_submit" type="submit" value="Entra" onclick="document.form1.f1_resolution.value = screen.width;" /></td>
</form>

{include file=footer_index.tpl}