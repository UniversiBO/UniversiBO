{include file=header_index.tpl}

<h2>Registrazione Studenti</h2>

{include file=avviso_notice.tpl}

<form action="index.php?do=RegStudente&amp;{$common_pageTypeExt|escape:"htmlall"}" id="f4" method="post">
	<p>{$regStudente_langInfoReg|escape:"htmlall"|bbcode2html|nl2br}</p>
	<p>&nbsp;<label for="f4_ad_user">{$regStudente_langMail|escape:"htmlall"}</label>&nbsp;
		<input type="text" name="f4_ad_user" id="f4_ad_user" size="20" maxlength="30" value="{$f4_ad_user|escape:"html"}" />{$regStudente_domain|escape:"htmlall"}</p>
	<p><label for="f4_password">{$regStudente_langPassword|escape:"htmlall"}</label>&nbsp;
		<input type="password" name="f4_password" id="f4_password" size="20" maxlength="50" value="{$f4_password|escape:"html"}" /></p>
	<p>&nbsp;&nbsp;{$regStudente_langInfoUsername|escape:"htmlall"|bbcode2html|nl2br}</p>
	<p>&nbsp;<label for="f4_username">{$regStudente_langUsername|escape:"htmlall"}</label>&nbsp;
		<input type="text" name="f4_username" id="f4_username" size="20" maxlength="25" value="{$f4_username|escape:"html"}" /></p>
	<p>&nbsp;<label for="f4_regolamento">{$regStudente_langReg|escape:"htmlall"}</label>
		<textarea name="f4_regolamento" id="f4_regolamento" rows="5" cols="60"  wrap="phisical" readonly="readonly">{$f4_regolamento|escape:"htmlall"}</textarea></p>
	<p>&nbsp;<label for="f4_privacy">{$regStudente_langPrivacy|escape:"htmlall"}</label>
		<textarea name="f4_privacy" id="f4_privacy" rows="5" cols="60" readonly="readonly" >{$f4_privacy|escape:"htmlall"}</textarea></p>
	<p><input type="checkbox" name="f4_confirm" id="f4_confirm" />&nbsp;&nbsp;<label for="f4_confirm"><strong>Confermo di aver letto il regolamento</strong></label>&nbsp;</p>
	<p>&nbsp;<input type="submit" name="f4_submit" id="f4_submit" value="{$f4_submit|escape:"htmlall"}"></p>
	<p>&nbsp;{$regStudente_langHelp|escape:"htmlall"|bbcode2html|nl2br}</p>
<hr>
{include file=Help/topic.tpl showTopic_topic=$showTopic_topic idsu=$showTopic_topic.reference}

{include file=footer_index.tpl}