{include file=header_index.tpl}

{include file=avviso_notice.tpl}

<h2>Regolamento</h2>
<hr />
<h4>{$rules_langTitle|escape:"htmlall"|bbcode2html}</h4>
<h4>{$rules_langFacSubtitle|escape:"htmlall"|bbcode2html}&nbsp;<br /></h4>
<p>{$rules_langServicesRules|escape:"htmlall"|bbcode2html|nl2br}&nbsp;<br />&nbsp;<br /></p>
<h4>{$rules_langPrivacySubTitle|escape:"htmlall"}</h4>
<p>{$rules_langPrivacy|escape:"htmlall"|bbcode2html|nl2br}&nbsp;<br />&nbsp;<br /></p>
<h4>{$rules_langForum|escape:"htmlall"}</h4>
<p>{$rules_langForumRules|escape:"htmlall"|bbcode2html}&nbsp;<br />&nbsp;<br /></p>
<hr />
{include file=footer_index.tpl}

