{include file=header_index.tpl}
<h2>Recupera Password</h2>
{include file=avviso_notice.tpl}

<form action="index.php?do=NewPasswordStudente&amp;{$common_pageTypeExt|escape:"htmlall"}" id="f5" method="post">
	<p>{$newPasswordStudente_langInfoNewPassword|escape:"htmlall"|bbcode2html|nl2br}</p>
	<p><label for="f5_username">{$newPasswordStudente_langUsername|escape:"htmlall"}</label>&nbsp;
		<input type="text" name="f5_username" id="f5_username" size="20" maxlength="25" value="{$f5_username|escape:"html"}" /></p>
	<p><label for="f5_ad_user">{$newPasswordStudente_langMail|escape:"htmlall"}</label>&nbsp;
		<input type="text" name="f5_ad_user" id="f5_ad_user" size="20" maxlength="30" value="{$f5_ad_user|escape:"html"}" />{$newPasswordStudente_domain|escape:"htmlall"}</p>
	</p><label for="f5_password">{$newPasswordStudente_langPassword|escape:"htmlall"}</label>&nbsp;
		<input type="password" name="f5_password" id="f5_password" size="20" maxlength="50" value="{$f5_password|escape:"html"}" /></p>
	<p><input class="submit" type="submit" name="f5_submit" id="f5_submit" value="{$f5_submit|escape:"htmlall"}"></p>
	<p>{$newPasswordStudente_langHelp|escape:"htmlall"|bbcode2html|nl2br}</p>
</form>

{include file=footer_index.tpl}